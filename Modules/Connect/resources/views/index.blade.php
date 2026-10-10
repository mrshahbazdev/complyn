<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __('Connect — Anfragen') }}</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('connect.store') }}" class="space-y-3">
                @csrf
                <input name="title" placeholder="{{ __('Neue Anfrage — Titel') }}" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full">
                <textarea name="description" rows="2" placeholder="{{ __('Beschreibung…') }}" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 w-full"></textarea>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">{{ __('Absenden') }}</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($requests as $r)
                    <li class="py-2 flex justify-between">
                        <a href="{{ route('connect.show', $r) }}" class="text-indigo-600">{{ $r->title }}</a>
                        <span class="text-xs {{ $r->status === 'open' ? 'text-green-600' : 'text-gray-500' }}">{{ $r->status }} · {{ $r->messages_count }} Msgs</span>
                    </li>
                @endforeach
            </ul>
            {{ $requests->links() }}
        </div>
    </div></div>
</x-app-layout>
