@extends('layouts.admin')
@section('title', 'Add Category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Add Category</h5>
        </div>
        <div class="card-body">
            <form id="create-category-form">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
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

            $('#create-category-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('categories.store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            localStorage.setItem('success_message', 'Category added successfully!');
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
