@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
</div>

<x-alert type="success" />

<form action="{{ URL::current() }}" method="get" class="form-group d-flex justify-content-between">
    <x-form.input name="term" placeholder="Search for ..." />
    <select name="status" class="form-control">
        <option value="">All</option>
        <option value="active">Active</option>
        <option value="archive">Archived</option>
    </select>
    <button type="submit" class="btn btn-dark">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{ route('dashboard.products.edit', [$product->id]) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.products.destroy', [$product->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="8">No Products Found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->withQueryString()->links() }}

@endsection