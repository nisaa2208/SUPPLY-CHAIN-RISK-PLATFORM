@extends('adminlte::page')

@section('title','Suppliers')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Suppliers</h1>

    <a href="{{ route('suppliers.create') }}"
       class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Add Supplier

    </a>

</div>

@stop

@section('content')

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Supplier List

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>

            <tr>

                <th>No</th>

                <th>Country</th>

                <th>Supplier</th>

                <th>Email</th>

                <th>Phone</th>

                <th>Status</th>

                <th>Risk</th>

                <th width="180">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($suppliers as $supplier)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $supplier->country->name }}</td>

                <td>{{ $supplier->name }}</td>

                <td>{{ $supplier->email }}</td>

                <td>{{ $supplier->phone }}</td>

                <td>

                    @if($supplier->supply_status=="Active")

                        <span class="badge badge-success">

                            Active

                        </span>

                    @else

                        <span class="badge badge-danger">

                            Inactive

                        </span>

                    @endif

                </td>

                <td>

                    {{ $supplier->risk_score }}

                </td>

                <td>

                    <a href="{{ route('suppliers.edit',$supplier) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('suppliers.destroy',$supplier) }}"
                          method="POST"
                          style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete supplier?')">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center">

                    No Supplier Data

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $suppliers->links() }}

    </div>

</div>

@stop