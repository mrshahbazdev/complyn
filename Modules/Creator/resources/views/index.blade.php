<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Creator — {{ __('KI-Dokumentenerstellung') }}</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        @error('content')<div class="bg-red-100 text-red-800 px-4 py-2 rounded">{{ $message }}</div>@enderror
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('creator.drafts.store') }}" class="flex flex-wrap gap-3">
                @csrf
                <input name="title" placeholder="{{ __('Titel des Dokuments…') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 flex-1 min-w-[200px]">
                <select name="type" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    @foreach ($types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <button class="bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-semibold">{{ __('Anlegen') }}</button>
            </form>
        </div>
        @foreach ($drafts as $d)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5" x-data="{open:false}">
            <div class="flex justify-between items-center gap-3">
                <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $d->title }}</span>
                    <span class="text-xs text-gray-500 ml-2">{{ $types[$d->type] ?? $d->type }} · {{ $d->status }}</span></div>
                <div class="flex gap-3 shrink-0">
                    <form method="POST" action="{{ route('creator.drafts.generate', $d) }}">@csrf<button class="text-amber-600 text-xs font-semibold underline">{{ __('AI generieren') }}</button></form>
                    <button @click="open=!open" class="text-gray-500 text-xs">{{ __('Bearbeiten') }}</button>
                    @if ($d->document_id)
                        <a href="{{ route('docs.show', $d->document_id) }}" class="text-green-600 text-xs font-semibold underline">{{ __('In Docs') }}</a>
                    @elseif ($d->content)
                        <form method="POST" action="{{ route('creator.drafts.publish', $d) }}">@csrf<button class="text-slate-900 text-xs font-semibold underline">{{ __('In Docs ablegen') }}</button></form>
                    @endif
                </div>
            </div>
            <div x-show="open" class="mt-3">
                <form method="POST" action="{{ route('creator.drafts.update', $d) }}">
                    @csrf @method('PUT')
                    <textarea name="content" rows="8" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full text-sm font-mono">{{ $d->content }}</textarea>
                    <div class="flex gap-3 mt-2">
                        <select name="status" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                            <option value="draft" @selected($d->status==='draft')>{{ __('Entwurf') }}</option>
                            <option value="final" @selected($d->status==='final')>{{ __('Final') }}</option>
                        </select>
                        <button class="bg-slate-900 text-white px-3 py-1 rounded-xl text-sm">{{ __('Speichern') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        {{ $drafts->links() }}
    </div></div>
</x-app-layout>
