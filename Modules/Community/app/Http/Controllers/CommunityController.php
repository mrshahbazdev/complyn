<?php

namespace Modules\Community\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommunityGroup;
use App\Models\CommunityPost;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function index(Request $request)
    {
        $company = $this->company($request);
        return view('community::index', [
            'posts' => CommunityPost::where('company_id', $company->id)->with('user')->withCount('comments')->latest()->paginate(20),
            'groups' => CommunityGroup::where('company_id', $company->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->company($request);
        $post = CommunityPost::create($request->validate([
            'title' => 'required|string|max:255', 'body' => 'required|string',
        ]) + ['company_id' => $company->id, 'user_id' => $request->user()->id]);
        return redirect()->route('community.show', $post);
    }

    public function show(Request $request, CommunityPost $post)
    {
        abort_unless($post->company_id === $this->company($request)->id, 403);
        return view('community::show', ['post' => $post->load(['user', 'comments.user'])]);
    }

    public function comment(Request $request, CommunityPost $post)
    {
        abort_unless($post->company_id === $this->company($request)->id, 403);
        $post->comments()->create($request->validate(['body' => 'required|string']) + ['user_id' => $request->user()->id]);
        return back();
    }

    public function storeGroup(Request $request)
    {
        $company = $this->company($request);
        CommunityGroup::create($request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']) + ['company_id' => $company->id]);
        return back()->with('status', 'Gruppe angelegt.');
    }
}
