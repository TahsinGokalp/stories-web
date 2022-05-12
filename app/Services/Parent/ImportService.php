<?php

namespace App\Services\Parent;

use App\Models\Book;
use App\Models\BookPage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JsonException;
use function storage_path;
use ZipArchive;

class ImportService
{
    public function start($request): void
    {
        $filename = $this->uploadCover($request);
        $directory = $this->createDirectory();
        if (! $this->unzip($directory, $filename)) {
            $this->deleteDirectory($directory);
            $this->deleteZip($filename);

            redirect()->back()->withErrors([
                'Zip dosyası açılamadı.',
            ])->withInput()->throwResponse();
        }
        $book = $this->createBook($directory);
        if ($book === null) {
            $this->deleteDirectory($directory);
            $this->deleteZip($filename);

            redirect()->back()->withErrors([
                'Kitap oluşturulamadı.',
            ])->withInput()->throwResponse();
        }
        $this->moveFiles($directory);
        $this->deleteDirectory($directory);
        $this->deleteZip($filename);
    }

    private function importPath($image = null): string
    {
        return storage_path('import/'.$image);
    }

    private function createDirectory(): string
    {
        $directory = storage_path('import/'.Str::random(20));
        if (File::exists($directory)) {
            $this->deleteDirectory($directory);
        }
        File::makeDirectory($directory);

        return $directory;
    }

    private function deleteDirectory($directory): void
    {
        File::deleteDirectory($directory);
    }

    private function deleteZip($file): void
    {
        File::delete($this->importPath($file));
    }

    private function uploadCover($request): ?string
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $destinationPath = $this->importPath();
            $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);

            return $filename;
        }

        return null;
    }

    private function unzip($directory, $filename): bool
    {
        $zip = new ZipArchive;
        if ($zip->open(storage_path('import/'.$filename)) === true) {
            $zip->extractTo($directory);
            $zip->close();

            return true;
        }

        return false;
    }

    private function createBook($directory): ?Book
    {
        try {
            $bookJson = File::get($directory.'/book.json');
            $json = json_decode($bookJson, false, 512, JSON_THROW_ON_ERROR);
            $book = new Book();
            $book->title = $json->book->title;
            $book->cover = $json->book->cover;
            $book->audio_book = $json->book->audio_book;
            $book->save();

            foreach ($json->pages as $page) {
                $item = new BookPage();
                $item->book_id = $book->id;
                $item->page_order = $page->page_order;
                $item->image = $page->image;
                $item->sound = $page->sound;
                $item->save();
            }

            return $book;
        } catch (JsonException) {
            return null;
        }
    }

    private function moveFiles($directory): void
    {
        File::copyDirectory($directory.'/images', storage_path('books'), true);
        File::copyDirectory($directory.'/sound', storage_path('sound'), true);
    }
}
