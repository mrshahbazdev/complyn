<?php

namespace Modules\Creator\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreatorDraft;
use App\Models\Document;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreatorController extends Controller
{
    /**
     * Compliance document types the Creator can produce (COMPLYN Creator scope:
     * Gefährdungsbeurteilungen, Betriebsanweisungen, Unterweisungen,
     * Gefahrstoffdokumentation, Checklisten + generic documents).
     */
    private const TYPES = [
        'risk_assessment' => [
            'de' => 'Gefährdungsbeurteilung',
            'en' => 'Risk assessment',
            'prompt' => 'Erstelle eine praxistaugliche deutsche Gefährdungsbeurteilung (§5 ArbSchG): Gefahren/Tätigkeit, Gefährdungsbeurteilung (Eintrittswahrscheinlichkeit × Schadensausmaß), Schutzmaßnahmen nach STOP-Prinzip, Wirksamkeitskontrolle. Nutze eine klare Tabellen-Struktur als Markdown.',
        ],
        'operating_instruction' => [
            'de' => 'Betriebsanweisung',
            'en' => 'Operating instruction',
            'prompt' => 'Erstelle eine deutsche Betriebsanweisung nach TRGS 555: Tätigkeit/Arbeitsmittel, Gefahren für Mensch und Umwelt, Schutzmaßnahmen, Verhaltensweisen, Gefahrenzeichen, Erste Hilfe, Wartung/Entsorgung.',
        ],
        'instruction' => [
            'de' => 'Unterweisung',
            'en' => 'Instruction',
            'prompt' => 'Erstelle eine deutsche Unterweisung: Ziel der Unterweisung, Inhalte (Gefahren, Schutzmaßnahmen, Verhalten), Dauer, Teilnehmerliste/Nachweis-Feld, Wiederholungsintervall. Kurz und praxisnah.',
        ],
        'hazardous_substances' => [
            'de' => 'Gefahrstoffdokumentation',
            'en' => 'Hazardous substances documentation',
            'prompt' => 'Erstelle eine deutsche Gefahrstoffdokumentation: Gefahrstoffverzeichnis (Name, CAS, Mengen), H-/P-Sätze, Schutzmaßnahmen, Lagerung, Entsorgung, Verweis auf Sicherheitsdatenblatt.',
        ],
        'checklist' => [
            'de' => 'Checkliste',
            'en' => 'Checklist',
            'prompt' => 'Erstelle eine deutsche Prüf-Checkliste: gegliederte Punkte mit Checkbox-Struktur [ ], verantwortliche Person, Datum/Ergebnis-Felder. Klar abhakbar formuliert.',
        ],
        'document' => [
            'de' => 'Dokument',
            'en' => 'Document',
            'prompt' => 'Erstelle ein kurzes, praxistaugliches deutsches Compliance-Dokument.',
        ],
    ];

    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function index(Request $request)
    {
        $company = $this->company($request);

        return view('creator::index', [
            'drafts' => CreatorDraft::where('company_id', $company->id)->latest()->paginate(20),
            'types' => collect(self::TYPES)->map(fn ($t) => $t[app()->getLocale()] ?? $t['de']),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->company($request);
        CreatorDraft::create($request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:'.implode(',', array_keys(self::TYPES)),
        ]) + ['company_id' => $company->id, 'user_id' => $request->user()->id]);

        return back()->with('status', 'Entwurf angelegt.');
    }

    public function generate(Request $request, CreatorDraft $draft)
    {
        abort_unless($draft->company_id === $this->company($request)->id, 403);
        $type = self::TYPES[$draft->type] ?? self::TYPES['document'];
        $draft->update(['content' => app(\App\Services\AiService::class)->complete(
            $type['prompt'].' Kontext: Firma „'.$this->company($request)->name.'". Nur den Dokumenten-Inhalt ausgeben, keine Einleitung.',
            'Titel: '.$draft->title
        )]);

        return back()->with('status', 'AI-Entwurf generiert.');
    }

    public function update(Request $request, CreatorDraft $draft)
    {
        abort_unless($draft->company_id === $this->company($request)->id, 403);
        $draft->update($request->validate(['content' => 'nullable|string', 'status' => 'required|in:draft,final']));

        return back()->with('status', 'Gespeichert.');
    }

    /** Finalize: write content to shared storage and file it in Docs. */
    public function publish(Request $request, CreatorDraft $draft)
    {
        abort_unless($draft->company_id === $this->company($request)->id, 403);
        abort_unless($draft->content, 422, 'Kein Inhalt — zuerst generieren oder Text eintragen.');

        $company = $this->company($request);
        $type = self::TYPES[$draft->type] ?? self::TYPES['document'];

        $path = app(StorageService::class)->put(
            $draft->content,
            $company->id,
            'creator',
            Str::slug($draft->title).'.md'
        );

        $document = Document::create([
            'company_id' => $company->id,
            'uploaded_by' => $request->user()->id,
            'title' => $draft->title,
            'description' => 'Erstellt mit COMPLYN Creator — '.$type['de'],
            'status' => 'released',
            'released_at' => now(),
        ]);
        $document->versions()->create([
            'version' => 1,
            'path' => $path,
            'original_name' => Str::slug($draft->title).'.md',
            'size' => strlen($draft->content),
            'mime' => 'text/markdown',
        ]);

        $draft->update(['document_id' => $document->id, 'status' => 'final']);

        return back()->with('status', 'In Docs abgelegt.');
    }
}
