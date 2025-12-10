<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = ['id'];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

