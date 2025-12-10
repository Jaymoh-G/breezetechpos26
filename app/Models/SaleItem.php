<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

