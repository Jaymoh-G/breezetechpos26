<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'total' => 'decimal:2',
        'meta' => 'array',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

