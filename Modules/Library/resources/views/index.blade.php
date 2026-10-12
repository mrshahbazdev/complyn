<x-app-layout>
    <x-slot name="header">Bibliothek</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <form method="GET" class="gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="{{ __('Artikel suchen…') }}" class="field-input">
            <button class="btn btn-brand">{{ __('Suchen') }}</button>
        </form>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Artikel") }}</h3>
            <ul>
                @foreach ($articles as $a)
                    <li><a href="{{ route('library.show', $a) }}" class="flink">{{ $a->title }}</a></li>
                @endforeach
            </ul>
            {{ $articles->links() }}
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Vorlagen") }}</h3>
            <ul>
                @foreach ($templates as $t)<li >• <a href="{{ route('library.template', $t) }}" class="flink">{{ $t->name }}</a> <span>({{ $t->type }})</span></li>@endforeach
            </ul>
        </div>
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">{{ __("Neuer Artikel") }}</h3>
            <form method="POST" action="{{ route('library.articles.store') }}">
                @csrf
                <input name="title" placeholder="{{ __('Titel') }}" required class="field-input">
                <select name="category_id" class="field-input">
                    <option value="">{{ __("— Kategorie —") }}</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name_de }}</option>@endforeach
                </select>
                <textarea name="body" required rows="4" placeholder="{{ __('Inhalt…') }}" class="field-input"></textarea>
                <button class="btn btn-brand">{{ __('Speichern') }}</button>
            </form>
        </div>
</div>
</x-app-layout>
