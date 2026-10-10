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
        return back()->with('status', __('Eintrag angelegt.'));
    }

    public function inquire(Request $request, ExchangeListing $listing)
    {
        abort_unless($listing->company_id === $this->company($request)->id, 403);
        $listing->inquiries()->create($request->validate(['message' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back()->with('status', __('Anfrage gesendet.'));
    }

    public function close(Request $request, ExchangeListing $listing)
    {
        abort_unless($listing->company_id === $this->company($request)->id, 403);
        $listing->update(['status' => 'closed']);
        return back()->with('status', __('Geschlossen.'));
    }

    public function groups(Request $request)
    {
        return view('exchange::groups', [
            'groups' => \App\Models\ExchangeGroup::withCount('topics')->paginate(30),
        ]);
    }

    public function storeGroup(Request $request)
    {
        \App\Models\ExchangeGroup::create($request->validate(['name' => 'required|string|max:255', 'topic' => 'nullable|string|max:255']));
        return back()->with('status', __('Gruppe angelegt.'));
    }

    public function group(Request $request, \App\Models\ExchangeGroup $group)
    {
        return view('exchange::group', [
            'group' => $group,
            'topics' => $group->topics()->with('user')->withCount('comments')->latest()->paginate(30),
        ]);
    }

    public function storeTopic(Request $request, \App\Models\ExchangeGroup $group)
    {
        $group->topics()->create($request->validate(['title' => 'required|string|max:255', 'body' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back()->with('status', __('Diskussion gestartet.'));
    }

    public function topic(Request $request, \App\Models\ExchangeTopic $topic)
    {
        return view('exchange::topic', ['topic' => $topic->load(['group', 'user', 'comments.user'])]);
    }

    public function comment(Request $request, \App\Models\ExchangeTopic $topic)
    {
        $topic->comments()->create($request->validate(['body' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back();
    }}
