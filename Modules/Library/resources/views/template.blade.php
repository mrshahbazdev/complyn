<x-app-layout>
    <x-slot name="header">{{ $template->name }}</x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="card fade-up" style="padding:20px 24px">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-500 uppercase">{{ $template->type }}</span>
                <a href="{{ route('library.template.download', $template) }}" class="btn btn-dark btn-sm">{{ __('Herunterladen') }}</a>
            </div>
            <pre class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-200 font-sans">{{ $template->content }}</pre>
        </div>
        <a href="{{ route('library.index') }}" class="flink">← {{ __('Zur Bibliothek') }}</a>
</div>
</x-app-layout>
