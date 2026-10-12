<x-app-layout>
    <x-slot name="header">
        <div class="ph-left">
            <h2>{{ $title ?? 'Admin' }}</h2>
            <nav class="filter-bar">
                <a href="{{ route('admin.dashboard') }}" class="flink">Dashboard</a>
                <a href="{{ route('admin.companies') }}" class="flink">{{ __('Unternehmen') }}</a>
                <a href="{{ route('admin.users') }}" class="flink">{{ __('Benutzer') }}</a>
                <a href="{{ route('admin.plans') }}" class="flink">{{ __('Tarife') }}</a>
                <a href="{{ route('admin.modules') }}" class="flink">{{ __('Module') }}</a>
                <a href="{{ route('admin.taxonomy') }}" class="flink">Taxonomie</a>
                <a href="{{ route('admin.mcp.index') }}" class="flink">MCP</a>
                <a href="{{ route('admin.audit') }}" class="flink">{{ __('Audit-Log') }}</a>
            </nav>
        </div>
    </x-slot>

    <div class="stack">
        @if (session('status'))
            <div class="alert-band">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert-band" style="border-left-color:#dc2626">{{ $errors->first() }}</div>
        @endif

        {{ $slot }}
    </div>
</x-app-layout>
