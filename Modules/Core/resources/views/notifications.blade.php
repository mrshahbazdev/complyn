<x-app-layout>
<div class="stack">
    <div class="page-head fade-up">
        <div class="ph-left">
            <span class="p-ic amber"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></span>
            <div><h1>{{ __('Benachrichtigungen') }}</h1><p class="ph-sub">{{ __('Alle Hinweise für Sie') }}</p></div>
        </div>
    </div>
    <div class="card table-card fade-up" style="animation-delay:.05s">
        <div class="table-scroll">
        <table class="docs">
            <tbody>
            @forelse ($notifications as $n)
                <tr>
                    <td><p style="font-weight:{{ $n->read_at ? '500;color:var(--slate-400)' : '700;color:var(--slate-900)' }}">{{ $n->data['title'] ?? class_basename($n->type) }}</p></td>
                    <td><span class="duedate">{{ $n->created_at->format('d.m.Y') }}</span></td>
                    <td>
                        @unless ($n->read_at)
                        <form method="POST" action="{{ route('notifications.read', $n->id) }}">@csrf<button class="btn btn-outline btn-sm">{{ __('Gelesen') }}</button></form>
                        @else
                        <span class="badge gray">{{ __('gelesen') }}</span>
                        @endunless
                    </td>
                </tr>
            @empty
                <tr><td colspan="3"><div class="empty"><p>{{ __('Keine Benachrichtigungen.') }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="panel-body">{{ $notifications->links() }}</div>
    </div>
</div>
</x-app-layout>
