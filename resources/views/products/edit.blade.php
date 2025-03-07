@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Edit Product</h5>
        </div>
        <div class="card-body">
            <!-- Form for editing product -->
            <form id="edit-product-form" method="POST" enctype="multipart/form-data" data-id="{{ $product->id }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0" step="0.01">
                </div>

                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0">
                </div>

                <div class="form-group">
                    <label for="stock_status">Stock Status</label>
                    <select name="stock_status" id="stock_status" class="form-control" required>
                        <option value="in_stock" {{ $product->stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ $product->stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <!-- Categories -->
                <div class="form-group">
                    <label for="categories" class="form-label">Categories</label>
                    <select class="form-control selectpicker" id="categories" name="categories[]" multiple required data-live-search="true">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                @if(in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())))
                                    selected
                                @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Display Existing Images -->
                <div class="form-group">
                    <label for="existing_images">Existing Images</label>
                    <div id="existing_images">
                        @foreach ($product->images as $image)
                            <div class="image-preview">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- New Images Upload -->
                <div class="form-group">
                    <label for="images">Product Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
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

            $('#edit-product-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: '/products/' + $('#edit-product-form').data('id'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            localStorage.setItem('success_message', 'Product updated successfully!');
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

            // Remove image functionality
            $('#existing_images').on('click', '.remove-image', function() {
                var imageId = $(this).data('id');
                
                if (confirm('Are you sure you want to remove this image?')) {
                    $.ajax({
                        url: '/products/remove-image/' + imageId,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $(this).closest('.image-preview').remove();
                                alert('Image removed successfully.');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection