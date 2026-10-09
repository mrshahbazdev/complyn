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
        return view('community::show', ['post' => $post->load(['user', 'comments' => fn ($q) => $q->withCount('votes')->with('user')])]);
    }

    public function comment(Request $request, CommunityPost $post)
    {
        abort_unless($post->company_id === $this->company($request)->id, 403);
        $post->comments()->create($request->validate(['body' => 'required|string']) + ['user_id' => $request->user()->id]);
        if ($post->status === 'open') {
            $post->update(['status' => 'answered']);
        }
        return back();
    }

    public function storeGroup(Request $request)
    {
        $company = $this->company($request);
        CommunityGroup::create($request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']) + ['company_id' => $company->id]);
        return back()->with('status', 'Gruppe angelegt.');
    }

    public function vote(Request $request, \App\Models\CommunityComment $comment)
    {
        $post = $comment->post;
        abort_unless($post->company_id === $this->company($request)->id, 403);
        $existing = \App\Models\CommunityVote::where('community_comment_id', $comment->id)->where('user_id', $request->user()->id)->first();
        $existing ? $existing->delete() : \App\Models\CommunityVote::create(['community_comment_id' => $comment->id, 'user_id' => $request->user()->id]);
        return back();
    }

    public function accept(Request $request, CommunityPost $post, \App\Models\CommunityComment $comment)
    {
        abort_unless($post->company_id === $this->company($request)->id, 403);
        abort_unless($comment->community_post_id === $post->id, 404);
        $accepted = $post->accepted_comment_id === $comment->id;
        $post->update([
            'accepted_comment_id' => $accepted ? null : $comment->id,
            'status' => $accepted ? 'open' : 'answered',
        ]);
        return back();
    }
}
