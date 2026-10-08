<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price_cents', 'currency', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(PlatformModule::class, 'plan_modules')->withTimestamps();
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
