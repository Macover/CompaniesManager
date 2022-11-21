@extends('layouts.app')

@section('title', 'Admin - Companies')

@section('heading')
    <h2 class="m-0 font-semibold text-xl text-gray-800 leading-tight">
        Companies
    </h2>
@endsection

@section('content')

    <div class="row p-0 m-0">
        <div class="col-12 m-0 p-0">
            <div class="table-responsive-sm table-responsive-md">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                        <div class="row p-0 mx-0 my-4 w-100 d-flex justify-content-end">
                            <button class="btn btn-primary w-25">
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
            console.log("first")
            $('#example').DataTable();
        });
    </script>
@endsection
