@extends('layouts.admin')
@section('title', 'Products')
@section('content')
    <!-- Success/Error Message Container -->
    <div id="message-container"></div>

    <div class="card">
        <div class="card-header">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Stock Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var successMessage = localStorage.getItem('success_message');
            if (successMessage) {
                $('#message-container').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${successMessage}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
                localStorage.removeItem('success_message');

                setTimeout(function() {
                    $('.alert-success').alert('close');
                }, 3000);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#products-table').DataTable({
                autoWidth: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'price' },
                    { data: 'stock_quantity' },
                    { data: 'stock_status' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                paging: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                searching: true,
                order: [[0, 'asc']],
                language: {
                    searchPlaceholder: "Search e.g. product, action, note",
                    search: '<button class="btn py-0"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.5 17.5L12.5001 12.5M14.1667 8.33333C14.1667 11.555 11.555 14.1667 8.33333 14.1667C5.11167 14.1667 2.5 11.555 2.5 8.33333C2.5 5.11167 5.11167 2.5 8.33333 2.5C11.555 2.5 14.1667 5.11167 14.1667 8.33333Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>',
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" },
                    processing: "<span class='spinner-border spinner-border-sm'></span>",
                }
            });

            if (window.location.href.includes("products.index")) {
                let successMessage = "{{ session('success') }}";
                if (successMessage) {
                    $('#message-container').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${successMessage}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                    setTimeout(function() {
                        $('.alert-success').alert('close');
                    }, 3000);
                }
            }

            $(document).on('click', '.delete-product', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                if (confirm("Are you sure you want to delete this product?")) {
                    $.ajax({
                        url: `/products/${id}`,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.message) {
                                table.ajax.reload();
                                $('#message-container').html(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        ${response.message}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                `);
                                setTimeout(function() {
                                    $('.alert-success').alert('close');
                                }, 3000);
                            }
                        },
                        error: function(xhr) {
                            $('#message-container').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    An error occurred. Please try again.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            `);
                        }
                    });
                }
            });
        });
    </script>
@endsection
