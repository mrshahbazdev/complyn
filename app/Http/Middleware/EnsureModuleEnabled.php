<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleEnabled
{
    public function handle(Request $request, Closure $next, string $block): Response
    {
        $company = $request->user()?->companies()->first();
        if (! $company?->plan_id) {
            return $next($request); // no plan assigned → open during onboarding
        }
        $enabled = \DB::table('platform_modules')
            ->join('plan_modules', 'platform_modules.id', '=', 'plan_modules.platform_module_id')
            ->where('plan_modules.plan_id', $company->plan_id)
            ->where('platform_modules.block_key', $block)
            ->exists();
        abort_unless($enabled, 403, 'Dieses Modul ist in Ihrem Tarif nicht enthalten.');
        return $next($request);
    }
}
