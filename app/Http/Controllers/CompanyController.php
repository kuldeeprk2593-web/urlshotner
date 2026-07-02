<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

 
class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::withCount(['users', 'shortUrls'])
            ->orderBy('name')
            ->get();

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name'],
        ]);

        Company::create($data);

        return redirect()->route('companies.index')->with('status', 'Company created.');
    }
}
