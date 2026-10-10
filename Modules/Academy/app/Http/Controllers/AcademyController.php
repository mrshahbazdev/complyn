<?php

namespace Modules\Academy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademyCourse;
use App\Models\AcademyProgress;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function index(Request $request)
    {
        $done = AcademyProgress::where('user_id', $request->user()->id)->whereNotNull('completed_at')->pluck('academy_lesson_id');
        return view('academy::index', [
            'courses' => AcademyCourse::withCount('lessons')->get(),
            'doneLessonIds' => $done,
        ]);
    }

    public function show(Request $request, AcademyCourse $course)
    {
        $done = AcademyProgress::where('user_id', $request->user()->id)->whereNotNull('completed_at')->pluck('academy_lesson_id');
        return view('academy::show', [
            'course' => $course->load(['lessons' => fn ($q) => $q->orderBy('sort')->with('quizzes')]),
            'doneLessonIds' => $done,
            'attempts' => \App\Models\AcademyAttempt::where('user_id', $request->user()->id)->pluck('score', 'academy_lesson_id'),
        ]);
    }

    public function complete(Request $request, int $lesson)
    {
        AcademyProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'academy_lesson_id' => $lesson],
            ['completed_at' => now()]
        );
        return back();
    }

    public function storeQuiz(Request $request, AcademyLesson $lesson)
    {
        \App\Models\AcademyQuiz::create([
            'academy_lesson_id' => $lesson->id,
            'question' => $request->validate(['question' => 'required|string'])['question'],
            'options' => array_values(array_filter($request->input('options', []))),
            'correct' => (int) $request->input('correct', 0),
        ]);
        return back()->with('status', __('Lernfrage angelegt.'));
    }

    public function attempt(Request $request, AcademyLesson $lesson)
    {
        $quizzes = \App\Models\AcademyQuiz::where('academy_lesson_id', $lesson->id)->get();
        $answers = (array) $request->input('answers', []);
        $correct = $quizzes->filter(fn ($q) => isset($answers[$q->id]) && (int) $answers[$q->id] === (int) $q->correct)->count();
        $score = $quizzes->count() ? (int) round($correct / $quizzes->count() * 100) : 100;
        \App\Models\AcademyAttempt::updateOrCreate(
            ['academy_lesson_id' => $lesson->id, 'user_id' => $request->user()->id],
            ['score' => $score, 'passed' => $score >= 60],
        );
        if ($score >= 60) {
            \App\Models\AcademyProgress::firstOrCreate(['academy_lesson_id' => $lesson->id, 'user_id' => $request->user()->id]);
        }
        return back()->with('status', __('Test abgelegt — :score% (:result)', ['score'=>$score, 'result'=>$score >= 60 ? __('bestanden') : __('nicht bestanden')]));
    }}
