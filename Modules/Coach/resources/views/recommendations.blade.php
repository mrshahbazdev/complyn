<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Handlungsempfehlungen") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="grid gap-3">
            @foreach ($recs as $r)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border shadow-sm p-5 border-l-4 {{ $r['severity'] === 'critical' ? 'border-l-red-500' : ($r['severity'] === 'warning' ? 'border-l-amber-500' : ($r['severity'] === 'success' ? 'border-l-green-500' : 'border-l-slate-400')) }} border-slate-200">
                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $r['title'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $r['body'] }}</div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('coach.index') }}" class="text-amber-600 text-sm">← {{ __('Zum KI-Coach') }}</a>
    </div></div>
</x-app-layout>
