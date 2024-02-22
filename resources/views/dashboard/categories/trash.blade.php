@extends('layouts.dashboard')

@section('title', 'Trash Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item">Categories</li>
<li class="breadcrumb-item active">Trash Categories</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
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
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>
                <form action="{{ route('dashboard.categories.restore', [$category->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-dark">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.force-delete', [$category->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete Forever</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="7">No Categories Found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $categories->withQueryString()->links() }}

@endsection