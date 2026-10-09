<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** COMPLYN Docs scope: the six compliance document types. */
    private const TYPES = [
        ['key' => 'risk_assessment',      'name_de' => 'Gefährdungsbeurteilung',  'name_en' => 'Risk assessment'],
        ['key' => 'operating_instruction','name_de' => 'Betriebsanweisung',        'name_en' => 'Operating instruction'],
        ['key' => 'audit_protocol',       'name_de' => 'Auditprotokoll',           'name_en' => 'Audit protocol'],
        ['key' => 'evidence',             'name_de' => 'Nachweis',                 'name_en' => 'Evidence'],
        ['key' => 'certificate',          'name_de' => 'Zertifikat',               'name_en' => 'Certificate'],
        ['key' => 'training_evidence',    'name_de' => 'Schulungsnachweis',        'name_en' => 'Training evidence'],
    ];

    public function up(): void
    {
        foreach (self::TYPES as $t) {
            DB::table('categories')->updateOrInsert(
                ['key' => $t['key'], 'context' => 'docs'],
                $t + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('categories')->where('context', 'docs')
            ->whereIn('key', array_column(self::TYPES, 'key'))->delete();
    }
};
