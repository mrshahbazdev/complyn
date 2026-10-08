<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Unternehmens-Einstellungen</h2></x-slot>
    <div class="py-8"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        @if ($company)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('settings.company') }}" class="space-y-4">
                @csrf @method('PUT')
                <div><label class="text-sm text-gray-600 dark:text-gray-300">Name</label>
                    <input name="name" value="{{ $company->name }}" required class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></div>
                <div><label class="text-sm text-gray-600 dark:text-gray-300">Branche</label>
                    <select name="industry_id" class="mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                        <option value="">—</option>
                        @foreach ($industries as $i)<option value="{{ $i->id }}" @selected($company->industry_id === $i->id)>{{ $i->name_de }}</option>@endforeach
                    </select></div>
                <div class="text-sm text-gray-500">Tarif: {{ $company->plan?->name }} · Slug: {{ $company->slug }}</div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Speichern</button>
            </form>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-300 rounded p-5 text-sm">Kein Unternehmen zugeordnet.</div>
        @endif
    </div></div>
</x-app-layout>
