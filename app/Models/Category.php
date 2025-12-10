<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

