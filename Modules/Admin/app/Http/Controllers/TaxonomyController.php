<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Industry;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaxonomyController extends Controller
{
    private const TYPES = ['industries' => Industry::class, 'categories' => Category::class, 'tags' => Tag::class];

    public function index(): View
    {
        return view('admin::taxonomy', [
            'industries' => Industry::orderBy('name_de')->get(),
            'categories' => Category::orderBy('name_de')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $model = self::TYPES[$type] ?? abort(404);

        $data = $request->validate(
            $type === 'tags'
                ? ['name' => 'required|string|max:255|unique:'.$type.',name']
                : ['name_de' => 'required|string|max:255', 'name_en' => 'required|string|max:255']
        );

        if ($type !== 'tags') {
            $data['key'] = \Illuminate\Support\Str::slug($data['name_en']);
        }

        $model::create($data);

        return back()->with('status', 'Eintrag angelegt.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $model = self::TYPES[$type] ?? abort(404);
        $model::findOrFail($id)->delete();

        return back()->with('status', 'Eintrag gelöscht.');
    }
}
