<x-admin::layout>
    <x-slot:title>Admin Dashboard</x-slot:title>

    <div>
        @foreach (['Unternehmen' => $stats['companies'], 'Benutzer' => $stats['users'], 'Module' => $stats['modules'], 'MCP-Calls' => $stats['mcp_calls']] as $label => $value)
            <div>
                <div>{{ $value }}</div>
                <div>{{ $label }}</div>
            </div>
        @endforeach
    </div>

    <div>
        <div>
            <h3 class="panel-h">{{ __("Neueste Unternehmen") }}</h3>
            <ul>
                @foreach ($companies as $c)
                    <li>
                        <span >{{ $c->name }}</span>
                        <span class="muted">{{ $c->plan?->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h3 class="panel-h">{{ __("Letzte MCP-Aufrufe") }}</h3>
            <ul>
                @foreach ($logs as $log)
                    <li>
                        <span >{{ $log->action }}</span>
                        <span class="muted">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-admin::layout>
