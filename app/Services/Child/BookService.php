<?php

namespace App\Services\Child;

use App\Models\Book;
use App\Models\BookPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookService
{

    private function coverPath($image = null): string
    {
        return storage_path('books/'. $image);
    }

    private function soundPath($sound = null): string
    {
        return storage_path('sound/'. $sound);
    }

    public function all(): Collection
    {
        return Book::all();
    }

    public function cover($id): BinaryFileResponse
    {
        $item = $this->get($id);

        return response()->file($this->coverPath($item->cover));
    }

    public function get($id): Builder|array|Collection|Model
    {
        return Book::with('pages')->findOrFail($id);
    }

    public function getPage($id): Builder|array|Collection|Model
    {
        return BookPage::findOrFail($id);
    }

    public function sound($id): BinaryFileResponse
    {
        $item = $this->getPage($id);

        return response()->file($this->soundPath($item->sound));
    }

    public function page($id): BinaryFileResponse
    {
        $item = $this->getPage($id);

        return response()->file($this->coverPath($item->image), [
            'Content-Type' => mime_content_type($this->coverPath($item->image)),
            'Content-Length' => filesize($this->coverPath($item->image))
        ]);
    }

}
