<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $plans = [
            'basis' => ['name' => 'Basis', 'price_cents' => 0, 'blocks' => ['core', 'docs', 'library'], 'description' => 'Kostenlos — Dokumente & Basis'],
            'professional' => ['name' => 'Professional', 'price_cents' => 9900, 'blocks' => ['core', 'docs', 'library', 'coach', 'community', 'score', 'academy'], 'description' => 'Alles für den Mittelstand'],
            'enterprise' => ['name' => 'Enterprise', 'price_cents' => 29900, 'blocks' => ['*'], 'description' => 'Alle Module inkl. Connect, Creator, Exchange'],
        ];

        foreach ($plans as $slug => $p) {
            $plan = Plan::updateOrCreate(['slug' => $slug], [
                'name' => $p['name'], 'price_cents' => $p['price_cents'], 'description' => $p['description'],
            ]);
            $modules = $p['blocks'] === ['*']
                ? \DB::table('platform_modules')->pluck('id')
                : \DB::table('platform_modules')->whereIn('block', $p['blocks'])->pluck('id');
            \DB::table('plan_modules')->where('plan_id', $plan->id)->delete();
            \DB::table('plan_modules')->insert($modules->map(fn ($id) => ['plan_id' => $plan->id, 'platform_module_id' => $id])->all());
        }
    }
}
