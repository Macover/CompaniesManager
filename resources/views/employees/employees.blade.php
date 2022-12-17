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
                                    <input value="{{$employee->id}}" type="hidden"/>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 d-flex gap-2">
                                                <button class="btn btn-warning flex-1 show-alert-edit-modal">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline flex-1"
                                                    action="{{ route('employees.destroy', ['employee' => $employee->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" class="companyName" value="{{ $employee->first_name }}">
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

            $('#newEmployeeBtn').click(async function(e){
                e.preventDefault();
                const employeePromise = await Swal.fire({
                    title: 'New Employee',
                    html: `
                        <form id="addEmployeeForm" action="{{ route('employees.store') }}" method="post"
                        class="form">
                        @csrf
                            <div class="mb-3 d-flex flex-column">
                                <label for="name" class="form-label text-start">First name</label>
                                <input name="first_name" placeholder="Mike" type="text"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="last_name" class="form-label text-start">Last name</label>
                                <input name="last_name" placeholder="Johnson" type="text"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="name" class="form-label text-start">Company</label>
                                <select class="form-select form-select-lg" name="company_id">
                                    <option selected>Select one</option>
                                    @foreach ($companies as $company)
                                    <option value={{ $company->id }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            <div class="mb-3 d-flex flex-column">
                                <label for="email" class="form-label text-start">Email</label>
                                <input name="email" placeholder="address@email.com" type="email"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="phone" class="form-label text-start">Phone</label>
                                <input name="phone" placeholder="+11 342342543" type="text"
                                    class="form-control">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Create',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const form = $('#addEmployeeForm');
                        form.submit();
                    }
                })
            });

            $('.show-alert-edit-modal').click(async function (e) {
                e.preventDefault();
                const rowValues = $(this).closest("tr").children();

                const employeeId = rowValues[5].value;
                const firstName = rowValues[0].innerHTML;
                const lastName = rowValues[1].innerHTML;
                const companyName = rowValues[2].innerHTML;
                const email = rowValues[3].innerHTML;
                const phone = rowValues[4].innerHTML;

                const employeePromise = await Swal.fire({
                    title: `Edit Employee`,
                    html: `
                        <form id="updateForm" action="{{ route('employees.update') }}" method="post"
                        class="form">
                        @method('PATCH')
                        @csrf
                            <input value="${employeeId}" name="employee_id" type="hidden"/>
                            <div class="mb-3 d-flex flex-column">
                                <label for="name" class="form-label text-start">First name</label>
                                <input value="${firstName}" name="first_name" placeholder="Mike" type="text"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="last_name" class="form-label text-start">Last name</label>
                                <input value="${lastName}" name="last_name" placeholder="Johnson" type="text"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="name" class="form-label text-start">Company</label>
                                <select class="form-select form-select-lg" name="company_id">
                                    @foreach ($companies as $company)
                                        <option
                                        ${companyName == "{{$company->name}}" ? 'selected' : ''}
                                        value={{ $company->id }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            <div class="mb-3 d-flex flex-column">
                                <label for="email" class="form-label text-start">Email</label>
                                <input value="${email}" name="email" placeholder="address@email.com" type="email"
                                    class="form-control">
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="phone" class="form-label text-start">Phone</label>
                                <input value="${phone}" name="phone" placeholder="+11 342342543" type="text"
                                    class="form-control">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const form = $('#updateForm');
                        form.submit();
                    }
                })
            })

            $('.show-alert-delete-box').click(function(event) {
                event.preventDefault();
                let form = $(this).closest("form");
                let companyName = $(this).siblings()[2].value;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `${companyName} will be deleted`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })

            })
        })
    </script>
@endsection
