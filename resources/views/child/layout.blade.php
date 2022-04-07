<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .book::after,
        .book::before, .book img, .book {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        ul {
            display: table-cell;
            vertical-align: middle;
        }

        .list-inline {
            padding-left: 0;
            list-style: none;
        }
        .list-inline > li {
            display: inline-block;
            margin-left: 2em;
        }
        .list-inline > li:first-child {
            margin-left: 0;
        }

        .book {
            cursor: pointer;
            display: block;
            width: 250px;
            height: 320px;
            position: relative;
            background: white;
            z-index: 1;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1), 0 9px 20px 0 rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: box-shadow 0.3s linear;
        }

        .book img {
            width: inherit;
            height: inherit;
            transform-origin: 0 50%;
            transform: rotateY(0);
            transition: all 0.45s ease;
        }

        .book:hover {
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.25), 0 9px 20px 0 rgba(0, 0, 0, 0.45);
        }
        .book:hover img {
            transform: rotateY(-25deg);
            box-shadow: 1px 1px 5px 5px rgba(0, 0, 0, 0.2);
        }

        .book::after,
        .book::before {
            content: "";
            display: block;
            width: inherit;
            height: inherit;
            position: absolute;
            z-index: -1;
            top: 0;
            background: white;
            border: 1px solid #d9d9d9;
        }

        .book::before {
            left: -3px;
        }

        .book::after {
            left: -6px;
        }

    </style>
    <style>
        .carousel-item img {
            max-height: 100vh;
            object-fit: cover;
        }
    </style>
    <title>Hello, world!</title>
</head>
<body class="bg-light">
<main>
    @yield('content')
</main>
<script src="{{ asset('plugins/jquery/plugin.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
