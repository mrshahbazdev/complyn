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

    public function experts(Request $request)
    {
        $company = $this->company($request);
        $q = \App\Models\ConnectExpert::query()->with('industry');
        if ($request->filled('specialty')) {
            $q->where('specialty', 'like', '%' . $request->specialty . '%');
        }
        if ($request->filled('industry_id')) {
            $q->where('industry_id', $request->industry_id);
        }
        if ($request->filled('location')) {
            $q->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('availability')) {
            $q->where('availability', $request->availability);
        }
        if ($request->filled('min_exp')) {
            $q->where('experience_years', '>=', $request->min_exp);
        }
        return view('connect::experts', [
            'experts' => $q->orderByDesc('rating')->paginate(20),
            'industries' => \App\Models\Industry::orderBy('name_de')->get(),
        ]);
    }

    public function storeExpert(Request $request)
    {
        $company = $this->company($request);
        \App\Models\ConnectExpert::create($request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'industry_id' => 'nullable|exists:industries,id',
            'location' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'hourly_rate' => 'nullable|numeric|min:0',
            'availability' => 'nullable|in:available,busy,unavailable',
            'bio' => 'nullable|string',
        ]) + ['company_id' => $company->id, 'user_id' => $request->user()->id]);
        return back()->with('status', 'Expertenprofil angelegt.');
    }}
