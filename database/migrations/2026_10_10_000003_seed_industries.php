<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const INDUSTRIES = [
        ['key' => 'manufacturing',   'name_de' => 'Produktion & Fertigung',     'name_en' => 'Manufacturing'],
        ['key' => 'construction',    'name_de' => 'Bau & Handwerk',             'name_en' => 'Construction & trades'],
        ['key' => 'logistics',       'name_de' => 'Logistik & Transport',       'name_en' => 'Logistics & transport'],
        ['key' => 'healthcare',      'name_de' => 'Gesundheitswesen',           'name_en' => 'Healthcare'],
        ['key' => 'retail',          'name_de' => 'Handel & Einzelhandel',      'name_en' => 'Retail'],
        ['key' => 'it',              'name_de' => 'IT & Software',              'name_en' => 'IT & software'],
        ['key' => 'hospitality',     'name_de' => 'Gastronomie & Hotellerie',   'name_en' => 'Hospitality'],
        ['key' => 'services',        'name_de' => 'Dienstleistungen',           'name_en' => 'Services'],
        ['key' => 'other',           'name_de' => 'Sonstige',                   'name_en' => 'Other'],
    ];

    public function up(): void
    {
        foreach (self::INDUSTRIES as $i) {
            DB::table('industries')->updateOrInsert(['key' => $i['key']], $i + ['created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        DB::table('industries')->whereIn('key', array_column(self::INDUSTRIES, 'key'))->delete();
    }
};
