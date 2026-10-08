<?php

namespace App\Console\Commands;

use App\Models\PlatformModule;
use Illuminate\Console\Command;

class SyncModules extends Command
{
    protected $signature = 'platform:sync-modules';

    protected $description = 'Sync config/blocks.php into platform_modules';

    public function handle(): int
    {
        $locale = app()->getLocale();
        $seen = [];

        foreach (config('blocks.blocks') as $blockKey => $block) {
            foreach ($block['modules'] as $moduleKey => $names) {
                $seen[] = $moduleKey;

                PlatformModule::updateOrCreate(
                    ['key' => $moduleKey],
                    [
                        'block_key' => $blockKey,
                        'name' => $names[$locale] ?? $names['de'],
                        'meta' => ['names' => $names],
                    ]
                );
            }
        }

        PlatformModule::whereNotIn('key', $seen)->update(['status' => 'deprecated']);

        $this->info(count($seen).' modules synced.');

        return self::SUCCESS;
    }
}
