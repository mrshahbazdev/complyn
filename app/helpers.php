<?php

function companyHasBlock(\App\Models\User $user, string $block): bool
{
    $company = $user->companies()->first();
    if (! $company?->plan_id) {
        return true;
    }
    return \DB::table('platform_modules')
        ->join('plan_modules', 'platform_modules.id', '=', 'plan_modules.platform_module_id')
        ->where('plan_modules.plan_id', $company->plan_id)
        ->where('platform_modules.block_key', $block)
        ->exists();
}
