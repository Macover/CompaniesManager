@extends('layouts.app')

@section('title', 'Admin - Companies')

@section('heading')
    <h2 class="m-0 font-semibold text-xl text-gray-800 leading-tight">
        Companies
    </h2>
@endsection

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
                                        <a href="#">
                                            Open logo...
                                        </a>
                                    </td>
                                    <td>{{ $company->website }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 d-flex gap-2">
                                                <button class="btn btn-warning flex-1">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline"
                                                    action="{{ route('companies.destroy', ['company' => $company->id]) }}">
                                                    @method('DELETE')
                                                    <input type="hidden" class="companyName" value="{{ $company->name }}">
                                                    <button type="submit"
                                                        class="btn btn-outline-danger flex-1 show-alert-delete-box">
                                                        X
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
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

            @if (session()->has('error'))
                Swal.fire(
                    'Error!',
                    `{{ session()->get('error') }}`,
                    'error'
                )
            @endif

            $('#example').DataTable();

            $('#newCompanyBtn').click(async function(e) {

                const {
                    value: prePostCompany
                } = await Swal.fire({
                    title: 'New company',
                    html: `
                            <div class="form">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="companyName" class="form-label text-start">Company Name</label>
                                    <input placeholder="Ex. Microsoft" id="companyName" type="text"
                                        class="form-control">
                                </div>
                                <div class="mb-3 d-flex flex-column">
                                    <label for="companyEmail" class="form-label text-start">Email</label>
                                    <input placeholder="Ex. microsoft@hotmail.com" id="companyEmail" type="email"
                                        class="form-control">
                                </div>
                                <div class="mb-3 d-flex flex-column">
                                    <label for="companyLogo" class="form-label text-start">Logo</label>
                                    <input placeholder="Ex. Path/safds/sdf" id="companyLogo" type="text"
                                        class="form-control">
                                </div>
                                <div class="mb-3 d-flex flex-column">
                                    <label for="companyWebSite" class="form-label text-start">Website</label>
                                    <input placeholder="Ex. microsoft.com" id="companyWebSite" type="text"
                                        class="form-control">
                                </div>
                            </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {

                        const companyName = $('#companyName').val();
                        const companyEmail = $('#companyEmail').val();
                        const companyLogo = $('#companyLogo').val();
                        const companyWebSite = $('#companyWebSite').val();

                        const data = {
                            "name": companyName,
                            "email": companyEmail,
                            "logo": companyLogo,
                            "website": companyWebSite,
                        }

                        const requestOptions = {
                            method: 'POST', // *GET, POST, PUT, DELETE, etc.
                            mode: 'cors', // no-cors, *cors, same-origin
                            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                            credentials: 'same-origin', // include, *same-origin, omit
                            headers: {
                                'Content-Type': 'application/json'
                                // 'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            redirect: 'follow', // manual, *follow, error
                            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                            body: JSON.stringify(data)
                        }

                        console.log("preData", data);

                        return fetch("{{ route('companies.store') }}", requestOptions)
                            .then(response => console.log(response));
                    }
                })

                console.log("promise", prePostCompany)

                // .then((result) => {
                //     if (result.isConfirmed) {
                //         // let form = $('#formAddCompany');
                //         // console.log("form", form)
                //         // form.submit();
                //     }
                // })


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

        });
    </script>
@endsection
