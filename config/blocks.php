<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Platform → Block → Module
    |--------------------------------------------------------------------------
    | Every Block belongs to a strategic pillar and owns Module keys. Module
    | keys are materialised in the `platform_modules` table by the
    | `platform:sync-modules` command — this file is the source of truth.
    */

    'pillars' => [
        'manage' => ['de' => 'Verwalten', 'en' => 'Manage'],
        'understand' => ['de' => 'Verstehen', 'en' => 'Understand'],
        'resolve' => ['de' => 'Lösen', 'en' => 'Resolve'],
        'improve' => ['de' => 'Verbessern', 'en' => 'Improve'],
    ],

    'blocks' => [
        'admin' => [
            'name' => ['de' => 'Administration', 'en' => 'Admin Area'],
            'pillar' => null,
            'order' => 0,
            'modules' => [
                'admin-users' => ['de' => 'Benutzer & Teams', 'en' => 'Users & Teams'],
                'admin-plans' => ['de' => 'Tarife & Coupons', 'en' => 'Plans & Coupons'],
                'admin-modules' => ['de' => 'Modulverwaltung', 'en' => 'Module Management'],
                'admin-support' => ['de' => 'Ankündigungen & Support', 'en' => 'Announcements & Support'],
                'admin-system' => ['de' => 'Einstellungen & Wartung', 'en' => 'Settings & Maintenance'],
                'admin-logs' => ['de' => 'Protokolle', 'en' => 'Logs'],
                'admin-moderation' => ['de' => 'Community-Moderation', 'en' => 'Community Moderation'],
                'admin-experts' => ['de' => 'Experten-Verifizierung', 'en' => 'Expert Verification'],
                'admin-catalogs' => ['de' => 'Pflichten- & Dokumentkataloge', 'en' => 'Obligation & Document Catalogs'],
                'admin-ai' => ['de' => 'KI-Einstellungen', 'en' => 'AI Settings'],
                'admin-notifications' => ['de' => 'Benachrichtigungsvorlagen', 'en' => 'Notification Templates'],
            ],
        ],
        'core' => [
            'name' => ['de' => 'COMPLYN Core', 'en' => 'COMPLYN Core'],
            'pillar' => 'manage',
            'order' => 1,
            'modules' => [
                'core-obligations' => ['de' => 'Pflichtenkalender', 'en' => 'Obligation Calendar'],
                'core-deadlines' => ['de' => 'Fristenverwaltung', 'en' => 'Deadline Management'],
                'core-tasks' => ['de' => 'Aufgabenverwaltung', 'en' => 'Task Management'],
                'core-reminders' => ['de' => 'Erinnerungen', 'en' => 'Reminders'],
                'core-responsibilities' => ['de' => 'Verantwortlichkeiten', 'en' => 'Responsibilities'],
                'core-evidence' => ['de' => 'Nachweismanagement', 'en' => 'Evidence Management'],
                'core-dashboard' => ['de' => 'Dashboard', 'en' => 'Dashboard'],
            ],
        ],
        'coach' => [
            'name' => ['de' => 'COMPLYN Coach', 'en' => 'COMPLYN Coach'],
            'pillar' => 'understand',
            'order' => 2,
            'modules' => [
                'coach-analysis' => ['de' => 'Unternehmensanalyse', 'en' => 'Company Analysis'],
                'coach-benchmarks' => ['de' => 'Branchenvergleich', 'en' => 'Industry Comparison'],
                'coach-obligations' => ['de' => 'Pflichtenerkennung', 'en' => 'Obligation Recognition'],
                'coach-risks' => ['de' => 'Risikohinweise', 'en' => 'Risk Indications'],
                'coach-recommendations' => ['de' => 'Handlungsempfehlungen', 'en' => 'Recommendations'],
                'coach-assistant' => ['de' => 'KI-Assistent', 'en' => 'AI Assistant'],
            ],
        ],
        'community' => [
            'name' => ['de' => 'COMPLYN Community', 'en' => 'COMPLYN Community'],
            'pillar' => 'understand',
            'order' => 3,
            'modules' => [
                'community-questions' => ['de' => 'Fragen stellen', 'en' => 'Post Questions'],
                'community-answers' => ['de' => 'Antworten', 'en' => 'Replies'],
                'community-reviews' => ['de' => 'Bewertungen', 'en' => 'Reviews'],
                'community-comments' => ['de' => 'Kommentare', 'en' => 'Comments'],
                'community-expert-labels' => ['de' => 'Experten-Kennzeichnung', 'en' => 'Expert Labelling'],
            ],
        ],
        'score' => [
            'name' => ['de' => 'COMPLYN Score', 'en' => 'COMPLYN Score'],
            'pillar' => 'improve',
            'order' => 4,
            'modules' => [
                'score-points' => ['de' => 'Aktivitätspunkte', 'en' => 'Activity Points'],
                'score-quality' => ['de' => 'Qualitätsbewertung', 'en' => 'Quality Assessment'],
                'score-badges' => ['de' => 'Fachabzeichen', 'en' => 'Technical Badge'],
                'score-levels' => ['de' => 'Expertenlevel', 'en' => 'Expert Level'],
                'score-response-rate' => ['de' => 'Antwortquote', 'en' => 'Response Rate'],
                'score-reputation' => ['de' => 'Community-Reputation', 'en' => 'Community Reputation'],
            ],
        ],
        'connect' => [
            'name' => ['de' => 'COMPLYN Connect', 'en' => 'COMPLYN Connect'],
            'pillar' => 'resolve',
            'order' => 5,
            'modules' => [
                'connect-matching' => ['de' => 'Matching', 'en' => 'Matching'],
                'connect-profiles' => ['de' => 'Experten- & Beraterprofile', 'en' => 'Expert & Consultant Profiles'],
                'connect-inquiries' => ['de' => 'Anfragen & Kontakt', 'en' => 'Inquiry & Contact Flow'],
            ],
        ],
        'docs' => [
            'name' => ['de' => 'COMPLYN Docs', 'en' => 'COMPLYN Docs'],
            'pillar' => 'manage',
            'order' => 6,
            'modules' => [
                'docs-filing' => ['de' => 'Dokumentenablage', 'en' => 'Document Filing'],
                'docs-versions' => ['de' => 'Versionsverwaltung', 'en' => 'Version Management'],
                'docs-expiry' => ['de' => 'Ablaufdaten', 'en' => 'Expiration Dates'],
                'docs-reminders' => ['de' => 'Erinnerungen', 'en' => 'Reminders'],
                'docs-approvals' => ['de' => 'Freigaben', 'en' => 'Releases (Approval)'],
                'docs-history' => ['de' => 'Dokumentenhistorie', 'en' => 'Document History'],
            ],
        ],
        'library' => [
            'name' => ['de' => 'COMPLYN Library', 'en' => 'COMPLYN Library'],
            'pillar' => 'resolve',
            'order' => 7,
            'modules' => [
                'library-templates' => ['de' => 'Vorlagen', 'en' => 'Templates'],
                'library-models' => ['de' => 'Musterdokumente', 'en' => 'Model Documents'],
                'library-checklists' => ['de' => 'Checklisten', 'en' => 'Checklists'],
                'library-practices' => ['de' => 'Best Practices', 'en' => 'Best Practices'],
                'library-articles' => ['de' => 'Fachbeiträge', 'en' => 'Technical Contributions'],
            ],
        ],
        'creator' => [
            'name' => ['de' => 'COMPLYN Creator', 'en' => 'COMPLYN Creator'],
            'pillar' => 'resolve',
            'order' => 8,
            'modules' => [
                'creator-documents' => ['de' => 'KI-Dokumentenerstellung', 'en' => 'AI Document Creation'],
            ],
        ],
        'academy' => [
            'name' => ['de' => 'COMPLYN Academy', 'en' => 'COMPLYN Academy'],
            'pillar' => 'improve',
            'order' => 9,
            'modules' => [
                'academy-trainings' => ['de' => 'Schulungsunterlagen', 'en' => 'Training Documents'],
                'academy-instructions' => ['de' => 'Unterweisung', 'en' => 'Instruction'],
                'academy-tests' => ['de' => 'Lerntests', 'en' => 'Learning Tests'],
                'academy-participants' => ['de' => 'Teilnehmerverwaltung', 'en' => 'Participation Administration'],
                'academy-evidence' => ['de' => 'Nachweise', 'en' => 'Evidence'],
            ],
        ],
        'exchange' => [
            'name' => ['de' => 'COMPLYN Exchange', 'en' => 'COMPLYN Exchange'],
            'pillar' => 'improve',
            'order' => 10,
            'modules' => [
                'exchange-sections' => ['de' => 'Fachbereiche', 'en' => 'Specialized Sections'],
                'exchange-networks' => ['de' => 'Themennetzwerke', 'en' => 'Thematic Networks'],
                'exchange-discussions' => ['de' => 'Diskussionen', 'en' => 'Discussions'],
                'exchange-expert-groups' => ['de' => 'Expertengruppen', 'en' => 'Expert Groups'],
                'exchange-content' => ['de' => 'Community-Inhalte', 'en' => 'Community Content'],
            ],
        ],
    ],
];
