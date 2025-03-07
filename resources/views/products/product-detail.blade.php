@extends('layouts.admin')
@section('title', $product->name)
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('storage/'.$product->images->first()->image_path) }}" alt="Product Image">
                </div>
                <div class="col-md-6">
                    <h5>{{ $product->description }}</h5>
                    <p><strong>Price: </strong>${{ $product->price }}</p>
                    <p><strong>Stock Quantity: </strong>{{ $product->stock_quantity }}</p>
                    <p><strong>Status: </strong>{{ $product->stock_status }}</p>

                    <form action="{{ route('product.feedback', $product->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Leave a Comment:</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="rating">Your Rating:</label>
                            <div id="stars" class="star-rating">
                                <span class="fa fa-star" data-index="1"></span>
                                <span class="fa fa-star" data-index="2"></span>
                                <span class="fa fa-star" data-index="3"></span>
                                <span class="fa fa-star" data-index="4"></span>
                                <span class="fa fa-star" data-index="5"></span>
                            </div>
                            <input type="hidden" name="rating" id="rating" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                    @if($product->feedback->count() > 0)
                        <div class="mt-4">
                            <h4>Feedback</h4>
                            <ul class="list-group">
                                @foreach($product->feedback as $feedback)
                                    <li class="list-group-item">
                                        <strong>{{ $feedback->user->name }} (Rating: {{ $feedback->rating }} stars)</strong>
                                        <p>{{ $feedback->comment }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        const stars = $('#stars .fa-star');
        const ratingInput = $('#rating');

        stars.hover(function () {
            const index = $(this).data('index');
            highlightStars(index);
        }, function () {
            const index = ratingInput.val();
            highlightStars(index);
        });

        stars.click(function () {
            const index = $(this).data('index');
            ratingInput.val(index);
            highlightStars(index);
        });

        function highlightStars(index) {
            stars.each(function () {
                const starIndex = $(this).data('index');
                if (starIndex <= index) {
                    $(this).addClass('text-warning');
                } else {
                    $(this).removeClass('text-warning');
                }
            });
        }
    });
</script>
@endsection
