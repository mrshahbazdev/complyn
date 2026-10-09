<?php

namespace Modules\Coach\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoachChecklist;
use App\Models\CoachSession;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        return view('coach::index', [
            'sessions' => CoachSession::where('company_id', $company->id)->with('messages')->latest()->paginate(20),
            'checklists' => CoachChecklist::where('company_id', $company->id)->latest()->get(),
        ]);
    }

    public function storeSession(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        $data = $request->validate(['topic' => 'nullable|string|max:255']);
        $session = CoachSession::create($data + ['company_id' => $company->id, 'user_id' => $request->user()->id]);
        return redirect()->route('coach.show', $session);
    }

    public function show(Request $request, CoachSession $session)
    {
        abort_unless($session->company_id === $request->user()->companies()->firstOrFail()->id, 403);
        return view('coach::show', ['session' => $session->load('messages')]);
    }

    public function ask(Request $request, CoachSession $session)
    {
        abort_unless($session->company_id === $request->user()->companies()->firstOrFail()->id, 403);
        $request->validate(['message' => 'required|string']);
        $session->messages()->create(['role' => 'user', 'content' => $request->input('message')]);
        $answer = app(\App\Services\AiService::class)->complete(
            'Du bist ein Compliance-Coach für den deutschen Mittelstand. Antworte kurz und praxisnah auf Deutsch.',
            $request->input('message')
        );
        $session->messages()->create(['role' => 'assistant', 'content' => $answer]);
        return back();
    }

    public function storeChecklist(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        CoachChecklist::create($request->validate(['title' => 'required|string|max:255']) + ['company_id' => $company->id]);
        return back()->with('status', 'Checkliste angelegt.');
    }

    public function recommendations(Request $request)
    {
        $company = $this->company($request);
        $recs = [];
        $overdueOb = \App\Models\CoreObligation::where('company_id', $company->id)->where('status', 'active')->where('next_due_at', '<', now()->toDateString())->count();
        if ($overdueOb) {
            $recs[] = ['severity' => 'critical', 'title' => 'Überfällige Pflichten', 'body' => "{$overdueOb} Pflicht(en) sind überfällig. Sofort nachholen und Nachweis ablegen."];
        }
        $unassigned = \App\Models\CoreObligation::where('company_id', $company->id)->where('status', 'active')->whereDoesntHave('responsibilities')->count();
        if ($unassigned) {
            $recs[] = ['severity' => 'warning', 'title' => 'Pflichten ohne Verantwortlichen', 'body' => "{$unassigned} Pflicht(en) haben keinen Verantwortlichen. Zuweisen, sonst bleiben sie liegen."];
        }
        $openTasks = \App\Models\CoreTask::where('company_id', $company->id)->where('status', 'open')->count();
        if ($openTasks > 5) {
            $recs[] = ['severity' => 'info', 'title' => 'Viele offene Aufgaben', 'body' => "{$openTasks} Aufgaben offen — priorisieren oder verteilen."];
        }
        $expiring = \App\Models\Document::where('company_id', $company->id)->where('expires_at', '<=', now()->addDays(30)->toDateString())->where('expires_at', '>=', now()->toDateString())->count();
        if ($expiring) {
            $recs[] = ['severity' => 'warning', 'title' => 'Dokumente laufen ab', 'body' => "{$expiring} Dokument(e) laufen in ≤30 Tagen ab — neue Version oder Verlängerung prüfen."];
        }
        $noEvidence = \App\Models\CoreObligation::where('company_id', $company->id)->where('status', 'active')->whereDoesntHave('evidences')->count();
        if ($noEvidence) {
            $recs[] = ['severity' => 'info', 'title' => 'Pflichten ohne Nachweis', 'body' => "{$noEvidence} Pflicht(en) haben noch keinen hinterlegten Nachweis."];
        }
        if (!$recs) {
            $recs[] = ['severity' => 'success', 'title' => 'Alles im grünen Bereich', 'body' => 'Keine offenen Risiken erkannt. Vergleichbare Unternehmen in Ihrer Branche führen z. B. jährliche Unterweisungen durch — prüfen, ob solche Pflichten für Sie relevant sind.'];
        }
        return view('coach::recommendations', ['recs' => $recs]);
    }}
