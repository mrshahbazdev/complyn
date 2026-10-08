<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Dateien</h2></x-slot>
    <div class="py-8"><div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data" class="flex gap-3 items-center">
                @csrf
                <input type="file" name="file" required class="text-sm text-gray-700 dark:text-gray-300">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Hochladen</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700"><th class="py-2">Name</th><th>Größe</th><th>Hochgeladen</th><th></th></tr></thead>
                <tbody>
                @foreach ($files as $f)
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-2 text-gray-800 dark:text-gray-200">{{ $f->original_name }}</td>
                        <td class="text-gray-600">{{ number_format($f->size / 1024, 1) }} KB</td>
                        <td class="text-gray-600">{{ $f->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('files.download', $f) }}" class="text-indigo-500 text-xs">Download</a>
                            <form method="POST" action="{{ route('files.destroy', $f) }}" class="inline" onsubmit="return confirm('Löschen?')">@csrf @method('DELETE')<button class="text-red-500 text-xs">Löschen</button></form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $files->links() }}
        </div>
    </div></div>
</x-app-layout>
