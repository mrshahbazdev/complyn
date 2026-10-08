<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\McpAuditLog;
use App\Models\McpToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class McpTokenController extends Controller
{
    public function index(): View
    {
        return view('admin::mcp', [
            'tokens' => McpToken::latest()->get(),
            'newToken' => session('new_token'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'scope' => 'required|in:read,content,full',
        ]);

        [, $plain] = McpToken::issue($data['name'], $data['scope']);

        return back()->with('status', 'Token erstellt — nur einmal sichtbar!')->with('new_token', $plain);
    }

    public function destroy(McpToken $mcpToken): RedirectResponse
    {
        $mcpToken->delete();

        return back()->with('status', 'Token gelöscht.');
    }

    public function auditLogs(): View
    {
        return view('admin::audit', ['logs' => McpAuditLog::with('token')->latest()->paginate(50)]);
    }
}
