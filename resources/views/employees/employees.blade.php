@extends('layouts.app')

@section('title', 'Admin - Employees')

@section('content')

    <div class="container px-16">
        <div class="row px-10">
            <div class="col-12 px-6">
                <table id="employeeTable" class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Company name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                        <div class="container m-0 p-0 w-100 d-flex my-4 justify-content-end">
                            <button class="btn btn-primary" id="newEmployeeBtn">
                                <i class="fa-solid fa-plus mr-2"></i>
                                New employee
                            </button>
                        </div>
                    </thead>
                    <tbody>
                        @isset($employees)
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ $employee->company->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 d-flex gap-2">
                                                <button class="btn btn-warning flex-1 show-alert-edit-modal">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline flex-1" {{-- action="{{ route('companies.destroy', ['company' => $company->id]) }}" --}}>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-100 btn btn-outline-danger show-alert-delete-box">
                                                        X
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <input type="hidden" value="{{ $employee->id }}" />
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Company name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                Swal.fire(
                    'Done!',
                    `{{ session()->get('success') }}`,
                    'success'
                )
            @endif

            @if (session()->has('errors'))
                Swal.fire(
                    'Error!',
                    '{{ $errors->all()[0] }}',
                    'error'
                );
            @endif

            $('#employeeTable').DataTable();
        })
    </script>
@endsection
