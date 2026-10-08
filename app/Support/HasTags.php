<?php

namespace App\Support;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    public function syncTagNames(array $names): void
    {
        $ids = collect($names)->filter()->map(
            fn (string $name) => Tag::firstOrCreate(['name' => trim($name)])->id
        );

        $this->tags()->sync($ids);
    }
}
