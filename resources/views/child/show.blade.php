
<!DOCTYPE html>
<html lang="en" class="no-js demo-4">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Detay</title>
    <link rel="stylesheet" href="{{ asset('plugins/bookblock/plugin.min.css') }}">
</head>
<body>
<div class="container">
    <div class="bb-custom-wrapper">
        <div id="bb-bookblock" class="bb-bookblock">
            @foreach($book->pages as $page)
                <div class="bb-item">
                    <div class="bb-custom-side">
                        <img data-src="{{ route('child.books.page', $page->id) }}" class="hw-100 lazy" />
                    </div>
                </div>
            @endforeach
        </div>
        <nav>
            <a id="bb-nav-first" href="#" class="bb-custom-icon bb-custom-icon-first">First page</a>
            <a id="bb-nav-prev" href="#" class="bb-custom-icon bb-custom-icon-arrow-left">Previous</a>
            <a id="bb-nav-next" href="#" class="bb-custom-icon bb-custom-icon-arrow-right">Next</a>
            <a id="bb-nav-last" href="#" class="bb-custom-icon bb-custom-icon-last">Last page</a>
            <a id="bb-close" href="{{ route('child.books') }}" class="bb-custom-icon bb-custom-icon-red bb-custom-icon-close">Close</a>
        </nav>
    </div>
</div>
<script src="{{ asset('plugins/modernizr/plugin.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/plugin.min.js') }}"></script>
<script src="{{ asset('plugins/howler/plugin.min.js') }}"></script>
<script src="{{ asset('plugins/bookblock/plugin.min.js') }}"></script>
<script src="{{ asset('plugins/lazy/plugin.min.js') }}"></script>
<script>
    var soundFiles = {
        @foreach($book->pages as $page)
            @if($page->sound !== null)
                {{ $loop->iteration }} : "{{ route('child.books.sound', $page->id) }}",
            @endif
        @endforeach
    };
    $(function() {
        $('.lazy').Lazy();
    });
</script>
</body>
</html>
