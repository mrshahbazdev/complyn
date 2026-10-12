<x-app-layout>
    <x-slot name="header">{{ $course->title }}</x-slot>
    <div><div>
        @foreach ($course->lessons as $l)
        <div x-data="{open:false}">
            <div class="items-center">
                <button @click="open=!open">{{ $loop->iteration }}. {{ $l->title }}</button>
                @if ($doneLessonIds->contains($l->id))
                    <span>{{ __("✓ Fertig") }}</span>
                @else
                    <form method="POST" action="{{ route('academy.complete', $l->id) }}">@csrf<button class="flink">{{ __("Abschließen") }}</button></form>
                @endif
            </div>
            <div x-show="open">{{ $l->content }}
                @if ($l->quizzes->count())
                    <div class="not-italic">
                        <div>{{ __('Lerntest') }} @if (isset($attempts[$l->id]))<span class="flink">· {{ $attempts[$l->id] }}%</span>@endif</div>
                        <form method="POST" action="{{ route('academy.attempt', $l->id) }}">@csrf
                            @foreach ($l->quizzes as $q)
                                <div>
                                    <div >{{ $q->question }}</div>
                                    @foreach ($q->options as $oi => $opt)
                                        <label class="items-center gap-2"><input type="radio" name="answers[{{ $q->id }}]" value="{{ $oi }}"> {{ $opt }}</label>
                                    @endforeach
                                </div>
                            @endforeach
                            <button>{{ __('Test abgeben') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
</div>
</x-app-layout>
