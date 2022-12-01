<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        return view('companies.companies', [
            'companies' => $companies
        ]);
    }

    public function store(CompanyStoreRequest $company)
    {
        // dd($company);
        return DB::transaction(function () use ($company) {
            $companyCreated = Company::create($company->validated());
            return response()->json($companyCreated);
        });
    }

    public function destroy(Company $company)
    {
        return DB::transaction(function () use ($company) {
            $company->delete();
            return redirect()
                    ->route('companies')
                    ->with(['successDeleted' => "{$company->name} was deleted successfully"]);
        });
    }
}
