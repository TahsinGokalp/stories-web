<?php

namespace App\Services\Parent;

use App\Models\Book;
use App\Models\BookPage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDOException;
use Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

use function __;
use function redirect;
use function response;
use function storage_path;

class BookService
{
    private function coverPath($image = null): string
    {
        return storage_path('books/'.$image);
    }

    public function data(): ?JsonResponse
    {
        $model = Book::query();
        try {
            return DataTables::of($model)->addColumn('image_html', function ($item) {
                return '<img src="'.route('books.serve', $item->id).'" class="max-w-full h-auto rounded-lg text-center" style="height:200px;">';
            })->addColumn('total_pages', function ($item) {
                return $item->total_pages;
            })->addColumn('audio_book_text', function ($item) {
                return $item->audio_book_text;
            })->addColumn('actions', function ($item) {
                return '<a href="'.route('books.page', $item->id).'" class="my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">Sayfalar</a>'.
                       '<a href="'.route('child.books.show', $item->id).'" class="my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700" target="_blank">Görüntüle</a>'.
                       '<a href="'.route('books.edit', $item->id).'" class="my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">Düzenle</a>'.
                       '<a href="'.route('books.delete', $item->id).'" class="delete-btn my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">Sil</a>';
            })->toJson();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([]);
        }
    }

    public function get($id): Book
    {
        return Book::findOrFail($id);
    }

    public function uploadCover(Book $book, $request): ?string
    {
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $file = $request->file('cover');
            $destinationPath = $this->coverPath();
            $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            if ($book->cover !== null && File::exists($this->coverPath($book->cover))) {
                unlink($this->coverPath($book->cover));
            }

            return $filename;
        }

        return $book->cover ?? null;
    }

    public function redirectBackWithError(string $e = ''): void
    {
        redirect()->back()->withErrors([
            __('Whoops, something went wrong on our servers.').$e,
        ])->withInput()->throwResponse();
    }

    public function saveItem($request): void
    {
        if (isset($request['id'])) {
            $item = $this->get($request['id']);
        } else {
            $item = new Book();
        }
        $item->title = $request['title'];
        $item->cover = $this->uploadCover($item, $request);
        $item->audio_book = $request['audio_book'];
        try {
            $item->save();
        } catch (Exception $e) {
            Log::error($e);

            $this->redirectBackWithError();
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $item = $this->get($id);
            if (File::exists($this->coverPath($item->cover))) {
                unlink($this->coverPath($item->cover));
            }
            $pages = BookPage::where('book_id', $id)->get();
            foreach ($pages as $page) {
                if ($page->image !== null && File::exists($this->coverPath($page->image))) {
                    unlink($this->coverPath($page->image));
                }
                if ($page->sound !== null && File::exists(storage_path('sound/'.$page->sound))) {
                    unlink(storage_path('sound/'.$page->sound));
                }
                $page->delete();
            }
            $item->delete();
        } catch (PDOException $e) {
            Log::error($e);

            return Response::message('ERROR',
                ((int) $e->getCode() === 23000) ? 'Seçilen öğeye bağlı veri bulunmaktadır. Verileri sildikten sonra tekrar deneyebilirsiniz.' : __('Whoops, something went wrong on our servers.')
            );
        } catch (Exception) {
            return Response::message('ERROR', __('Whoops, something went wrong on our servers.'));
        }

        return Response::message('OK');
    }

    public function serve($id): BinaryFileResponse
    {
        $item = $this->get($id);

        return response()->file($this->coverPath($item->cover));
    }
}
