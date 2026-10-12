<x-app-layout>
    <x-slot name="header">{{ $article->title }}</x-slot>
    <div><div>
        <div>
            <div>{{ $article->body }}</div>
        </div>
</div>
</x-app-layout>
