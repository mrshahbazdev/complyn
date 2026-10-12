<x-app-layout>
    <x-slot name="header">{{ $template->name }}</x-slot>
    <div><div>
        <div class="card fade-up" style="padding:20px 24px">
            <div class="items-center">
                <span>{{ $template->type }}</span>
                <a href="{{ route('library.template.download', $template) }}" class="btn btn-dark btn-sm">{{ __('Herunterladen') }}</a>
            </div>
            <pre>{{ $template->content }}</pre>
        </div>
        <a href="{{ route('library.index') }}" class="flink">← {{ __('Zur Bibliothek') }}</a>
</div>
</x-app-layout>
