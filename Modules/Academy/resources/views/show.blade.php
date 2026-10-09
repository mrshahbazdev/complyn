<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $course->title }}</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-3">
        @foreach ($course->lessons as $l)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4" x-data="{open:false}">
            <div class="flex justify-between items-center">
                <button @click="open=!open" class="text-left font-medium text-gray-800 dark:text-gray-200">{{ $loop->iteration }}. {{ $l->title }}</button>
                @if ($doneLessonIds->contains($l->id))
                    <span class="text-green-600 text-xs">{{ __("✓ Fertig") }}</span>
                @else
                    <form method="POST" action="{{ route('academy.complete', $l->id) }}">@csrf<button class="text-indigo-500 text-xs">Abschließen</button></form>
                @endif
            </div>
            <div x-show="open" class="mt-3 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $l->content }}</div>
        </div>
        @endforeach
    </div></div>
</x-app-layout>
