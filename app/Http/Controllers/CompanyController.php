<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        // dd($company->logo);
        return DB::transaction(function () use ($company) {
            try {
                $companyValidated = $company->validated();
                $companyPathLogo = Storage::disk('public')->put("Logos",$company->logo);
                // dump($companyValidated);
                // dd($companyValidated['name']);
                Company::create([
                    'name' => $companyValidated['name'],
                    'email' => $companyValidated['email'],
                    'logo' => $companyPathLogo,
                    'website' => $companyValidated['website']
                ]);
                Log::channel('info')->info("The company was created succesfully");
                return redirect()
                    ->route('companies')
                    ->with(['success' => "{$company->name} company was created"]);
            } catch (\Throwable $th) {
                Log::channel('error')->error("The company was not created succesfully {$th}}");
                return redirect()
                    ->route('companies')
                    ->with(['error' => "Was an error in {$company->name}"]);
            }
        });
    }

    public function destroy(Company $company)
    {
        return DB::transaction(function () use ($company) {
            $company->delete();
            return redirect()
                ->route('companies')
                ->with(['success' => "{$company->name} was deleted successfully"]);
        });
    }
}
