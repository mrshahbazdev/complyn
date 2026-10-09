<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Reputation & Experten-Ranking") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">#</th><th>{{ __("Name") }}</th><th>{{ __("Punkte") }}</th><th>{{ __("Fragen") }}</th><th>{{ __("Antworten") }}</th><th>{{ __("Akzeptiert") }}</th><th>{{ __("Bewertungen") }}</th><th>{{ __("Level") }}</th><th>{{ __("Badge") }}</th></tr></thead>
                <tbody>
                @foreach ($rows as $i => $r)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2 text-gray-500">{{ $i + 1 }}</td>
                        <td class="text-gray-900 dark:text-gray-100">{{ $r->user->name }} @if($r->user->is_expert)<span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-xs">{{ $r->user->expert_label ?: __('Experte') }}</span>@endif</td>
                        <td class="font-bold text-amber-600">{{ $r->points }}</td>
                        <td class="text-gray-600">{{ $r->posts }}</td>
                        <td class="text-gray-600">{{ $r->answers }}</td>
                        <td class="text-gray-600">{{ $r->accepted }}</td>
                        <td class="text-gray-600">{{ $r->votes }}</td>
                        <td class="text-gray-700 dark:text-gray-300">{{ __($r->level) }}</td>
                        <td>@if($r->badge)<span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-xs font-semibold">{{ __($r->badge) }}</span>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-xs text-gray-500 mt-3">{{ __('Punkte: Frage ×5 · Antwort ×10 · akzeptierte Antwort ×20 · Bewertung ×1') }}</div>
        </div>
    </div></div>
</x-app-layout>
