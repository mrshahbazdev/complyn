<?php

namespace Modules\Exchange\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExchangeListing;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function index(Request $request)
    {
        $company = $this->company($request);
        return view('exchange::index', [
            'listings' => ExchangeListing::where('company_id', $company->id)->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->company($request);
        ExchangeListing::create($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:offer,need',
        ]) + ['company_id' => $company->id]);
        return back()->with('status', 'Eintrag angelegt.');
    }

    public function inquire(Request $request, ExchangeListing $listing)
    {
        abort_unless($listing->company_id === $this->company($request)->id, 403);
        $listing->inquiries()->create($request->validate(['message' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back()->with('status', 'Anfrage gesendet.');
    }

    public function close(Request $request, ExchangeListing $listing)
    {
        abort_unless($listing->company_id === $this->company($request)->id, 403);
        $listing->update(['status' => 'closed']);
        return back()->with('status', 'Geschlossen.');
    }
}
