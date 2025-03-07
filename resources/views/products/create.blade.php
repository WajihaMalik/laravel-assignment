@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Add Product</h5>
        </div>
        <div class="card-body">
            <form id="create-product-form" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Fields -->
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" required min="0" step="0.01">
                </div>

                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" required min="0">
                </div>

                <div class="form-group">
                    <label for="stock_status">Stock Status</label>
                    <select name="stock_status" id="stock_status" class="form-control" required>
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>

                <!-- Categories -->
                <div class="form-group">
                    <label for="categories" class="form-label">Categories</label>
                    <select class="form-control selectpicker" id="categories" name="categories[]" multiple required data-live-search="true">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="images">Product Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#categories').selectpicker();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#create-product-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('products.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            localStorage.setItem('success_message', 'Product added successfully!');
                            window.location.href = "{{ route('products.index') }}";
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
@endsection
