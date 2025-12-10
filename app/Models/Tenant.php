<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static ?int $currentId = null;

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public static function setCurrentId(?int $tenantId): void
    {
        static::$currentId = $tenantId;
    }

    public static function currentId(): ?int
    {
        return static::$currentId;
    }
}

