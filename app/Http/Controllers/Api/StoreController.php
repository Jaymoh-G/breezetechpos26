<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function products(string $tenantSlug): JsonResponse
    {
        $tenant = $this->resolveTenant($tenantSlug);

        $products = Product::with('images', 'category')
            ->orderBy('name')
            ->get();

        return $this->success([
            'tenant' => $tenant,
            'products' => $products,
        ]);
    }

    public function product(string $tenantSlug, string $slug): JsonResponse
    {
        $tenant = $this->resolveTenant($tenantSlug);

        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        return $this->success([
            'tenant' => $tenant,
            'product' => $product,
        ]);
    }

    public function addToCart(string $tenantSlug, Request $request): JsonResponse
    {
        $tenant = $this->resolveTenant($tenantSlug);

        $data = $request->validate([
            'customer.email' => ['required', 'email'],
            'customer.name' => ['required', 'string', 'max:255'],
            'customer.phone' => ['nullable', 'string', 'max:50'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = DB::transaction(function () use ($data) {
            $customer = Customer::firstOrCreate(
                ['email' => $data['customer']['email']],
                [
                    'name' => $data['customer']['name'],
                    'phone' => $data['customer']['phone'] ?? null,
                ]
            );

            $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');

            $subtotal = 0;
            $cart = Cart::create([
                'customer_id' => $customer->id,
                'meta' => [],
            ]);

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;
                if (! $product) {
                    continue;
                }
                $lineTotal = $product->price * $item['qty'];
                $subtotal += $lineTotal;

                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price' => $product->price,
                ]);
            }

            $cart->update(['total' => $subtotal]);

            return $cart->load('items.product', 'customer');
        });

        return $this->success([
            'tenant' => $tenant,
            'cart' => $cart,
        ], 'Items added to cart', 201);
    }

    public function checkout(string $tenantSlug, Request $request): JsonResponse
    {
        $tenant = $this->resolveTenant($tenantSlug);

        $data = $request->validate([
            'cart_id' => ['required', 'exists:carts,id'],
            'payment_method' => ['nullable', 'string', 'max:100'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $cart = Cart::with('items.product', 'customer')->findOrFail($data['cart_id']);

            $subtotal = $cart->items->sum(fn ($item) => $item->price * $item->quantity);
            $order = Order::create([
                'customer_id' => $cart->customer_id,
                'status' => 'pending',
                'total' => $subtotal,
                'meta' => [
                    'payment_method' => $data['payment_method'] ?? null,
                    'cart_id' => $cart->id,
                ],
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                // Reduce stock safely
                $item->product->decrement('stock', $item->quantity);
            }

            // Soft delete or mark cart closed
            $cart->delete();

            // Optional: dispatch email notification
            // Notification::send($cart->customer, new OrderPlacedNotification($order));

            return $order->load('items.product', 'customer');
        });

        return $this->success([
            'tenant' => $tenant,
            'order' => $order,
        ], 'Order placed', 201);
    }

    public function createOrder(string $tenantSlug, Request $request): JsonResponse
    {
        $tenant = $this->resolveTenant($tenantSlug);

        $data = $request->validate([
            'customer.email' => ['required', 'email'],
            'customer.name' => ['required', 'string', 'max:255'],
            'customer.phone' => ['nullable', 'string', 'max:50'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'payment_method' => ['nullable', 'string', 'max:100'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $customer = Customer::firstOrCreate(
                ['email' => $data['customer']['email']],
                [
                    'name' => $data['customer']['name'],
                    'phone' => $data['customer']['phone'] ?? null,
                ]
            );

            $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');

            $subtotal = 0;
            $order = Order::create([
                'customer_id' => $customer->id,
                'status' => 'pending',
                'total' => 0,
                'meta' => [
                    'payment_method' => $data['payment_method'] ?? null,
                ],
            ]);

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;
                if (! $product) {
                    continue;
                }
                $lineTotal = $product->price * $item['qty'];
                $subtotal += $lineTotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price' => $product->price,
                ]);

                // Reduce stock
                $product->decrement('stock', $item['qty']);
            }

            $order->update([
                'total' => $subtotal,
                'status' => 'completed',
                'meta' => array_merge($order->meta ?? [], [
                    'grand_total' => $subtotal,
                ]),
            ]);

            // Optional: dispatch email notification
            // Notification::send($customer, new OrderPlacedNotification($order));

            return $order->load('items.product', 'customer');
        });

        return $this->success([
            'tenant' => $tenant,
            'order' => $order,
        ], 'Order placed', 201);
    }

    protected function resolveTenant(string $slug): Tenant
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        Tenant::setCurrentId($tenant->id);

        return $tenant;
    }
}

