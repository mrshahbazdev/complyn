<?php

namespace App\Http\Middleware;

use App\Models\McpAuditLog;
use App\Models\McpToken;
use Closure;
use Illuminate\Http\Request;

class McpAuthenticate
{
    public function handle(Request $request, Closure $next, string $scope = 'read')
    {
        $plain = $request->bearerToken();
        $token = $plain ? McpToken::findByPlainToken($plain) : null;

        if (! $token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (! $token->can($scope)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $token->forceFill(['last_used_at' => now()])->save();
        $request->attributes->set('mcp_token', $token);

        $response = $next($request);

        McpAuditLog::create([
            'mcp_token_id' => $token->id,
            'action' => $request->method().' '.$request->path(),
            'payload' => $request->except(['token', 'password', 'secret']),
            'ip' => $request->ip(),
        ]);

        return $response;
    }
}
