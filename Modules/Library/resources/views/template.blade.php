<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $template->name }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-500 uppercase">{{ $template->type }}</span>
                <a href="{{ route('library.template.download', $template) }}" class="bg-slate-900 text-white rounded-lg px-3 py-1.5 text-sm">{{ __('Herunterladen') }}</a>
            </div>
            <pre class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-200 font-sans">{{ $template->content }}</pre>
        </div>
        <a href="{{ route('library.index') }}" class="text-amber-600 text-sm">← {{ __('Zur Bibliothek') }}</a>
    </div></div>
</x-app-layout>
