<x-admin::layout>
    <x-slot:title>{{ __('MCP Audit-Log') }}</x-slot:title>

    <div class="card fade-up" style="padding:20px 24px">
        <table class="docs">
            <thead><tr>
                <th>{{ __("Zeit") }}</th><th>{{ __("Token") }}</th><th>{{ __("Aktion") }}</th><th>IP</th>
            </tr></thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
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
