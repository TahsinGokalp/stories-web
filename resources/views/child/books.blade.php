<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
    <title>Kitaplar</title>
</head>
<body class="bg-pink">
<main>
    <div class="container mt-3">
        <div class="row">
            @foreach($books as $book)
                <div class="col-lg-2 col-md-3 col-sm-4 mt-3">
                    <div class='book'>
                        <img src="{{ route('child.books.cover', $book->id) }}" onclick="window.location.href='{{ route('child.books.show', $book->id) }}'" alt="{{ $book->title }}" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
</body>
</html>
