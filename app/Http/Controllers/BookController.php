<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\BookService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{

    protected BookService $book;

    public function __construct(BookService $book)
    {
        $this->book = $book;
    }

    public function index(): Factory|View|Application
    {
        return view('books.index', [
            'books' => $this->book->all(),
        ]);
    }

    public function add(): Factory|View|Application
    {
        return view('books.add');
    }

    public function save(SaveBookRequest $request): RedirectResponse
    {
        $this->book->saveItem($request);

        return redirect()->route('books')->with([
            'message' => 'Kitap eklendi.',
        ]);
    }

    public function edit($id): Factory|View|Application
    {
        return view('books.edit', [
            'edit' => $this->book->get($id),
        ]);
    }

    public function update($id, UpdateBookRequest $request): RedirectResponse
    {
        $this->book->saveItem($request);

        return redirect()->route('books')->with([
            'message' => 'Kitap düzenlendi.',
        ]);
    }

    public function delete($id): JsonResponse
    {
        return $this->book->delete($id);
    }
}
