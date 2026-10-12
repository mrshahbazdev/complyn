<x-app-layout>
    <x-slot name="header">Compliance-Score</x-slot>
    <div><div>
        @if (session('status'))<div class="badge green">{{ session('status') }}</div>@endif
        <div>
            <div class="card fade-up" style="padding:20px 24px">
                <h3 class="panel-h">{{ __("Kennzahlen") }}</h3>
                <form method="POST" action="{{ route('score.metrics.store') }}" class="gap-2">
                    @csrf
                    <input name="key" placeholder="{{ __('key') }}" required class="field-input">
                    <input name="name_de" placeholder="{{ __('Name') }}" required class="field-input">
                    <input name="value" type="number" step="0.01" placeholder="{{ __('Wert') }}" required class="field-input">
                    <input name="unit" placeholder="{{ __('Einheit') }}" class="field-input">
                    <button class="btn btn-brand btn-sm">{{ __('Speichern') }}</button>
                </form>
                <table class="docs">
                    @foreach ($metrics as $m)
                        <tr class="last:border-0"><td>{{ $m->key }}</td><td >{{ $m->name_de }}</td><td>{{ $m->value }} {{ $m->unit }}</td></tr>
                    @endforeach
                </table>
            </div>
            <div class="card fade-up" style="padding:20px 24px">
                <div class="items-center">
                    <h3 class="panel-h">{{ __("Reports") }}</h3>
                    <form method="POST" action="{{ route('score.reports.generate') }}">@csrf<button class="btn btn-brand btn-sm">{{ __('Report erstellen') }}</button></form>
                </div>
                <ul>
                    @foreach ($reports as $r)
                        <li><span >{{ $r->title }}</span><span class="{{ $r->score >= 70 ? 'text-green-600' : 'text-red-500' }}">{{ $r->score }}/100</span></li>
                    @endforeach
                </ul>
                {{ $reports->links() }}
            </div>
        </div>
</div>
</x-app-layout>
