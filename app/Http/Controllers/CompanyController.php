<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

        return DB::transaction(function () use ($company) {

            try {
                Company::create($company->validated());
                Log::channel('info')->info("The company was created succesfully");
                return redirect()
                    ->route('companies')
                    ->with(['success' => "{$company->name} was created"]);
            } catch (\Throwable $th) {
                // Log::channel('error')->error("The company was not created succesfully {$th}}");

                dump($company->messages());

                // for ($i = 0; $i < $company->messages(); $i++) {
                //     Log::channel('error')->error("{$i}.- {}}");
                // }
                // foreach ($company->messages() as $key => $error) {
                //     Log::channel('error')->error("{$key}.- {$error}}");
                // }
                return redirect()
                    ->route('companies')
                    ->with(['error' => "{$company->name} error"]);
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
