@extends('layouts.admin')
@section('title', 'Products in ' . $category->name)
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Products in {{ $category->name }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="Product image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-block">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
