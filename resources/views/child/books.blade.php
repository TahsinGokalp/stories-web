@extends('child.layout')

@section('content')
    <div class="container">
        <div class="row">
            <ul class='list-inline'>
                @foreach($books as $book)
                    <li class='book'>
                        <img src="{{ route('child.books.cover', $book->id) }}" onclick="window.location.href='{{ route('child.books.show', $book->id) }}'" alt="{{ $book->title }}" />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
