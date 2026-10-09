<?php

namespace Modules\Coach\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoachChecklist;
use App\Models\CoachSession;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

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
    }

    /**
     * Pflichtenerkennung + Branchenvergleich: typical duties for the company's
     * industry, flagged as erfasst/fehlend (COMPLYN Coach scope: Unternehmensanalyse,
     * Branchenvergleich, Pflichtenerkennung).
     */
    public function analysis(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        $catalog = $this->dutyCatalog();
        $industryKey = $company->industry?->key ?? 'other';
        $typical = $catalog[$industryKey] ?? $catalog['other'];

        $existing = \App\Models\CoreObligation::where('company_id', $company->id)->pluck('title')->map(fn($t) => mb_strtolower($t));
        $rows = [];
        foreach ($typical as $duty) {
            $matched = $existing->contains(fn($t) => str_contains($t, mb_strtolower($duty['match'])));
            $rows[] = ['duty' => $duty['title'], 'interval' => $duty['interval'], 'covered' => $matched];
        }

        return view('coach::analysis', [
            'rows' => $rows,
            'industry' => $company->industry,
            'industries' => \App\Models\Industry::orderBy('name_de')->get(),
            'covered' => collect($rows)->where('covered', true)->count(),
            'total' => count($rows),
        ]);
    }

    public function setIndustry(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        $company->update($request->validate(['industry_id' => 'required|exists:industries,id']));
        return back()->with('status', 'Branche gespeichert.');
    }

    private function dutyCatalog(): array
    {
        $base = [
            ['title' => 'Datenschutz-Grundverordnung (DSGVO) Dokumentation', 'match' => 'dsgvo', 'interval' => 'jährlich'],
            ['title' => 'Arbeitsschutz-Unterweisung', 'match' => 'unterweisung', 'interval' => 'jährlich'],
            ['title' => 'Gefährdungsbeurteilung', 'match' => 'gefährdungsbeurteilung', 'interval' => 'alle 2 Jahre'],
            ['title' => 'Sicherheitsbeauftragter bestellen (>20 MA)', 'match' => 'sicherheitsbeauftragt', 'interval' => 'laufend'],
        ];
        return [
            'manufacturing' => array_merge($base, [
                ['title' => 'Maschinen-Prüfung (Betriebssicherheitsverordnung)', 'match' => 'maschinen', 'interval' => 'jährlich'],
                ['title' => 'Gefahrstoffverzeichnis pflegen', 'match' => 'gefahrstoff', 'interval' => 'laufend'],
                ['title' => 'Lärm- und Emissionsschutz', 'match' => 'lärm', 'interval' => 'jährlich'],
            ]),
            'construction' => array_merge($base, [
                ['title' => 'Baustellen-Sicherheitsplan (SiGeKo)', 'match' => 'sigeko', 'interval' => 'pro Baustelle'],
                ['title' => 'Gerüst- und Leiterprüfung', 'match' => 'gerüst', 'interval' => 'jährlich'],
            ]),
            'logistics' => array_merge($base, [
                ['title' => 'Fahrer-Unterweisung (BKrFQV)', 'match' => 'fahrer', 'interval' => 'jährlich'],
                ['title' => 'Gefahrgut-Beauftragter', 'match' => 'gefahrgut', 'interval' => 'laufend'],
            ]),
            'healthcare' => array_merge($base, [
                ['title' => 'Hygieneplan (IfSG)', 'match' => 'hygiene', 'interval' => 'jährlich'],
                ['title' => 'Medizinprodukte-Betreiberverordnung', 'match' => 'medizinprodukte', 'interval' => 'laufend'],
            ]),
            'retail' => array_merge($base, [
                ['title' => 'Lebensmittelhygiene-Schulung (LMHV)', 'match' => 'lebensmittel', 'interval' => 'jährlich'],
            ]),
            'it' => array_merge($base, [
                ['title' => 'Informationssicherheit (ISO 27001 / BSI)', 'match' => 'informationssicherheit', 'interval' => 'jährlich'],
            ]),
            'hospitality' => array_merge($base, [
                ['title' => 'Hygiene & HACCP-Dokumentation', 'match' => 'haccp', 'interval' => 'laufend'],
                ['title' => 'Brandschutzbeauftragter', 'match' => 'brandschutz', 'interval' => 'laufend'],
            ]),
            'services' => $base,
            'other' => $base,
        ];
    }
}
