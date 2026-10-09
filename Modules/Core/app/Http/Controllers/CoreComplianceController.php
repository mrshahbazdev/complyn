<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoreDeadline;
use App\Models\CoreEvidence;
use App\Models\CoreObligation;
use App\Models\CoreResponsibility;
use App\Models\CoreTask;
use App\Models\File;
use App\Services\StorageService;
use Illuminate\Http\Request;

class CoreComplianceController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    private function members(Request $request)
    {
        return $this->company($request)->users()->orderBy('name')->get();
    }

    // Pflichtenkalender
    public function obligations(Request $request)
    {
        $company = $this->company($request);

        return view('core::obligations', [
            'obligations' => CoreObligation::where('company_id', $company->id)
                ->with(['responsibilities.user'])->withCount('evidences')->orderBy('next_due_at')->paginate(30),
            'members' => $this->members($request),
        ]);
    }

    public function storeObligation(Request $request)
    {
        $company = $this->company($request);
        CoreObligation::create($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interval_months' => 'nullable|integer|min:1|max:120',
            'next_due_at' => 'nullable|date',
        ]) + ['company_id' => $company->id]);

        return back()->with('status', 'Pflicht angelegt.');
    }

    public function updateObligationStatus(Request $request, CoreObligation $obligation)
    {
        abort_unless($obligation->company_id === $this->company($request)->id, 403);
        $data = $request->validate(['status' => 'required|in:active,paused,done']);
        $obligation->update($data);
        if ($data['status'] === 'done' && $obligation->interval_months) {
            $obligation->update([
                'next_due_at' => now()->addMonths($obligation->interval_months)->toDateString(),
                'status' => 'active',
            ]);
        }

        return back()->with('status', 'Pflicht aktualisiert.');
    }

    public function assignResponsible(Request $request, CoreObligation $obligation)
    {
        $company = $this->company($request);
        abort_unless($obligation->company_id === $company->id, 403);
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string|max:120',
        ]);
        CoreResponsibility::updateOrCreate(
            ['core_obligation_id' => $obligation->id, 'user_id' => $data['user_id']],
            ['company_id' => $company->id, 'role' => $data['role'] ?? 'Verantwortlich'],
        );

        return back()->with('status', 'Verantwortung zugewiesen.');
    }

    // Fristen
    public function deadlines(Request $request)
    {
        $company = $this->company($request);

        return view('core::deadlines', [
            'deadlines' => CoreDeadline::where('company_id', $company->id)
                ->with(['obligation', 'responsible'])->orderByRaw("status='done', due_at")->paginate(50),
            'obligations' => CoreObligation::where('company_id', $company->id)->orderBy('title')->get(),
            'members' => $this->members($request),
        ]);
    }

    public function storeDeadline(Request $request)
    {
        $company = $this->company($request);
        CoreDeadline::create($request->validate([
            'title' => 'required|string|max:255',
            'due_at' => 'required|date',
            'core_obligation_id' => 'nullable|exists:core_obligations,id',
            'responsible_id' => 'nullable|exists:users,id',
        ]) + ['company_id' => $company->id]);

        return back()->with('status', 'Frist angelegt.');
    }

    public function toggleDeadline(Request $request, CoreDeadline $deadline)
    {
        abort_unless($deadline->company_id === $this->company($request)->id, 403);
        $deadline->update(['status' => $deadline->status === 'done' ? 'open' : 'done']);

        return back();
    }

    public function destroyDeadline(Request $request, CoreDeadline $deadline)
    {
        abort_unless($deadline->company_id === $this->company($request)->id, 403);
        $deadline->delete();

        return back()->with('status', 'Frist gelöscht.');
    }

    // Aufgaben
    public function tasks(Request $request)
    {
        $company = $this->company($request);

        return view('core::tasks', [
            'tasks' => CoreTask::where('company_id', $company->id)
                ->with('assignee')->orderByRaw("status='done', due_at is null, due_at")->paginate(50),
            'members' => $this->members($request),
        ]);
    }

    public function storeTask(Request $request)
    {
        $company = $this->company($request);
        CoreTask::create($request->validate([
            'title' => 'required|string|max:255',
            'due_at' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]) + ['company_id' => $company->id]);

        return back()->with('status', 'Aufgabe angelegt.');
    }

    public function toggleTask(Request $request, CoreTask $task)
    {
        abort_unless($task->company_id === $this->company($request)->id, 403);
        $task->update(['status' => $task->status === 'done' ? 'open' : 'done']);

        return back();
    }

    public function destroyTask(Request $request, CoreTask $task)
    {
        abort_unless($task->company_id === $this->company($request)->id, 403);
        $task->delete();

        return back()->with('status', 'Aufgabe gelöscht.');
    }

    // Nachweise
    public function evidences(Request $request)
    {
        $company = $this->company($request);

        return view('core::evidences', [
            'evidences' => CoreEvidence::where('company_id', $company->id)
                ->with(['obligation', 'file'])->latest()->paginate(50),
            'obligations' => CoreObligation::where('company_id', $company->id)->orderBy('title')->get(),
        ]);
    }

    public function storeEvidence(Request $request, StorageService $storage)
    {
        $company = $this->company($request);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'nullable|string',
            'core_obligation_id' => 'required|exists:core_obligations,id',
            'file' => 'nullable|file|max:51200',
        ]);
        $fileId = null;
        if ($request->hasFile('file')) {
            $f = $request->file('file');
            $path = $storage->put($f, $company->id, 'evidence');
            $file = File::create([
                'company_id' => $company->id, 'uploaded_by' => $request->user()->id,
                'path' => $path, 'original_name' => $f->getClientOriginalName(),
                'size' => $f->getSize(), 'mime' => $f->getMimeType(),
            ]);
            $fileId = $file->id;
        }
        CoreEvidence::create($data + ['company_id' => $company->id, 'file_id' => $fileId]);

        return back()->with('status', 'Nachweis angelegt.');
    }

    public function destroyEvidence(Request $request, CoreEvidence $evidence)
    {
        abort_unless($evidence->company_id === $this->company($request)->id, 403);
        $evidence->delete();

        return back()->with('status', 'Nachweis gelöscht.');
    }
}
