<x-admin::layout>
    <x-slot:title>MCP Audit-Log</x-slot:title>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">Zeit</th><th>Token</th><th>Aktion</th><th>IP</th>
            </tr></thead>
            <tbody>
            @foreach ($logs as $log)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-600 dark:text-gray-300">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    <td class="text-gray-800 dark:text-gray-200">{{ $log->token?->name ?? '—' }}</td>
                    <td class="text-gray-800 dark:text-gray-200 font-mono text-xs">{{ $log->action }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $log->ip }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</x-admin::layout>
