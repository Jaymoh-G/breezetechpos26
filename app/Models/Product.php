<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'metadata' => 'array',
        'stock' => 'integer',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}

