<?php

namespace Modules\Creator\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreatorDraft;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function index(Request $request)
    {
        $company = $this->company($request);
        return view('creator::index', [
            'drafts' => CreatorDraft::where('company_id', $company->id)->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->company($request);
        CreatorDraft::create($request->validate([
            'title' => 'required|string|max:255', 'type' => 'required|in:document,checklist,policy',
        ]) + ['company_id' => $company->id, 'user_id' => $request->user()->id]);
        return back()->with('status', 'Entwurf angelegt.');
    }

    public function generate(Request $request, CreatorDraft $draft)
    {
        abort_unless($draft->company_id === $this->company($request)->id, 403);
        $draft->update(['content' => app(\App\Services\AiService::class)->complete(
            'Erstelle ein kurzes, praxistaugliches deutsches Compliance-'.$draft->type.'-Dokument.',
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
}
