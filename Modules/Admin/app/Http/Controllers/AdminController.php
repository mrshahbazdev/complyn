<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Industry;
use App\Models\McpAuditLog;
use App\Models\Plan;
use App\Models\PlatformModule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin::dashboard', [
            'stats' => [
                'companies' => Company::count(),
                'users' => User::count(),
                'modules' => PlatformModule::where('status', '!=', 'deprecated')->count(),
                'mcp_calls' => McpAuditLog::count(),
            ],
            'companies' => Company::with('plan')->latest()->take(8)->get(),
            'logs' => McpAuditLog::latest()->take(8)->get(),
        ]);
    }

    public function companies(): View
    {
        return view('admin::companies', [
            'companies' => Company::with(['plan', 'industry'])->withCount('users')->paginate(25),
            'plans' => Plan::where('is_active', true)->get(),
            'industries' => Industry::orderBy('name_de')->get(),
            'modules' => PlatformModule::where('status', '!=', 'deprecated')->orderBy('block_key')->orderBy('key')->get(),
        ]);
    }

    public function storeCompany(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:companies,slug',
            'plan_id' => 'required|exists:plans,id',
            'industry_id' => 'nullable|exists:industries,id',
        ]);

        Company::create($data);

        return back()->with('status', 'Unternehmen angelegt.');
    }

    public function updateCompany(Request $request, Company $company): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'industry_id' => 'nullable|exists:industries,id',
        ]);

        $company->update($data);

        return back()->with('status', 'Unternehmen aktualisiert.');
    }

    public function destroyCompany(Company $company): RedirectResponse
    {
        $company->delete();

        return back()->with('status', 'Unternehmen gelöscht.');
    }

    public function toggleCompanyModule(Request $request, Company $company, PlatformModule $module): RedirectResponse
    {
        $enabled = $request->boolean('enabled');
        $company->moduleOverrides()->syncWithoutDetaching([$module->id => ['enabled' => $enabled]]);

        return back()->with('status', 'Modul '.($enabled ? 'aktiviert' : 'deaktiviert').'.');
    }

    public function users(): View
    {
        return view('admin::users', [
            'users' => User::with('companies')->paginate(25),
            'companies' => Company::orderBy('name')->get(),
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'company_id' => 'nullable|exists:companies,id',
            'role' => 'nullable|in:owner,admin,member',
            'is_platform_admin' => 'boolean',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_platform_admin' => $request->boolean('is_platform_admin'),
        ]);

        if (! empty($data['company_id'])) {
            $user->companies()->attach($data['company_id'], ['role' => $data['role'] ?? 'member']);
        }

        return back()->with('status', 'Benutzer angelegt.');
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_platform_admin' => 'boolean',
        ]);

        $user->update(['name' => $data['name'], 'is_platform_admin' => $request->boolean('is_platform_admin')]);

        return back()->with('status', 'Benutzer aktualisiert.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        abort_if($user->id === request()->user()->id, 422, 'Eigenes Konto kann nicht gelöscht werden.');
        $user->delete();

        return back()->with('status', 'Benutzer gelöscht.');
    }

    public function attachCompany(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'role' => ['required', Rule::in(['owner', 'admin', 'member'])],
        ]);

        $user->companies()->syncWithoutDetaching([$data['company_id'] => ['role' => $data['role']]]);

        return back()->with('status', 'Unternehmen zugeordnet.');
    }

    public function plans(): View
    {
        return view('admin::plans', [
            'plans' => Plan::withCount('companies')->get(),
            'modules' => PlatformModule::where('status', '!=', 'deprecated')->orderBy('block_key')->orderBy('key')->get(),
        ]);
    }

    public function storePlan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug',
            'price_cents' => 'required|integer|min:0',
        ]);

        Plan::create($data + ['is_active' => true]);

        return back()->with('status', 'Tarif angelegt.');
    }

    public function updatePlan(Request $request, Plan $plan): RedirectResponse
    {
        $plan->update($request->validate([
            'name' => 'required|string|max:255',
            'price_cents' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('status', 'Tarif aktualisiert.');
    }

    public function togglePlanModule(Request $request, Plan $plan, PlatformModule $module): RedirectResponse
    {
        if ($request->boolean('enabled')) {
            $plan->modules()->syncWithoutDetaching([$module->id]);
        } else {
            $plan->modules()->detach($module->id);
        }

        return back()->with('status', 'Tarif-Modul aktualisiert.');
    }

    public function modules(): View
    {
        return view('admin::modules', [
            'blocks' => config('blocks.blocks'),
            'modules' => PlatformModule::orderBy('block_key')->orderBy('key')->get()->groupBy('block_key'),
        ]);
    }

    public function updateModule(Request $request, PlatformModule $module): RedirectResponse
    {
        $module->update($request->validate([
            'status' => ['required', Rule::in(PlatformModule::STATUSES)],
        ]));

        return back()->with('status', 'Modul-Status aktualisiert.');
    }
}
