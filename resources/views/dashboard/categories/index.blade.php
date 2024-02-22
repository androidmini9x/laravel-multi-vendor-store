@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-primary">Trash</a>
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
            <th>Parent</th>
            <th>Products #</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->products_number }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href="{{ route('dashboard.categories.edit', [$category->id]) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.destroy', [$category->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="8">No Categories Found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $categories->withQueryString()->links() }}

@endsection