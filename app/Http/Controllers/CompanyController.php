<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use Cloudinary\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Http\Request;
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

        return DB::transaction(function () use ($company) {
            try {
                $companyValidated = $company->validated();

                $company = Company::create($companyValidated);
                $company->attachMedia($company->logo);

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

    public function update(CompanyUpdateRequest $companyRequest)
    {

        return DB::transaction(function () use ($companyRequest) {
            try {

                $company = Company::where('id', $companyRequest->company_id)->first();
                $company->update($companyRequest->validated());

                if ($companyRequest->logo != null) {
                    $company->updateMedia($companyRequest->logo);
                }

                Log::channel('info')->info("The company was updated succesfully");
                return redirect()
                    ->route('companies')
                    ->with(['success' => "{$companyRequest->name} company was updated"]);
            } catch (\Throwable $th) {
                Log::channel('error')->error("The company was not be updated{$th}}");
                return redirect()
                    ->route('companies')
                    ->with(['error' => "Was an error in {$companyRequest->name}"]);
            }
        });
    }

    public function destroy(Company $company)
    {

        return DB::transaction(function () use ($company) {
            try {
                if ($company->employees()->count() == 0) {
                    $company->delete();
                    return redirect()
                        ->route('companies')
                        ->with(['success' => "{$company->name} was deleted successfully"]);
                } else {
                    return redirect()
                        ->route('companies')
                        ->with(['error' => "The company has employees, can't be deleted."]);
                }
            } catch (\Throwable $th) {
                Log::channel('error')->error("The company was not be updated{$th}}");
                return redirect()
                    ->route('companies')
                    ->with(['errors' => "Was an error in {$company->name}"]);
            }
        });
    }
}
