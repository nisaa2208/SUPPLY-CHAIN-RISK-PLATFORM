@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-user-plus text-primary"></i>
        Add New User
    </h1>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Validation Error!</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            User Information
        </h3>
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save User
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

@stop