<?php

namespace Modules\Docs\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocsController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    private function scopeDoc(Request $request, Document $document): Document
    {
        abort_unless($document->company_id === $this->company($request)->id, 403);
        return $document;
    }

    public function index(Request $request)
    {
        $company = $this->company($request);
        $docs = Document::where('company_id', $company->id)
            ->with(['category', 'latestVersion', 'tags'])
            ->when($request->query('q'), fn ($w, $q) => $w->where('title', 'like', "%{$q}%"))
            ->when($request->query('category'), fn ($w, $c) => $w->where('category_id', $c))
            ->when($request->query('status'), fn ($w, $s) => $w->where('status', $s))
            ->latest()->paginate(25);

        return view('docs::index', [
            'docs' => $docs,
            'categories' => Category::orderBy('name_de')->get(),
        ]);
    }

    public function create(Request $request)
    {
        return view('docs::create', ['categories' => Category::orderBy('name_de')->get()]);
    }

    public function store(Request $request, StorageService $storage)
    {
        $company = $this->company($request);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'file' => 'nullable|file|max:51200',
            'expires_at' => 'nullable|date',
        ]);

        $doc = Document::create($data + ['company_id' => $company->id, 'uploaded_by' => $request->user()->id, 'status' => 'published']);

        if ($request->hasFile('file')) {
            $f = $request->file('file');
            $doc->versions()->create([
                'version' => 1, 'path' => $storage->put($f, $company->id, 'documents'),
                'original_name' => $f->getClientOriginalName(), 'size' => $f->getSize(), 'mime' => $f->getMimeType(),
            ]);
        }
        if ($request->filled('tags')) {
            $doc->syncTagNames(array_map('trim', explode(',', $request->input('tags'))));
        }

        return redirect()->route('docs.show', $doc)->with('status', __('Dokument angelegt.'));
    }

    public function show(Request $request, Document $document)
    {
        return view('docs::show', ['doc' => $this->scopeDoc($request, $document)->load(['versions', 'tags', 'category'])]);
    }

    public function update(Request $request, Document $document)
    {
        $doc = $this->scopeDoc($request, $document);
        $doc->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived,released',
            'expires_at' => 'nullable|date',
        ]));
        if ($request->filled('tags')) {
            $doc->syncTagNames(array_map('trim', explode(',', $request->input('tags'))));
        }

        return back()->with('status', __('Dokument aktualisiert.'));
    }

    public function destroy(Request $request, Document $document)
    {
        $doc = $this->scopeDoc($request, $document);
        $disk = Storage::disk(config('filesystems.documents_disk', 'local'));
        foreach ($doc->versions as $v) { $disk->delete($v->path); }
        $doc->delete();

        return redirect()->route('docs.index')->with('status', __('Dokument gelöscht.'));
    }

    public function uploadVersion(Request $request, Document $document, StorageService $storage)
    {
        $doc = $this->scopeDoc($request, $document);
        $request->validate(['file' => 'required|file|max:51200']);
        $company = $this->company($request);
        $f = $request->file('file');
        $doc->versions()->create([
            'version' => ($doc->versions()->max('version') ?? 0) + 1,
            'path' => $storage->put($f, $company->id, 'documents'),
            'original_name' => $f->getClientOriginalName(), 'size' => $f->getSize(), 'mime' => $f->getMimeType(),
        ]);

        return back()->with('status', __('Neue Version hochgeladen.'));
    }

    public function download(Request $request, Document $document, int $version)
    {
        $doc = $this->scopeDoc($request, $document);
        $v = $doc->versions()->where('version', $version)->firstOrFail();

        return Storage::disk(config('filesystems.documents_disk', 'local'))->download($v->path, $v->original_name);
    }

    public function release(Request $request, \App\Models\Document $document)
    {
        abort_unless($document->company_id === $this->company($request)->id, 403);
        $document->update([
            'released_at' => $document->released_at ? null : now(),
            'status' => $document->released_at ? 'draft' : 'released',
        ]);
        return back()->with('status', $document->released_at ? __('Dokument freigegeben.') : __('Freigabe zurückgezogen.'));
    }}
