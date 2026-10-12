<x-app-layout>
    <x-slot name="header">Creator — {{ __('KI-Dokumentenerstellung') }}</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        @error('content')<div class="badge red">{{ $message }}</div>@enderror
        <div class="card fade-up" style="padding:20px 24px">
            <form method="POST" action="{{ route('creator.drafts.store') }}" class="gap-3">
                @csrf
                <input name="title" placeholder="{{ __('Titel des Dokuments…') }}" required class="field-input">
                <select name="type" class="field-input">
                    @foreach ($types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <button>{{ __('Anlegen') }}</button>
            </form>
        </div>
        @foreach ($drafts as $d)
        <div class="card fade-up" style="padding:20px 24px" x-data="{open:false}">
            <div class="items-center gap-3">
                <div><span>{{ $d->title }}</span>
                    <span>{{ $types[$d->type] ?? $d->type }} · {{ $d->status }}</span></div>
                <div class="gap-3">
                    <form method="POST" action="{{ route('creator.drafts.generate', $d) }}">@csrf<button class="flink">{{ __('AI generieren') }}</button></form>
                    <button @click="open=!open" class="muted">{{ __('Bearbeiten') }}</button>
                    @if ($d->document_id)
                        <a href="{{ route('docs.show', $d->document_id) }}">{{ __('In Docs') }}</a>
                    @elseif ($d->content)
                        <form method="POST" action="{{ route('creator.drafts.publish', $d) }}">@csrf<button>{{ __('In Docs ablegen') }}</button></form>
                    @endif
                </div>
            </div>
            <div x-show="open">
                <form method="POST" action="{{ route('creator.drafts.update', $d) }}">
                    @csrf @method('PUT')
                    <textarea name="content" rows="8" class="field-input">{{ $d->content }}</textarea>
                    <div class="gap-3">
                        <select name="status" class="field-input">
                            <option value="draft" @selected($d->status==='draft')>{{ __('Entwurf') }}</option>
                            <option value="final" @selected($d->status==='final')>{{ __('Final') }}</option>
                        </select>
                        <button>{{ __('Speichern') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        {{ $drafts->links() }}
</div>
</x-app-layout>
