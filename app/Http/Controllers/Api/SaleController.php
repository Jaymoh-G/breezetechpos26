<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function indexToday(): JsonResponse
    {
        $sales = Sale::with(['items.product', 'branch', 'user'])
            ->whereDate('created_at', Carbon::today())
            ->orderByDesc('id')
            ->get();

        return $this->success($sales);
    }

    public function show(int $id): JsonResponse
    {
        $sale = Sale::with(['items.product', 'branch', 'user'])->findOrFail($id);

        return $this->success($sale);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:100'],
        ]);

        $result = DB::transaction(function () use ($data, $user) {
            $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');

            $subtotal = 0;
            $itemsPayload = [];
            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;
                if (! $product) {
                    continue;
                }
                $lineTotal = $product->price * $item['qty'];
                $subtotal += $lineTotal;
                $itemsPayload[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price' => $product->price,
                ];
            }

            $tax = $data['tax'] ?? 0;
            $discount = $data['discount'] ?? 0;
            $grandTotal = max(0, $subtotal + $tax - $discount);

            $sale = Sale::create([
                'branch_id' => $data['branch_id'],
                'user_id' => $user?->id,
                'status' => 'pending',
                'total' => $grandTotal,
                'meta' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'grand_total' => $grandTotal,
                    'payment_method' => $data['payment_method'] ?? null,
                ],
            ]);

            foreach ($itemsPayload as $payload) {
                $sale->items()->create($payload);
            }

            return $sale->load(['items.product', 'branch', 'user']);
        });

        return $this->success($result, 'Sale created', 201);
    }

    public function complete(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'sale_id' => ['required', 'exists:sales,id'],
            'payment_method' => ['nullable', 'string', 'max:100'],
        ]);

        $sale = DB::transaction(function () use ($data, $user) {
            $sale = Sale::with('items.product')->findOrFail($data['sale_id']);

            // Recalculate totals to ensure consistency
            $subtotal = $sale->items->sum(fn ($item) => $item->price * $item->quantity);
            $existingMeta = $sale->meta ?? [];
            $tax = $existingMeta['tax'] ?? 0;
            $discount = $existingMeta['discount'] ?? 0;
            $grandTotal = max(0, $subtotal + $tax - $discount);

            $sale->update([
                'status' => 'completed',
                'user_id' => $user?->id ?? $sale->user_id,
                'total' => $grandTotal,
                'meta' => array_merge($existingMeta, [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'grand_total' => $grandTotal,
                    'payment_method' => $data['payment_method'] ?? ($existingMeta['payment_method'] ?? null),
                ]),
            ]);

            return $sale->load(['items.product', 'branch', 'user']);
        });

        return $this->success($sale, 'Sale completed');
    }
}

