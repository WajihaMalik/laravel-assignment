@extends('layouts.admin')
@section('title', 'Edit Category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Edit Category</h5>
        </div>
        <div class="card-body">
            <!-- Form should not define the action, use data-id to pass the ID dynamically -->
            <form id="edit-category-form" method="POST" data-id="{{ $category->id }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('#edit-category-form').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/categories/' + $('#edit-category-form').data('id'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        localStorage.setItem('success_message', response.message);
                        window.location.href = "{{ route('categories.index') }}";
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
