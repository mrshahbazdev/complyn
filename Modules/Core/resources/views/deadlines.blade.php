<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Fristenverwaltung") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('core.deadlines.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="title" required placeholder="{{ __('Frist…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1 min-w-48">
                <input name="due_at" type="date" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <select name="core_obligation_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="">{{ __("— Pflicht —") }}</option>
                    @foreach ($obligations as $o)<option value="{{ $o->id }}">{{ $o->title }}</option>@endforeach
                </select>
                <select name="responsible_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="">{{ __("— Verantwortlich —") }}</option>
                    @foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
                </select>
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __("Frist") }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">{{ __("Frist") }}</th><th>{{ __("Datum") }}</th><th>{{ __("Pflicht") }}</th><th>{{ __("Verantwortlich") }}</th><th>{{ __("Status") }}</th><th></th></tr></thead>
                <tbody>
                @foreach ($deadlines as $d)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2 text-gray-900 dark:text-gray-100">{{ $d->title }}</td>
                        <td class="{{ $d->status === 'open' && \Illuminate\Support\Carbon::parse($d->due_at)->isPast() ? 'text-red-600 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">{{ \Illuminate\Support\Carbon::parse($d->due_at)->format('d.m.Y') }}</td>
                        <td class="text-gray-600">{{ $d->obligation?->title }}</td>
                        <td class="text-gray-600">{{ $d->responsible?->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('core.deadlines.toggle', $d) }}">@csrf @method('PUT')
                                <button class="text-xs px-2 py-1 rounded {{ $d->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">{{ $d->status === 'done' ? __('erledigt') : __('offen') }}</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('core.deadlines.destroy', $d) }}" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')
                                <button class="text-xs text-red-600">{{ __("Löschen") }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $deadlines->links() }}
        </div>
    </div></div>
</x-app-layout>
