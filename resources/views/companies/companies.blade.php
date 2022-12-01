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
                                                <button class="btn btn-danger flex-1">
                                                    X
                                                    Delete
                                                </button>
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
            $('#example').DataTable();

            $('#newCompanyBtn').click(function(e) {

                const url = `{{ route('companies.store') }}`;

                Swal.fire({
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
                    </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {

                        const companyName = $('#companyName').val();
                        const companyEmail = $('#companyEmail').val();
                        const companyLogo = $('#companyLogo').val();
                        const companyWebSite = $('#companyWebSite').val();

                        const data = {
                            "name": companyName,
                            "email": companyEmail,
                            "logo": companyLogo,
                            "website": companyWebSite,
                        };

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: (resultRequest) => {
                                swalWithBootstrapButtons.fire(
                                    'Success!',
                                    `The company ${data.name} was added`,
                                    'success'
                                )
                            },
                            // error: (XMLHttpRequest, textStatus, errorThrown) => {
                            //     console.log(XMLHttpRequest)
                            //     const errors = XMLHttpRequest.responseJSON.errors;

                            //     console.log("errors", errors)

                            //     for (const i in errors) {
                            //         if (Object.hasOwnProperty.call(errors, i)) {
                            //             const element = errors[i];
                            //             element.forEach(error => {
                            //                 Swal.showValidationMessage(
                            //                     `Request failed: ${error}`
                            //                 )
                            //             })
                            //         }
                            //     }
                            //     // Swal.showValidationMessage(
                            //     //     `Request failed: ${XMLHttpRequest.responseJSON}`
                            //     // )
                            // }
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("result", result)
                        console.log("value", result.value)
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            });
        });
    </script>
@endsection
