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

        // Auto-KPIs from real module data (COMPLYN Score: Qualitätsbewertung).
        $obligations = \App\Models\CoreObligation::where('company_id', $company->id)->where('status', 'active');
        $obCount = (clone $obligations)->count();
        $auto = collect();
        if ($obCount) {
            $auto->push(['key' => 'obligations_on_time', 'name' => 'Pflichten ohne Überfälligkeit (%)', 'value' => round(100 * (clone $obligations)->where(fn ($q) => $q->whereNull('next_due_at')->orWhere('next_due_at', '>=', now()->toDateString()))->count() / $obCount, 1)]);
            $auto->push(['key' => 'obligations_with_responsible', 'name' => 'Pflichten mit Verantwortlichem (%)', 'value' => round(100 * (clone $obligations)->whereHas('responsibilities')->count() / $obCount, 1)]);
            $auto->push(['key' => 'obligations_with_evidence', 'name' => 'Pflichten mit Nachweis (%)', 'value' => round(100 * (clone $obligations)->whereHas('evidences')->count() / $obCount, 1)]);
        }
        $tasks = \App\Models\CoreTask::where('company_id', $company->id);
        $tCount = (clone $tasks)->count();
        if ($tCount) {
            $auto->push(['key' => 'tasks_completed', 'name' => 'Aufgaben erledigt (%)', 'value' => round(100 * (clone $tasks)->where('status', 'done')->count() / $tCount, 1)]);
        }
        $docs = \App\Models\Document::where('company_id', $company->id)->whereNotNull('expires_at');
        $dCount = (clone $docs)->count();
        if ($dCount) {
            $auto->push(['key' => 'docs_not_expired', 'name' => 'Dokumente gültig (%)', 'value' => round(100 * (clone $docs)->where('expires_at', '>=', now()->toDateString())->count() / $dCount, 1)]);
        }

        $all = $metrics->map(fn ($m) => ['key' => $m->key, 'name' => $m->name_de, 'value' => $m->value])->merge($auto);
        $score = $all->count() ? min(100, (int) round($all->avg('value'))) : 0;
        ScoreReport::create([
            'company_id' => $company->id,
            'title' => 'Compliance-Score ' . now()->format('d.m.Y'),
            'score' => $score,
            'breakdown' => $all->all(),
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
