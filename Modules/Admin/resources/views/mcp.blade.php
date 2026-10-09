<x-admin::layout>
    <x-slot:title>MCP-Tokens</x-slot:title>

    @if ($newToken)
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-300 rounded p-4">
            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-mono break-all">{{ $newToken }}</p>
            <p class="text-xs text-yellow-600 mt-1">{{ __("Jetzt kopieren — wird nur einmal angezeigt.") }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <form method="POST" action="{{ route('admin.mcp.store') }}" class="flex gap-3 items-end">
            @csrf
            <input name="name" placeholder="Token-Name" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <select name="scope" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                <option value="read">{{ __("read") }}</option><option value="content">{{ __("content") }}</option><option value="full">{{ __("full") }}</option>
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Token erstellen</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">{{ __("Name") }}</th><th>{{ __("Scope") }}</th><th>{{ __("Zuletzt genutzt") }}</th><th>{{ __("Erstellt") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($tokens as $t)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-800 dark:text-gray-200">{{ $t->name }}</td>
                    <td><span class="px-2 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700">{{ $t->scope }}</span></td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $t->last_used_at?->diffForHumans() ?? '—' }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $t->created_at->format('d.m.Y') }}</td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('admin.mcp.destroy', $t) }}" onsubmit="return confirm('Token widerrufen?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-xs">{{ __("Widerrufen") }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-admin::layout>
