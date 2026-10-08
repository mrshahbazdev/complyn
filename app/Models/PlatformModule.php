<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlatformModule extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'block_key', 'name', 'version', 'status', 'meta'];

    protected $casts = ['meta' => 'array'];

    public const STATUSES = ['installed', 'enabled', 'disabled', 'deprecated'];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_modules')->withTimestamps();
    }

    public function block(): ?array
    {
        return config('blocks.blocks.'.$this->block_key);
    }
}
