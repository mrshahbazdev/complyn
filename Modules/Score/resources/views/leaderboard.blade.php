<x-app-layout>
    <x-slot name="header">{{ __("Reputation & Experten-Ranking") }}</x-slot>
    <div><div>
        <div class="card fade-up" style="padding:20px 24px">
            <table class="docs">
                <thead><tr><th>#</th><th>{{ __("Name") }}</th><th>{{ __("Punkte") }}</th><th>{{ __("Fragen") }}</th><th>{{ __("Antworten") }}</th><th>{{ __("Akzeptiert") }}</th><th>{{ __("Bewertungen") }}</th><th>{{ __("Level") }}</th><th>{{ __("Badge") }}</th></tr></thead>
                <tbody>
                @foreach ($rows as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->user->name }} @if($r->user->is_expert)<span class="badge amber">{{ $r->user->expert_label ?: __('Experte') }}</span>@endif</td>
                        <td class="flink">{{ $r->points }}</td>
                        <td class="muted">{{ $r->posts }}</td>
                        <td class="muted">{{ $r->answers }}</td>
                        <td class="muted">{{ $r->accepted }}</td>
                        <td class="muted">{{ $r->votes }}</td>
                        <td>{{ __($r->level) }}</td>
                        <td>@if($r->badge)<span class="badge amber">{{ __($r->badge) }}</span>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>{{ __('Punkte: Frage ×5 · Antwort ×10 · akzeptierte Antwort ×20 · Bewertung ×1') }}</div>
        </div>
</div>
</x-app-layout>
