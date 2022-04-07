@extends('child.layout')

@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="https://image.ibb.co/kvhXGH/jetty_1373173_1920.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Title</h5>
                    <p>Text goes here</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://image.ibb.co/kvhXGH/jetty_1373173_1920.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Title</h5>
                    <p>Text goes here</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://image.ibb.co/kvhXGH/jetty_1373173_1920.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Title</h5>
                    <p>Text goes here</p>
                </div>
            </div>
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
