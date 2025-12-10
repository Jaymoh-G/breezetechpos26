<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::with(['category', 'images'])->orderByDesc('id')->get();

        return $this->success($products);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);

        return $this->success($product);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'slug' => ['nullable', 'string', 'max:255'],
            'metadata' => ['nullable', 'array'],
        ]);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['name']);

        $product = Product::create($data);

        return $this->success($product->load(['category', 'images']), 'Product created', 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'sku' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'category_id' => ['sometimes', 'nullable', 'exists:categories,id'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:255'],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ]);

        if (array_key_exists('slug', $data) || array_key_exists('name', $data)) {
            $name = $data['name'] ?? $product->name;
            $slugInput = $data['slug'] ?? null;
            $data['slug'] = $this->uniqueSlug($slugInput, $name, $product->id);
        }

        $product->update($data);

        return $this->success($product->load(['category', 'images']), 'Product updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->success(null, 'Product deleted');
    }

    public function storeImage(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'url' => ['required', 'url'],
            'is_primary' => ['sometimes', 'boolean'],
        ]);

        $image = $product->images()->create([
            'url' => $data['url'],
            'is_primary' => $data['is_primary'] ?? false,
        ]);

        if (! empty($data['is_primary'])) {
            $product->images()->where('id', '!=', $image->id)->update(['is_primary' => false]);
        }

        return $this->success($image, 'Image added', 201);
    }

    public function destroyImage(int $productId, int $imageId): JsonResponse
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->where('id', $imageId)->firstOrFail();
        $image->delete();

        return $this->success(null, 'Image deleted');
    }

    protected function uniqueSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $name);
        $candidate = $base;
        $suffix = 1;

        while (
            Product::withoutGlobalScopes()
                ->where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }
}

