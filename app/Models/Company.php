<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'industry_id', 'plan_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function moduleOverrides(): BelongsToMany
    {
        return $this->belongsToMany(PlatformModule::class, 'company_modules')
            ->withPivot('enabled')->withTimestamps();
    }

    /**
     * Modules available to this company: plan modules, minus company-level
     * disables. Modules with status 'deprecated' are never available.
     */
    public function enabledModules()
    {
        $planModules = $this->plan?->modules()->where('status', '!=', 'deprecated')->get()
            ?? collect();

        $overrides = $this->moduleOverrides;

        return $planModules->map(function (PlatformModule $module) use ($overrides) {
            $override = $overrides->firstWhere('id', $module->id);
            $module->company_enabled = $override ? (bool) $override->pivot->enabled : true;

            return $module;
        })->filter->company_enabled->values();
    }

    public function hasModule(string $key): bool
    {
        return $this->enabledModules()->contains('key', $key);
    }
}
