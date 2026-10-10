<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Pflichtenkalender") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('core.obligations.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="title" required placeholder="{{ __('Titel der Pflicht…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1 min-w-48">
                <input name="next_due_at" type="date" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <select name="interval_months" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="12">{{ __("jährlich") }}</option><option value="6">{{ __("halbjährlich") }}</option>
                    <option value="3">{{ __("vierteljährlich") }}</option><option value="24">{{ __("alle 2 Jahre") }}</option>
                </select>
                <input name="description" placeholder="{{ __('Beschreibung') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1">
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __("Pflicht") }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">{{ __("Pflicht") }}</th><th>{{ __("Intervall") }}</th><th>{{ __("Nächste Frist") }}</th><th>{{ __("Verantwortlich") }}</th><th>{{ __("Nachweise") }}</th><th></th></tr></thead>
                <tbody>
                @foreach ($obligations as $o)
                    <tr class="border-b dark:border-gray-700 align-top">
                        <td class="py-2"><div class="font-medium text-gray-900 dark:text-gray-100">{{ $o->title }}</div><div class="text-xs text-gray-500">{{ $o->description }}</div></td>
                        <td class="text-gray-600">{{ __("alle") }} {{ $o->interval_months }} {{ __("Monate") }}</td>
                        <td>@if ($o->next_due_at)<span class="{{ \Illuminate\Support\Carbon::parse($o->next_due_at)->isPast() ? 'text-red-600 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">{{ \Illuminate\Support\Carbon::parse($o->next_due_at)->format('d.m.Y') }}</span>@endif</td>
                        <td class="text-gray-600">
                            @foreach ($o->responsibilities as $r)<div class="text-xs">{{ $r->user->name }} <span class="text-gray-400">({{ $r->role }})</span></div>@endforeach
                            <form method="POST" action="{{ route('core.obligations.assign', $o) }}" class="flex gap-1 mt-1">@csrf
                                <select name="user_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-xs">
                                    @foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
                                </select>
                                <button class="text-xs bg-slate-200 dark:bg-gray-600 px-2 py-0.5 rounded">{{ __("zuweisen") }}</button>
                            </form>
                        </td>
                        <td class="text-gray-600 text-center">{{ $o->evidences_count }}</td>
                        <td>
                            <form method="POST" action="{{ route('core.obligations.status', $o) }}">@csrf @method('PUT')
                                <button name="status" value="{{ $o->status === 'done' ? 'active' : 'done' }}" class="text-xs px-2 py-1 rounded {{ $o->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">{{ $o->status === 'done' ? __('erledigt') : __('offen') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $obligations->links() }}
        </div>
    </div></div>
</x-app-layout>
