@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item">Categories</li>
<li class="breadcrumb-item active">$category->name</li>
@endsection

@section('content')


<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php
            $products = $category->products()->with(['store', 'category'])->paginate(5);
        @endphp
        @forelse($products as $product)
        <tr>
            <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->created_at }}</td>
        </tr>
        @empty
            <tr>
                <td colspan="5">No Categories Found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}

@endsection