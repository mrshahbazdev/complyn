<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __("Aufgabenverwaltung") }}</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <form method="POST" action="{{ route('core.tasks.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="title" required placeholder="{{ __('Aufgabe…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm flex-1 min-w-48">
                <input name="due_at" type="date" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                <select name="assigned_to" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="">{{ __("— Zugewiesen an —") }}</option>
                    @foreach ($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
                </select>
                <button class="bg-slate-900 text-white px-4 py-2 rounded text-sm">+ {{ __("Aufgabe") }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 shadow-sm p-5">
            <table class="w-full text-sm">
                <tbody>
                @foreach ($tasks as $t)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2 {{ $t->status === 'done' ? 'line-through text-gray-400' : 'text-gray-900 dark:text-gray-100' }}">{{ $t->title }}</td>
                        <td class="text-gray-600">{{ $t->due_at ? \Illuminate\Support\Carbon::parse($t->due_at)->format('d.m.Y') : '' }}</td>
                        <td class="text-gray-600">{{ $t->assignee?->name }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('core.tasks.toggle', $t) }}" class="inline">@csrf @method('PUT')
                                <button class="text-xs px-2 py-1 rounded {{ $t->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">{{ $t->status === 'done' ? __('erledigt') : __('offen') }}</button>
                            </form>
                            <form method="POST" action="{{ route('core.tasks.destroy', $t) }}" class="inline" onsubmit="return confirm('{{ __('Löschen?') }}')">@csrf @method('DELETE')
                                <button class="text-xs text-red-600">{{ __("Löschen") }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tasks->links() }}
        </div>
    </div></div>
</x-app-layout>
