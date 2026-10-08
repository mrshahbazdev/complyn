<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * One secure storage layer shared by Evidence, Docs, Library and Academy.
 * Files are namespaced per company: companies/{company_id}/{context}/...
 */
class StorageService
{
    public function put(UploadedFile|string $file, int $companyId, string $context, ?string $name = null): string
    {
        $path = "companies/{$companyId}/{$context}";

        if ($file instanceof UploadedFile) {
            $stored = $file->storeAs($path, $name ?? $file->hashName(), $this->disk());
        } else {
            $stored = $path.'/'.$name;
            Storage::disk($this->disk())->put($stored, $file);
        }

        return $stored;
    }

    public function get(string $path): ?string
    {
        $disk = Storage::disk($this->disk());

        return $disk->exists($path) ? $disk->get($path) : null;
    }

    public function delete(string $path): bool
    {
        return Storage::disk($this->disk())->delete($path);
    }

    public function url(string $path): string
    {
        return Storage::disk($this->disk())->url($path);
    }

    public function temporaryUrl(string $path, int $minutes = 30): string
    {
        return Storage::disk($this->disk())->temporaryUrl($path, now()->addMinutes($minutes));
    }

    private function disk(): string
    {
        return config('filesystems.documents_disk', config('filesystems.default'));
    }
}
