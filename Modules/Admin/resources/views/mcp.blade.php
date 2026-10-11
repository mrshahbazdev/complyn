<x-admin::layout>
    <x-slot:title>{{ __('MCP-Tokens') }}</x-slot:title>

    @if ($newToken)
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-300 rounded p-4">
            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-mono break-all">{{ $newToken }}</p>
            <p class="text-xs text-yellow-600 mt-1">{{ __("Jetzt kopieren — wird nur einmal angezeigt.") }}</p>
        </div>
    @endif

    <div class="card fade-up" style="padding:20px 24px">
        <form method="POST" action="{{ route('admin.mcp.store') }}" class="flex gap-3 items-end">
            @csrf
            <input name="name" placeholder="{{ __('Token-Name') }}" required class="field-input">
            <select name="scope" class="field-input">
                <option value="read">{{ __("read") }}</option><option value="content">{{ __("content") }}</option><option value="full">{{ __("full") }}</option>
            </select>
            <button class="btn btn-brand">{{ __('Token erstellen') }}</button>
        </form>
    </div>

    <div class="card fade-up" style="padding:20px 24px">
        <table class="docs">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">{{ __("Name") }}</th><th>{{ __("Scope") }}</th><th>{{ __("Zuletzt genutzt") }}</th><th>{{ __("Erstellt") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($tokens as $t)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-800 dark:text-gray-200">{{ $t->name }}</td>
                    <td><span class="badge blue">{{ $t->scope }}</span></td>
                    <td class="muted">{{ $t->last_used_at?->diffForHumans() ?? '—' }}</td>
                    <td class="muted">{{ $t->created_at->format('d.m.Y') }}</td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('admin.mcp.destroy', $t) }}" onsubmit="return confirm('Token widerrufen?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Widerrufen") }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-admin::layout>
