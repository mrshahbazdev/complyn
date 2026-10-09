<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tpl = [
            ['name' => 'Muster: Gefährdungsbeurteilung', 'type' => 'template',
             'content' => "# Gefährdungsbeurteilung\n\n**Arbeitsbereich:** …\n**Datum:** …\n**Beurteiler:** …\n\n## 1. Gefährdungen ermitteln\n- Mechanische Gefährdungen:\n- Elektrische Gefährdungen:\n- Gefahrstoffe:\n- Arbeitsbedingungen (Lärm, Klima, Beleuchtung):\n- Psychische Belastungen:\n\n## 2. Beurteilung\n| Gefährdung | Eintrittswahrscheinlichkeit | Schadensausmaß | Risiko |\n|---|---|---|---|\n| | niedrig/mittel/hoch | gering/mittel/hoch | |\n\n## 3. Maßnahmen (STOP-Prinzip)\n- Substitution:\n- Technisch:\n- Organisatorisch:\n- Persönlich:\n\n## 4. Wirksamkeitskontrolle\nNächste Überprüfung: …\nVerantwortlich: …"],
            ['name' => 'Muster: Betriebsanweisung (TRGS 555)', 'type' => 'template',
             'content' => "# Betriebsanweisung\n\n**Tätigkeit/Bereich:** …\n**Erstellt am:** …\n\n## Gefahren für Mensch und Umwelt\n…\n\n## Schutzmaßnahmen und Verhaltensregeln\n…\n\n## Verhalten im Gefahrenfall\n…\n\n## Erste Hilfe\n…\n\n## Instandhaltung / Entsorgung\n…\n\n**Unterschrift Unterweisender:** …"],
            ['name' => 'Muster: Unterweisungsprotokoll', 'type' => 'checklist',
             'content' => "# Unterweisungsprotokoll\n\n**Thema:** …\n**Datum/Uhrzeit:** …\n**Unterweisende Person:** …\n\n## Inhalte\n…\n\n## Teilnehmer\n| Name | Unterschrift |\n|---|---|\n| | |\n\nNächste Unterweisung fällig: …"],
            ['name' => 'Checkliste: Arbeitssicherheit Büro', 'type' => 'checklist',
             'content' => "# Checkliste Arbeitssicherheit (Büro)\n\n- [ ] Verkehrswege frei\n- [ ] Fluchtwege gekennzeichnet und frei\n- [ ] Bildschirmarbeitsplatz ergonomisch\n- [ ] Elektrische Geräte geprüft (DGUV V3)\n- [ ] Erste-Hilfe-Material vorhanden\n- [ ] Brandschutzordnung bekannt\n- [ ] Unterweisung dokumentiert"],
            ['name' => 'Muster: Auditprotokoll (intern)', 'type' => 'template',
             'content' => "# Auditprotokoll\n\n**Audit-Bereich:** …\n**Auditoren:** …\n**Datum:** …\n\n## Feststellungen\n| Nr. | Feststellung | Schwere | Maßnahme | Verantwortlich | Frist |\n|---|---|---|---|---|---|\n| | | | | | |\n\n## Bewertung\n…\n\n**Unterschriften:** …"],
        ];
        foreach ($tpl as $t) {
            DB::table('library_templates')->updateOrInsert(
                ['name' => $t['name'], 'company_id' => null],
                $t + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('library_templates')->whereNull('company_id')
            ->whereIn('name', ['Muster: Gefährdungsbeurteilung','Muster: Betriebsanweisung (TRGS 555)','Muster: Unterweisungsprotokoll','Checkliste: Arbeitssicherheit Büro','Muster: Auditprotokoll (intern)'])->delete();
    }
};
