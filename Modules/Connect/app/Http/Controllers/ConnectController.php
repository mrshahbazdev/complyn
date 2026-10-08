<?php

namespace Modules\Connect\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConnectRequest;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function index(Request $request)
    {
        $company = $this->company($request);
        return view('connect::index', [
            'requests' => ConnectRequest::where('company_id', $company->id)->with('user')->withCount('messages')->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->company($request);
        $r = ConnectRequest::create($request->validate([
            'title' => 'required|string|max:255', 'description' => 'nullable|string',
        ]) + ['company_id' => $company->id, 'user_id' => $request->user()->id]);
        return redirect()->route('connect.show', $r);
    }

    public function show(Request $request, ConnectRequest $connectRequest)
    {
        abort_unless($connectRequest->company_id === $this->company($request)->id, 403);
        return view('connect::show', ['request' => $connectRequest->load(['user', 'messages.user'])]);
    }

    public function message(Request $request, ConnectRequest $connectRequest)
    {
        abort_unless($connectRequest->company_id === $this->company($request)->id, 403);
        $connectRequest->messages()->create($request->validate(['body' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back();
    }

    public function close(Request $request, ConnectRequest $connectRequest)
    {
        abort_unless($connectRequest->company_id === $this->company($request)->id, 403);
        $connectRequest->update(['status' => 'closed']);
        return back()->with('status', 'Anfrage geschlossen.');
    }
}
