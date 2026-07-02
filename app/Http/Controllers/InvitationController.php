<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class InvitationController extends Controller
{
    //
    public function create(Request $request): View
    {
        $user = $request->user();
        $companies = Company::orderBy('name')->get();

        return view('invitations.create', [
            'companies' => $companies,
            'isSuperAdmin' => $user->isSuperAdmin(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $inviter = $request->user();

        if ($inviter->isSuperAdmin()) {
            return $this->storeAsSuperAdmin($request);
        }

        if ($inviter->isAdmin()) {
            return $this->storeAsAdmin($request, $inviter);
        }

        abort(403, 'You are not authorized to invite users.');
    }

    protected function storeAsSuperAdmin(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'new_company_name' => ['nullable', 'string', 'max:255', 'unique:companies,name'],
            'role' => ['required', Rule::in([
                UserRole::Admin->value,
                UserRole::Member->value 
            ])],
        ]);

        $isNewCompany = filled($data['new_company_name'] ?? null);

        if (! $isNewCompany && blank($data['company_id'] ?? null)) {
            return back()
                ->withErrors(['company_id' => 'Choose an existing company or provide a new company name.'])
                ->withInput();
        }

        
        if ($isNewCompany && $data['role'] === UserRole::Admin->value) {
            return back()
                ->withErrors(['role' => 'SuperAdmin cannot invite an Admin into a newly created company.'])
                ->withInput();
        }

        $company = $isNewCompany
            ? Company::create(['name' => $data['new_company_name']])
            : Company::findOrFail($data['company_id']);

        return $this->createInvitedUser($data, $company->id, $data['role']);
    }

    protected function storeAsAdmin(Request $request, User $inviter): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'], 
            'role' => ['required', Rule::in([
                UserRole::Admin->value,
                UserRole::Member->value,
            ])],
        ]);

        return $this->createInvitedUser($data, $inviter->company_id, $data['role']);
    }

    protected function createInvitedUser(array $data, int $companyId, string $role): RedirectResponse
    {
        $temporaryPassword = Str::password(12);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($temporaryPassword),
            'role' => $role,
            'company_id' => $companyId,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', "Invited {$data['email']} as ".UserRole::from($role)->label().". Temporary password: {$temporaryPassword}");
    }
}
