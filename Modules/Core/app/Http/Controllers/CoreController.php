<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\File;
use App\Models\Industry;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoreController extends Controller
{
    private function company(Request $request)
    {
        return $request->user()->companies()->firstOrFail();
    }

    public function dashboard(Request $request)
    {
        $company = $request->user()->companies()->first();
        return view('core::dashboard', [
            'company' => $company,
            'docsCount' => $company ? Document::where('company_id', $company->id)->count() : 0,
            'filesCount' => $company ? File::where('company_id', $company->id)->count() : 0,
            'notifications' => $request->user()->unreadNotifications()->take(5)->get(),
            'modules' => $company ? $company->enabledModules() : collect(),
            'overdueObligations' => $company ? \App\Models\CoreObligation::where('company_id', $company->id)->where('status', 'active')->where('next_due_at', '<', now()->toDateString())->count() : 0,
            'upcomingDeadlines' => $company ? \App\Models\CoreDeadline::where('company_id', $company->id)->where('status', 'open')->whereBetween('due_at', [now()->toDateString(), now()->addDays(30)->toDateString()])->orderBy('due_at')->take(8)->get() : collect(),
            'openTasks' => $company ? \App\Models\CoreTask::where('company_id', $company->id)->where('status', 'open')->orderBy('due_at')->take(8)->get() : collect(),
        ]);
    }

    public function files(Request $request)
    {
        $company = $this->company($request);
        return view('core::files', ['files' => File::where('company_id', $company->id)->latest()->paginate(30)]);
    }

    public function upload(Request $request, StorageService $storage)
    {
        $request->validate(['file' => 'required|file|max:20480']);
        $company = $this->company($request);
        $f = $request->file('file');
        $path = $storage->put($f, $company->id, 'files');
        File::create([
            'company_id' => $company->id, 'uploaded_by' => $request->user()->id,
            'path' => $path, 'original_name' => $f->getClientOriginalName(),
            'size' => $f->getSize(), 'mime' => $f->getMimeType(),
        ]);
        return back()->with('status', 'Datei hochgeladen.');
    }

    public function download(Request $request, File $file)
    {
        abort_unless($file->company_id === $this->company($request)->id, 403);
        return Storage::disk(config('filesystems.documents_disk', 'local'))->download($file->path, $file->original_name);
    }

    public function destroyFile(Request $request, File $file)
    {
        abort_unless($file->company_id === $this->company($request)->id, 403);
        Storage::disk(config('filesystems.documents_disk', 'local'))->delete($file->path);
        $file->delete();
        return back()->with('status', 'Datei gelöscht.');
    }

    public function notifications(Request $request)
    {
        return view('core::notifications', ['notifications' => $request->user()->notifications()->paginate(30)]);
    }

    public function markRead(Request $request, string $id)
    {
        $request->user()->notifications()->where('id', $id)->first()?->markAsRead();
        return back();
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $results = collect();
        if ($company = $request->user()->companies()->first()) {
            $results = Document::where('company_id', $company->id)
                ->where(fn ($w) => $w->where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%"))
                ->take(20)->get();
        }
        return view('core::search', ['q' => $q, 'results' => $results]);
    }

    public function settings(Request $request)
    {
        return view('core::settings', ['company' => $request->user()->companies()->first(), 'industries' => Industry::orderBy('name_de')->get()]);
    }

    public function updateCompany(Request $request)
    {
        $company = $this->company($request);
        $company->update($request->validate([
            'name' => 'required|string|max:255',
            'industry_id' => 'nullable|exists:industries,id',
        ]));
        return back()->with('status', 'Einstellungen gespeichert.');
    }
}
