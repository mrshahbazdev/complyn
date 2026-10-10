<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LibraryArticle;
use App\Models\LibraryTemplate;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->companies()->first();
        return view('library::index', [
            'articles' => LibraryArticle::where(fn ($q) => $q->whereNull('company_id')->orWhere('company_id', $company?->id))
                ->when($request->query('q'), fn ($w, $s) => $w->where(fn ($x) => $x->where('title', 'like', "%{$s}%")->orWhere('body', 'like', "%{$s}%")))
                ->latest()->paginate(20),
            'templates' => LibraryTemplate::where(fn ($q) => $q->whereNull('company_id')->orWhere('company_id', $company?->id))->latest()->get(),
            'categories' => Category::orderBy('name_de')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $company = $request->user()->companies()->firstOrFail();
        LibraryArticle::create($request->validate([
            'title' => 'required|string|max:255', 'body' => 'required|string', 'category_id' => 'nullable|exists:categories,id',
        ]) + ['company_id' => $company->id]);
        return back()->with('status', __('Artikel gespeichert.'));
    }

    public function show(LibraryArticle $article)
    {
        return view('library::show', ['article' => $article]);
    }

    public function template(LibraryTemplate $template)
    {
        return view('library::template', ['template' => $template]);
    }

    public function downloadTemplate(LibraryTemplate $template)
    {
        return response($template->content, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . \Illuminate\Support\Str::slug($template->name) . '.md"',
        ]);
    }
}
