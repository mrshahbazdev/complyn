<x-admin::layout>
    <x-slot:title>Admin Dashboard</x-slot:title>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach (['Unternehmen' => $stats['companies'], 'Benutzer' => $stats['users'], 'Module' => $stats['modules'], 'MCP-Calls' => $stats['mcp_calls']] as $label => $value)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $value }}</div>
                <div class="text-sm text-gray-500">{{ $label }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Neueste Unternehmen</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($companies as $c)
                    <li class="py-2 flex justify-between text-sm">
                        <span class="text-gray-800 dark:text-gray-200">{{ $c->name }}</span>
                        <span class="text-gray-500">{{ $c->plan?->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">Letzte MCP-Aufrufe</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($logs as $log)
                    <li class="py-2 text-sm flex justify-between">
                        <span class="text-gray-800 dark:text-gray-200">{{ $log->action }}</span>
                        <span class="text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-admin::layout>
