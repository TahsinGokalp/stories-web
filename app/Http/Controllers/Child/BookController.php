<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Services\Child\BookService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookController extends Controller
{

    protected BookService $book;

    public function __construct(BookService $book)
    {
        $this->book = $book;
    }

    public function index(): Factory|View|Application
    {
        return view('child.books', [
            'books' => $this->book->all(),
        ]);
    }

    public function cover($id): BinaryFileResponse
    {
        return $this->book->cover($id);
    }

    public function show($id): Factory|View|Application
    {
        return view('child.show', [
            'book' => $this->book->get($id),
        ]);
    }
}
