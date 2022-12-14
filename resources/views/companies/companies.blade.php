@extends('layouts.app')

@section('title', 'Admin - Companies')

@section('content')

    <div class="container px-16">
        <div class="row px-10">
            <div class="col-12 px-6">
                <table id="example" class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                        <div class="container m-0 p-0 w-100 d-flex my-4 justify-content-end">
                            <button class="btn btn-primary" id="newCompanyBtn">
                                <i class="fa-solid fa-plus mr-2"></i>
                                New company
                            </button>
                        </div>
                    </thead>
                    <tbody>
                        @isset($companies)
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>
                                        <a href="#" class="alert-link show-alert-logo-modal"
                                            path="{{ $company->logo }}">Open logo</a>
                                    </td>
                                    <td>{{ $company->website }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 d-flex gap-2">
                                                <button class="btn btn-warning flex-1 show-alert-edit-modal">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline flex-1"
                                                    action="{{ route('companies.destroy', ['company' => $company->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" class="companyName" value="{{ $company->name }}">
                                                    <button type="submit"
                                                        class="w-100 btn btn-outline-danger show-alert-delete-box">
                                                        X
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <input type="hidden" value="{{ $company->id }}" />
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Website</th>
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

            $('#example').DataTable();

            $('#newCompanyBtn').click(async function(e) {
                e.preventDefault();
                const companyPromise = await Swal.fire({
                    title: 'New company',
                    html: `
                                <form enctype="multipart/form-data" id="addCompanyForm" action="{{ route('companies.store') }}" method="post" class="form">
                                    @csrf
                                    <div class="mb-3 d-flex flex-column">
                                        <label for="companyName" class="form-label text-start">Company Name</label>
                                        <input name="name" placeholder="Ex. Microsoft" id="companyName" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3 d-flex flex-column">
                                        <label for="companyEmail" class="form-label text-start">Email</label>
                                        <input name="email" placeholder="Ex. microsoft@hotmail.com" id="companyEmail" type="email"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3 d-flex flex-column">
                                        <label for="companyLogo" class="form-label text-start">Logo</label>
                                        <input accept="image/png, image/jpeg" aria-describedby="fileHelpId" name="logo" placeholder="Ex. Path/safds/sdf" id="companyLogo"
                                            type="file" class="form-control">
                                        <div id="fileHelpId" class="form-text text-start">jpg, png*</div>
                                    </div>
                                    <div class="mb-3 d-flex flex-column">
                                        <label for="companyWebSite" class="form-label text-start">Website</label>
                                        <input name="website" placeholder="Ex. microsoft.com" id="companyWebSite" type="text"
                                            class="form-control">
                                    </div>
                                </form>
                            `,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const form = $('#addCompanyForm');
                        form.submit();
                    }
                })
            });

            $('.show-alert-edit-modal').click(async function(e) {
                e.preventDefault();
                let rowsValues = $(this).closest("tr").children();

                const companyId = rowsValues.closest("input")[0].value;
                const companyName = rowsValues[0].innerHTML;
                const companyEmail = rowsValues[1].innerHTML;
                const companyLogoPath = rowsValues[2].children[0].getAttribute("path");
                const companyWebSite = rowsValues[3].innerHTML;

                const companyPromise = await Swal.fire({
                    title: 'Update company',
                    html: `
                    <form enctype="multipart/form-data" id="updateCompanyForm" action="{{ route('companies.update') }}" method="post" class="form">
                        @method('PATCH')
                        @csrf
                        <div class="mb-3 d-flex flex-column">
                            <label for="companyName" class="form-label text-start">Company Name</label>
                            <input name="name" value="${companyName}" id="companyName" type="text" class="form-control">
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <label for="companyEmail" class="form-label text-start">Email</label>
                            <input name="email" value="${companyEmail}" id="companyEmail" type="email"
                                class="form-control">
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <label for="companyLogo" class="form-label text-start">Logo</label>
                            <div class="d-flex flex-column">
                                <img width=50 height=50 src="{{ asset('storage/') }}/${companyLogoPath}" />
                                <div class="d-flex flex-column">
                                    <input accept="image/png, image/jpeg" aria-describedby="fileHelpId" name="logo" id="companyLogo"
                                        type="file" class="form-control">
                                    <div id="fileHelpId" class="form-text text-start">jpg, png*</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <label for="companyWebSite" class="form-label text-start">Website</label>
                            <input name="website" value="${companyWebSite}" id="companyWebSite" type="text"
                                class="form-control">
                        </div>
                        <input type="hidden" name="company_id" value="${companyId}"/>
                    </form>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const form = $('#updateCompanyForm');
                        form.submit();
                    }
                })

            });

            $('.show-alert-delete-box').click(function(event) {
                event.preventDefault();
                let form = $(this).closest("form");
                let companyName = $(this).siblings()[1].value;

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

            $('.show-alert-logo-modal').click(function() {
                let path = $(this).attr('path');
                let newPath = `{{ asset('storage/') }}/${path}`;
                Swal.fire({
                    imageUrl: newPath,
                    imageWidth: 100,
                    imageHeight: 100,
                })
            })
        })
    </script>
@endsection
