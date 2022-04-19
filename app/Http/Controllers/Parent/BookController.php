<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\Parent\BookService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use function redirect;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function view;

class BookController extends Controller
{
    protected BookService $book;

    public function __construct(BookService $book)
    {
        $this->book = $book;
    }

    public function index(): Factory|View|Application
    {
        return view('parent.books.index');
    }

    public function data(): ?JsonResponse
    {
        return $this->book->data();
    }

    public function add(): Factory|View|Application
    {
        return view('parent.books.add');
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
        return view('parent.books.edit', [
            'edit' => $this->book->get($id),
        ]);
    }

    public function update($id, UpdateBookRequest $request): RedirectResponse
    {
        $request['id'] = $id;
        $this->book->saveItem($request);

        return redirect()->route('books')->with([
            'message' => 'Kitap düzenlendi.',
        ]);
    }

    public function delete($id): JsonResponse
    {
        return $this->book->delete($id);
    }

    public function serve($id): BinaryFileResponse
    {
        return $this->book->serve($id);
    }
}
