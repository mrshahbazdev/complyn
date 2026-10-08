<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlatformModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('platform:sync-modules');

        $basic = Plan::firstOrCreate(
            ['slug' => 'basic'],
            ['name' => 'Basic', 'price_cents' => 0, 'is_active' => true]
        );

        $pro = Plan::firstOrCreate(
            ['slug' => 'pro'],
            ['name' => 'Pro', 'price_cents' => 4900, 'is_active' => true]
        );

        // Basic: Core + Docs bundle. Pro: everything.
        $basicKeys = array_keys(array_merge(
            config('blocks.blocks.core.modules'),
            config('blocks.blocks.docs.modules'),
            config('blocks.blocks.community.modules'),
        ));

        $basic->modules()->sync(
            PlatformModule::whereIn('key', $basicKeys)->pluck('id')
        );
        $pro->modules()->sync(PlatformModule::pluck('id'));
    }
}
