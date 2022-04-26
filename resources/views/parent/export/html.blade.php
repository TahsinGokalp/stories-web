
<!DOCTYPE html>
<html lang="en" class="no-js demo-4">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Detay</title>
    <link rel="stylesheet" href="assets/books.css">
    <link rel="stylesheet" href="assets/bookblock.min.css">
    <style>
        @font-face {
            font-family: 'arrows';
            src:url('fonts/arrows.eot');
            src:url('fonts/arrows.eot?#iefix') format('embedded-opentype'),
            url('fonts/arrows.woff') format('woff'),
            url('fonts/arrows.ttf') format('truetype'),
            url('fonts/arrows.svg#arrows') format('svg');
        }
    </style>
</head>
<body>
<div class="full-height">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <svg class="start" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="height: 200px; width: 200px;"
                 viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><g><g id="XMLID_6_"><g><g><path fill="#316CFF" d="M32,0c17.7,0,32,14.3,32,32S49.7,64,32,64S0,49.7,0,32S14.3,0,32,0z"/></g></g></g><g><g><path fill="#FFFFFF" d="M25,42.9V21.1c0-1.7,2.1-2.7,3.5-1.7l13.7,10.9c1,0.8,1.1,2.5,0.1,3.3L28.4,44.6
				C27.1,45.6,25,44.6,25,42.9z"/></g></g></g></svg>
        </div>
    </div>
</div>
<div class="container-book blur">
    <div class="bb-custom-wrapper">
        <div id="bb-bookblock" class="bb-bookblock">
            @foreach($book->pages as $page)
                <div class="bb-item">
                    <div class="bb-custom-side">
                        <img alt="Page" src="images/{{ $page->image }}" class="hw-100" id="book-page-{{ $page->id }}" />
                    </div>
                </div>
            @endforeach
        </div>
        <nav>
            <a id="bb-nav-first" href="#" class="bb-custom-icon bb-custom-icon-first">First page</a>
            <a id="bb-nav-prev" href="#" class="bb-custom-icon bb-custom-icon-arrow-left">Previous</a>
            <a id="bb-nav-next" href="#" class="bb-custom-icon bb-custom-icon-arrow-right">Next</a>
            <a id="bb-nav-last" href="#" class="bb-custom-icon bb-custom-icon-last">Last page</a>
        </nav>
    </div>
</div>
<script src="assets/modernizr.min.js"></script>
<script src="assets/jquery.min.js"></script>
<script src="assets/howler.min.js"></script>
<script src="assets/bookblock.min.js"></script>
<script>
    var soundFiles = {
        @foreach($book->pages as $page)
            @if($page->sound !== null)
            {{ $loop->iteration }} : "sound/{{ $page->sound }}",
        @endif
        @endforeach
    };
    $(function() {
        $('.blur').css("filter","blur(10px)");
        loadPage(0);
    });
    $('.start').click(function (){
        playSound(1);
        $('.blur').css("filter","");
        $('.full-height').hide();
    });
</script>
</body>
</html>
