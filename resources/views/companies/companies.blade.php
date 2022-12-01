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

            @if (session()->has('successDeleted'))
                Swal.fire(
                    'Deleted!',
                    `{{ session()->get('successDeleted') }}`,
                    'success'
                )
            @endif

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

                        return $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: (resultRequest) => {
                                console.log("resultRequest", resultRequest)
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
                    console.log("generalResult", result)
                    console.log(result.value.id ?? false)
                    if (result.value.id ?? false) {
                        Swal.fire(
                            'Success!',
                            `The company ${result.value.name} was added`,
                            'success'
                        )
                        console.log("result", result)
                    } else {
                        Swal.fire('Error', '', 'info')
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

        });
    </script>
@endsection
