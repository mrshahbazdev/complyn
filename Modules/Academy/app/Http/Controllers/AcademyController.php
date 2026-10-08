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
        return view('academy::show', ['course' => $course->load(['lessons' => fn ($q) => $q->orderBy('sort')]), 'doneLessonIds' => $done]);
    }

    public function complete(Request $request, int $lesson)
    {
        AcademyProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'academy_lesson_id' => $lesson],
            ['completed_at' => now()]
        );
        return back();
    }
}
