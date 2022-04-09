@extends('child.layout')

@section('content')
    <style>
        .carousel-item img {
            max-height: 100vh;
            object-fit: cover;
        }
    </style>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($book->pages as $page)
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://image.ibb.co/kvhXGH/jetty_1373173_1920.jpg">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        $('.carousel').carousel({
            wrap: false
        });
        $('.carousel').on('slide.bs.carousel', function onSlide (ev) {
            var id = ev.relatedTarget.id;
            alert(ev.relatedTarget);
            console.log(ev.relatedTarget);
        });
    </script>
@endsection
