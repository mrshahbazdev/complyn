<?php

namespace Modules\Score\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ScoreMetric;
use App\Models\ScoreReport;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        return view('score::index', [
            'metrics' => ScoreMetric::where('company_id', $company->id)->orderBy('key')->get(),
            'reports' => ScoreReport::where('company_id', $company->id)->latest()->paginate(15),
        ]);
    }

    public function storeMetric(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        ScoreMetric::updateOrCreate(
            ['company_id' => $company->id, 'key' => $request->input('key')],
            $request->validate(['key' => 'required|string|max:100', 'name_de' => 'required|string|max:255', 'value' => 'required|numeric', 'unit' => 'nullable|string|max:50'])
        );
        return back()->with('status', 'Kennzahl gespeichert.');
    }

    public function generateReport(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        $metrics = ScoreMetric::where('company_id', $company->id)->get();
        $score = $metrics->count() ? min(100, (int) round($metrics->avg('value'))) : 0;
        ScoreReport::create([
            'company_id' => $company->id,
            'title' => 'Compliance-Score ' . now()->format('d.m.Y'),
            'score' => $score,
            'breakdown' => $metrics->map(fn ($m) => ['key' => $m->key, 'name' => $m->name_de, 'value' => $m->value])->all(),
        ]);
        return back()->with('status', "Report erstellt: {$score}/100");
    }

    public function leaderboard(Request $request)
    {
        $company = $this->company($request);
        $users = $company->users()->get()->map(function ($u) use ($company) {
            $posts = \App\Models\CommunityPost::where('company_id', $company->id)->where('user_id', $u->id)->count();
            $answers = \App\Models\CommunityComment::where('user_id', $u->id)->whereHas('post', fn ($q) => $q->where('company_id', $company->id))->count();
            $accepted = \App\Models\CommunityPost::where('company_id', $company->id)->where('accepted_comment_id', '>', 0)
                ->whereHas('comments', fn ($q) => $q->where('user_id', $u->id))->count();
            $votes = \App\Models\CommunityVote::whereHas('comment', fn ($q) => $q->where('user_id', $u->id))->count();
            $points = $posts * 5 + $answers * 10 + $accepted * 20 + $votes;
            return (object) [
                'user' => $u, 'posts' => $posts, 'answers' => $answers, 'accepted' => $accepted,
                'votes' => $votes, 'points' => $points,
                'level' => $points >= 200 ? 'Experte' : ($points >= 100 ? 'Senior' : ($points >= 30 ? 'Mitglied' : 'Neuling')),
                'badge' => $accepted >= 3 ? 'Fachbadge' : ($votes >= 10 ? 'Hilfsbereit' : null),
            ];
        })->sortByDesc('points')->values();
        return view('score::leaderboard', ['rows' => $users]);
    }}
