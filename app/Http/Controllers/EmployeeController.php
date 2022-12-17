<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.employees', [
            'companies' => Company::all(),
            'employees' => Employee::all()
        ]);
    }

    public function store(EmployeeStoreRequest $employeeRequest)
    {
        return DB::transaction(function () use ($employeeRequest) {
            try {

                $employee = Employee::create($employeeRequest->validated());
                Log::channel('info')->info('The employee was created');

                return redirect()
                    ->route('employees')
                    ->with(['success' => "{$employee->first_name} was created"]);
            } catch (\Throwable $th) {
                Log::channel('error')->error('The employee was not created' . $th);
                return redirect()
                    ->route('employees')
                    ->with(['error' => "Was an error in {$employeeRequest->name}"]);
            }
        });
    }

    public function update(EmployeeStoreRequest $employeeRequest)
    {
        return DB::transaction(function () use ($employeeRequest) {
            try {
                $employee = Employee::where('id',$employeeRequest->employee_id)->first();
                $employee->update($employeeRequest->validated());
                Log::channel('info')->info("The employee was updated succesfully");
                return redirect()
                    ->route('employees')
                    ->with(['success' => "Employee updated!"]);

            } catch (\Throwable $th) {
                Log::channel('error')->error("The employee wasn't been updated{$th}}");
                return redirect()
                    ->route('employees')
                    ->with(['error' => "Was an error in {$employeeRequest->name}"]);
            }
        });
    }

    public function destroy(Employee $employee)
    {
        return DB::transaction(function () use ($employee) {
            try {
                Log::channel('info')->info("{$employee->first_name}".'The employee was deleted');
                $employee->delete();
                return redirect()
                    ->route('employees')
                    ->with(['success' => "{$employee->first_name} was deleted successfully"]);
            } catch (\Throwable $th) {
                Log::channel('error')->error('The employee was not created' . $th);
                return redirect()
                    ->route('employees')
                    ->with(['error' => "{$employee->first_name} wasn't be deleted"]);
            }
        });
    }
}
