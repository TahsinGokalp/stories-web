<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBookPageRequest;
use App\Http\Requests\UpdateBookPageRequest;
use App\Services\BookPageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookPageController extends Controller
{

    protected BookPageService $book;

    public function __construct(BookPageService $book)
    {
        $this->book = $book;
    }

    public function index($bookId): Factory|View|Application
    {
        return view('books.pages.index', [
            'bookId' => $bookId,
            'pages' => $this->book->all($bookId),
        ]);
    }

    public function add($bookId): Factory|View|Application
    {
        return view('books.pages.add', [
            'bookId' => $bookId,
        ]);
    }

    public function save($bookId, SaveBookPageRequest $request): RedirectResponse
    {
        $this->book->saveItem($bookId, $request);

        return redirect()->route('books.page', $bookId)->with([
            'message' => 'Sayfa eklendi.',
        ]);
    }

    public function edit($bookId, $id): Factory|View|Application
    {
        return view('books.pages.edit', [
            'bookId' => $bookId,
            'edit' => $this->book->get($id),
        ]);
    }

    public function update($bookId, $id, UpdateBookPageRequest $request): RedirectResponse
    {
        $request['id'] = $id;
        $this->book->saveItem($bookId, $request);

        return redirect()->route('books.page', $bookId)->with([
            'message' => 'Sayfa düzenlendi.',
        ]);
    }

    public function delete($bookId, $id): JsonResponse
    {
        return $this->book->delete($id);
    }

    public function serve($bookId, $id): BinaryFileResponse
    {
        return $this->book->serve($id);
    }
}
