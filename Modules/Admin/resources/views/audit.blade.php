<x-admin::layout>
    <x-slot:title>{{ __('MCP Audit-Log') }}</x-slot:title>

    <div class="card fade-up" style="padding:20px 24px">
        <table class="docs">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">{{ __("Zeit") }}</th><th>{{ __("Token") }}</th><th>{{ __("Aktion") }}</th><th>IP</th>
            </tr></thead>
            <tbody>
            @foreach ($logs as $log)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-600 dark:text-gray-300">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    <td >{{ $log->token?->name ?? '—' }}</td>
                    <td >{{ $log->action }}</td>
                    <td class="muted">{{ $log->ip }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</x-admin::layout>
