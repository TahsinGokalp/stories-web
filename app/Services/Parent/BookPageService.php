<?php

namespace App\Services\Parent;

use function __;
use App\Models\BookPage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDOException;
use function redirect;
use Response;
use function response;
use function storage_path;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class BookPageService
{
    private function coverPath($image = null): string
    {
        return storage_path('books/'.$image);
    }

    private function soundPath($sound = null): string
    {
        return storage_path('sound/'.$sound);
    }

    public function data($bookId): ?JsonResponse
    {
        $model = BookPage::where('book_id', $bookId);
        try {
            return DataTables::of($model)->addColumn('image_html', function ($item) use ($bookId) {
                return '<img src="'.route('books.page.serve', [$bookId, $item->id]).'" class="max-w-full h-auto rounded-lg text-center" style="height:200px;">';
            })->addColumn('actions', function ($item) use ($bookId) {
                return '<a href="'.route('books.page.edit', [$bookId, $item->id]).'" class="my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">Düzenle</a>'.
                    '<a href="'.route('books.page.delete', [$bookId, $item->id]).'" class="delete-btn my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">Sil</a>';
            })->toJson();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([]);
        }
    }

    public function get($id): BookPage
    {
        return BookPage::findOrFail($id);
    }

    public function uploadImage(BookPage $book, $request): ?string
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $destinationPath = $this->coverPath();
            $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            if ($book->image !== null && File::exists($this->coverPath($book->image))) {
                unlink($this->coverPath($book->image));
            }

            return $filename;
        }

        return $book->image ?? null;
    }

    public function uploadSound(BookPage $book, $request): ?string
    {
        if ($request->hasFile('sound') && $request->file('sound')->isValid()) {
            $file = $request->file('sound');
            $destinationPath = $this->soundPath();
            $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            if ($book->sound !== null && File::exists($this->soundPath($book->sound))) {
                unlink($this->soundPath($book->sound));
            }

            return $filename;
        }

        return $book->sound ?? null;
    }

    public function redirectBackWithError(string $e = ''): void
    {
        redirect()->back()->withErrors([
            __('Whoops, something went wrong on our servers.').$e,
        ])->withInput()->throwResponse();
    }

    public function saveItem($bookId, $request): void
    {
        if (isset($request['id'])) {
            $item = $this->get($request['id']);
        } else {
            $item = new BookPage();
            $item->book_id = $bookId;
        }
        $item->page_order = $request['page_order'];
        $item->image = $this->uploadImage($item, $request);
        $item->sound = $this->uploadSound($item, $request);
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
            if (File::exists($this->coverPath($item->image))) {
                unlink($this->coverPath($item->image));
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

        return response()->file($this->coverPath($item->image));
    }
}
