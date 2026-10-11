<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic sky"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.5 12.5a2 2 0 01-2 1.5h-7a2 2 0 01-2-1.5L5 8zm3-4h8l1 4H7l1-4z"/></svg></span>
            <div><h1>{{ __("Dateien") }}</h1><p class="ph-sub">{{ __('Hochgeladene Dateien') }}</p></div>
        </div>
    </div>
    @if (session('status'))<div class="card alert-band fade-up">{{ session('status') }}</div>@endif

    <div class="card panel fade-up" style="animation-delay:.05s">
        <div class="panel-body">
        <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data" class="filter-bar">
            @csrf
            <input type="file" name="file" required class="f-select" style="padding:7px 10px;flex:1">
            <button class="btn btn-brand">{{ __('Hochladen') }}</button>
        </form>
        </div>
    </div>

    <div class="card table-card fade-up" style="animation-delay:.1s">
        <div class="table-scroll">
        <table class="docs">
            <thead><tr><th>{{ __("Name") }}</th><th>{{ __("Größe") }}</th><th>{{ __("Hochgeladen") }}</th><th></th></tr></thead>
            <tbody>
            @forelse ($files as $f)
                <tr>
                    <td><p style="font-weight:700;color:var(--slate-900)">{{ $f->original_name }}</p></td>
                    <td class="muted">{{ number_format($f->size / 1024, 1) }} KB</td>
                    <td><span class="duedate">{{ $f->created_at->format('d.m.Y H:i') }}</span></td>
                    <td>
                        <div class="filter-bar" style="justify-content:flex-end">
                            <a href="{{ route('files.download', $f) }}" class="btn btn-outline btn-sm">{{ __('Download') }}</a>
                            <form method="POST" action="{{ route('files.destroy', $f) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')<button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><div class="empty"><p>{{ __('Keine Dateien.') }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $files->links() }}</div>
    </div>
</div>
</x-app-layout>
