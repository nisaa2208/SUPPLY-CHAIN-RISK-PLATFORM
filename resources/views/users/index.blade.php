@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-users text-primary mr-2"></i>
            User Management
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Manage Platform Access, System Roles & User Accounts
        </div>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-user-plus mr-1"></i> Add New User
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-9 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0" placeholder="Search by name or email address..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-filter mr-1"></i> Filter Users
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-users-cog text-primary mr-2"></i> Registered Platform Users
        </h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>User Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th width="140" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="font-weight-bold text-muted text-center">
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle mr-2 bg-primary text-white d-flex align-items-center justify-content-center rounded-circle font-weight-bold" style="width:36px; height:36px; font-size:14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <a href="{{ route('users.show', $user->id) }}" class="font-weight-bold text-dark hover-primary">
                                    {{ $user->name }}
                                </a>
                            </div>
                        </td>

                        <td>
                            <span class="text-muted"><i class="fas fa-envelope text-muted mr-1"></i>{{ $user->email }}</span>
                        </td>

                        <td>
                            @if($user->role == 'Admin')
                                <span class="badge badge-primary"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                            @else
                                <span class="badge badge-light border"><i class="fas fa-user mr-1"></i> User</span>
                            @endif
                        </td>

                        <td>
                            <span class="text-muted"><i class="fas fa-calendar-alt text-muted mr-1"></i>{{ $user->created_at->format('d M Y') }}</span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete {{ $user->name }}?')" title="Delete User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-users-slash fa-2x mb-2 d-block text-muted"></i>
                            No users found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>
@stop