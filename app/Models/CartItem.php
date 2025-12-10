<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

