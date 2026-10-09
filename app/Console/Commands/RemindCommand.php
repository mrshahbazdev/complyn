<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\CoreDeadline;
use App\Models\CoreObligation;
use App\Models\CoreTask;
use App\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemindCommand extends Command
{
    protected $signature = 'complyn:remind';

    protected $description = 'Send due-date reminders for obligations, deadlines, tasks and expiring documents.';

    public function handle(): int
    {
        $sent = 0;
        foreach (Company::all() as $company) {
            $users = $company->users()->pluck('users.id')->all();
            if (! $users) {
                continue;
            }
            $notify = function (string $title, string $body, string $link = null) use ($users, &$sent) {
                foreach ($users as $uid) {
                    DB::table('notifications')->insert([
                        'id' => (string) \Illuminate\Support\Str::uuid(),
                        'type' => 'App\\Notifications\\Reminder',
                        'notifiable_type' => 'App\\Models\\User',
                        'notifiable_id' => $uid,
                        'data' => json_encode(['title' => $title, 'body' => $body, 'link' => $link]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $sent++;
                }
            };

            CoreObligation::where('company_id', $company->id)
                ->where('status', 'active')
                ->whereDate('next_due_at', '<=', now()->addDays(7))
                ->get()->each(fn ($o) => $notify('Pflicht fällig', $o->title.' — fällig am '.$o->next_due_at, route('core.obligations')));

            CoreDeadline::where('company_id', $company->id)
                ->where('status', 'open')
                ->whereDate('due_at', '<=', now()->addDays(3))
                ->get()->each(fn ($d) => $notify('Frist läuft ab', $d->title.' — '.$d->due_at, route('core.deadlines')));

            CoreTask::where('company_id', $company->id)
                ->where('status', 'open')
                ->whereDate('due_at', '<=', now()->addDays(2))
                ->get()->each(fn ($t) => $notify('Aufgabe fällig', $t->title.' — '.$t->due_at, route('core.tasks')));

            Document::where('company_id', $company->id)
                ->whereNotNull('expires_at')
                ->whereDate('expires_at', '<=', now()->addDays(30))
                ->get()->each(fn ($d) => $notify('Dokument läuft ab', $d->title.' — läuft ab am '.$d->expires_at, route('docs.show', $d)));
        }
        $this->info("{$sent} Erinnerungen versendet.");

        return self::SUCCESS;
    }
}
