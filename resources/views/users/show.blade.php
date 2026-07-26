@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-user text-info"></i>
        User Details
    </h1>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

<div class="card card-info shadow">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-circle"></i>
            {{ $user->name }}
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">Full Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td>
                            @if($user->role == 'Admin')
                                <span class="badge badge-success">
                                    <i class="fas fa-user-shield"></i>
                                    Admin
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-user"></i>
                                    User
                                </span>
                            @endif
                        </td>
                    </tr>

                </table>

            </div>

            <div class="col-md-6">

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">Account Status</th>
                        <td>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i>
                                Active
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="card-footer text-right">

        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit User
        </a>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>

    </div>

</div>

@stop