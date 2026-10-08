<?php

namespace App\Http\Controllers;

use App\Models\McpAuditLog;
use App\Models\PlatformModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class McpController extends Controller
{
    /** Artisan commands MCP full-control tokens may run. */
    private const ARTISAN_ALLOWLIST = [
        'migrate', 'migrate:status', 'cache:clear', 'config:clear', 'config:cache',
        'route:clear', 'view:clear', 'queue:restart', 'schedule:run',
        'platform:sync-modules', 'down', 'up', 'optimize:clear',
    ];

    public function health(): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'app' => config('app.name'),
            'env' => config('app.env'),
            'php' => PHP_VERSION,
        ]);
    }

    public function blocks(): JsonResponse
    {
        return response()->json(config('blocks'));
    }

    public function modules(): JsonResponse
    {
        return response()->json(PlatformModule::orderBy('block_key')->orderBy('key')->get());
    }

    public function schema(): JsonResponse
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(fn ($row) => array_values((array) $row)[0]);

        return response()->json(['tables' => $tables]);
    }

    public function auditLogs(Request $request): JsonResponse
    {
        return response()->json(
            McpAuditLog::latest()->paginate(min((int) $request->query('per_page', 50), 200))
        );
    }

    public function setModuleStatus(Request $request, string $key): JsonResponse
    {
        $status = $request->validate(['status' => 'required|in:'.implode(',', PlatformModule::STATUSES)])['status'];
        $module = PlatformModule::where('key', $key)->firstOrFail();
        $module->update(['status' => $status]);

        return response()->json($module);
    }

    public function artisan(Request $request): JsonResponse
    {
        $command = $request->validate(['command' => 'required|string'])['command'];
        abort_unless(in_array($command, self::ARTISAN_ALLOWLIST, true), 403, 'Command not allowed');

        $exitCode = Artisan::call($command);

        return response()->json(['exit_code' => $exitCode, 'output' => Artisan::output()]);
    }
}
