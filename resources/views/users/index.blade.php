@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-users text-primary"></i>
        User Management
    </h1>

    <a href="{{ route('users.create') }}" class="btn btn-success">
        <i class="fas fa-user-plus"></i>
        Add User
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}

    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-lg-3">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ number_format($users->total()) }}</h3>
                <p>Total Users</p>
            </div>

            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-search"></i>
            Search User
        </h3>
    </div>

    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by name or email..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i>
            Registered Users
        </h3>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover table-striped">

            <thead class="bg-primary text-white">
                <tr>
                    <th width="70">No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($users as $user)

                <tr>

                    <td>
                        {{ $users->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <i class="fas fa-user text-primary"></i>
                        <strong>{{ $user->name }}</strong>
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>

                        @if($user->role == 'Admin')

                            <span class="badge badge-success">
                                Admin
                            </span>

                        @else

                            <span class="badge badge-secondary">
                                User
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td>

                        <a href="{{ route('users.show',$user->id) }}"
                           class="btn btn-info btn-sm"
                           title="Detail">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('users.edit',$user->id) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('users.destroy',$user->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                title="Delete"
                                onclick="return confirm('Are you sure you want to delete this user?')">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center text-muted">

                        <i class="fas fa-info-circle"></i>

                        No user data available.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer clearfix">
        {{ $users->links() }}
    </div>

</div>

@stop