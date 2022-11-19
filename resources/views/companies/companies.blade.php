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
                            <button class="btn btn-primary">
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
                                                    <i class="fa-light fa-trash"></i>
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
