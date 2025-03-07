@extends('layouts.admin')
@section('title', 'Category List')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Category List</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($categories as $category)
                    <!-- Add 'col-md-3' for responsive columns and 'mb-4' for vertical spacing -->
                    <div class="col-md-3 mb-4">
                        <div class="card" style="width: 100%;">  <!-- Use 'width: 100%' to ensure card fills the column -->
                            <!-- Image for each category -->
                            <img class="card-img-top" src="{{ asset('images/category-default.png') }}" alt="{{ $category->name }} Image">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <h5 class="card-title text-center">{{ $category->name }}</h5>
                                <p class="card-text"></p>
                                <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">View Products</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
