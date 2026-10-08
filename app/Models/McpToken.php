<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class McpToken extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'token', 'scope', 'is_active', 'last_used_at'];

    protected $casts = ['is_active' => 'boolean', 'last_used_at' => 'datetime'];

    protected $hidden = ['token'];

    public const SCOPES = ['read', 'content', 'full'];

    public static function issue(string $name, string $scope = 'read'): array
    {
        $plain = 'cpn_'.Str::random(48);

        $token = static::create([
            'name' => $name,
            'token' => hash('sha256', $plain),
            'scope' => $scope,
        ]);

        return [$token, $plain];
    }

    public static function findByPlainToken(string $plain): ?self
    {
        return static::where('token', hash('sha256', $plain))->where('is_active', true)->first();
    }

    public function can(string $required): bool
    {
        $order = ['read' => 0, 'content' => 1, 'full' => 2];

        return ($order[$this->scope] ?? 0) >= ($order[$required] ?? 2);
    }
}
