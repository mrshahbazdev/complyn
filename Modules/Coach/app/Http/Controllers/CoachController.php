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
}
