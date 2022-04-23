<?php

namespace App\Services\Parent;

use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JsonException;
use function redirect;
use function response;
use function storage_path;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ExportService
{
    public function books(): Collection
    {
        return Book::all();
    }

    public function get($id): Book
    {
        return Book::where('id', $id)->with('pages')->firstOrFail();
    }

    public function download($request): BinaryFileResponse
    {
        $book = $this->get($request['book']);
        $directory = $this->createDirectory($book);
        if (! $this->createBookJson($book, $directory)) {
            $this->deleteDirectory($directory);

            redirect()->back()->withErrors([
                'Kitap bilgi dosyası oluşturulamadı.',
            ])->withInput()->throwResponse();
        }
        if (! $this->copyFiles($book, $directory)) {
            $this->deleteDirectory($directory);

            redirect()->back()->withErrors([
                'Resim ve ses dosyaları kopyalanamadı.',
            ])->withInput()->throwResponse();
        }
        $zipFile = $this->createZip($book, $directory);
        if ($zipFile === null) {
            $this->deleteDirectory($directory);

            redirect()->back()->withErrors([
                'Zip dosyası oluşturulamadı.',
            ])->withInput()->throwResponse();
        }
        $this->deleteDirectory($directory);

        return response()
            ->download(storage_path('export/'.$zipFile))
            ->deleteFileAfterSend();
    }

    private function createDirectory($book): string
    {
        $directory = storage_path('export/'.Str::slug($book->title).'-'.$book->id);
        if (File::exists($directory)) {
            $this->deleteDirectory($directory);
        }
        File::makeDirectory($directory);
        File::makeDirectory($directory.'/images');
        File::makeDirectory($directory.'/sound');

        return $directory;
    }

    private function deleteDirectory($directory): void
    {
        File::deleteDirectory($directory);
    }

    private function createBookJson($book, $directory): bool
    {
        $content = [
            'book' => [
                'title' => $book->title,
                'cover' => $book->cover,
                'audio_book' => $book->audio_book,
            ],
            'pages' => [

            ],
        ];
        foreach ($book->pages as $page) {
            $content['pages'][] = [
                'page_order' => $page->page_order,
                'image' => $page->image,
                'sound' => $page->sound,
            ];
        }
        try {
            $json = json_encode($content, JSON_THROW_ON_ERROR);
            File::put($directory.'/book.json', $json);
        } catch (JsonException) {
            return false;
        }

        return true;
    }

    private function copyFiles($book, $directory): bool
    {
        try {
            if (File::exists(storage_path('books/'.$book->cover)) && ! File::copy(storage_path('books/'.$book->cover), $directory.'/images/'.$book->cover)) {
                return false;
            }
            foreach ($book->pages as $page) {
                if (File::exists(storage_path('books/'.$page->image)) && ! File::copy(storage_path('books/'.$page->image), $directory.'/images/'.$page->image)) {
                    return false;
                }
                if ($page->sound !== null && File::exists(storage_path('sound/'.$page->sound)) && ! File::copy(storage_path('sound/'.$page->sound), $directory.'/sound/'.$page->sound)) {
                    return false;
                }
            }
        } catch (Exception) {
            return false;
        }

        return true;
    }

    private function createZip($book, $directory): ?string
    {
        $zip = new ZipArchive();
        $filename = Str::slug($book->title).'-'.$book->id.'.zip';
        if ($zip->open(storage_path('export/'.$filename), ZipArchive::CREATE) === true) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $zip->addFile($file->getPathname(), $file->getRelativePathname());
            }

            $zip->close();

            return $filename;
        }

        return null;
    }
}
