<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Benachrichtigungen</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @foreach ($notifications as $n)
                    <li class="py-2 flex justify-between items-center">
                        <span class="{{ $n->read_at ? 'text-gray-500' : 'text-gray-800 dark:text-gray-200 font-medium' }}">{{ $n->data['title'] ?? class_basename($n->type) }}</span>
                        @unless ($n->read_at)
                        <form method="POST" action="{{ route('notifications.read', $n->id) }}">@csrf<button class="text-indigo-500 text-xs">Gelesen</button></form>
                        @else
                        <span class="text-xs text-gray-400">{{ $n->created_at->format('d.m.Y') }}</span>
                        @endunless
                    </li>
                @endforeach
            </ul>
            {{ $notifications->links() }}
        </div>
    </div></div>
</x-app-layout>
