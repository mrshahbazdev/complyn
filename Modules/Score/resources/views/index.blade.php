<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Compliance-Score</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Kennzahlen") }}</h3>
                <form method="POST" action="{{ route('score.metrics.store') }}" class="grid grid-cols-2 gap-2 mb-4">
                    @csrf
                    <input name="key" placeholder="{{ __('key') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <input name="name_de" placeholder="{{ __('Name') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <input name="value" type="number" step="0.01" placeholder="{{ __('Wert') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <input name="unit" placeholder="{{ __('Einheit') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm col-span-2">Speichern</button>
                </form>
                <table class="w-full text-sm">
                    @foreach ($metrics as $m)
                        <tr class="border-b dark:border-gray-700 last:border-0"><td class="py-1 text-gray-600">{{ $m->key }}</td><td class="text-gray-800 dark:text-gray-200">{{ $m->name_de }}</td><td class="text-right font-medium">{{ $m->value }} {{ $m->unit }}</td></tr>
                    @endforeach
                </table>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ __("Reports") }}</h3>
                    <form method="POST" action="{{ route('score.reports.generate') }}">@csrf<button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Report erstellen</button></form>
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    @foreach ($reports as $r)
                        <li class="py-2 flex justify-between"><span class="text-gray-800 dark:text-gray-200">{{ $r->title }}</span><span class="font-bold {{ $r->score >= 70 ? 'text-green-600' : 'text-red-500' }}">{{ $r->score }}/100</span></li>
                    @endforeach
                </ul>
                {{ $reports->links() }}
            </div>
        </div>
    </div></div>
</x-app-layout>
