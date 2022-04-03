<?php

namespace App\Services;

use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDOException;
use Response;

class BookService
{

    public function all(): Collection
    {
        return Book::all();
    }

    public function get($id): Book
    {
        return Book::findOrFail($id);
    }

    public function uploadCover(Book $book, $request): ?string
    {
        if($request->hasFile('cover') && $request->file('cover')->isValid()){
            $file = $request->file('cover');
            $destinationPath = storage_path('books');
            $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(10).$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            if($book->cover !== null && File::exists(storage_path('books/'.$book->cover))){
                unlink(storage_path('books/'.$book->cover));
            }

            return $filename;
        }
        if($book->cover !== null){
            return $book->cover;
        }

        return null;
    }

    public function redirectBackWithError(string $e = ''): void
    {
        redirect()->back()->withErrors([
            __('Whoops, something went wrong on our servers.').$e,
        ])->withInput()->throwResponse();
    }

    public function saveItem($request): void
    {
        if(isset($request['id'])){
            $item = $this->get($request['id']);
        }else{
            $item = new Book();
        }
        $item->title = $request['title'];
        $item->cover = $this->uploadCover($item, $request);
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
            //Delete
        } catch (PDOException $e) {
            Log::error($e);

            return Response::message('ERROR',
                ((int) $e->getCode() === 23000) ? 'Seçilen öğeye bağlı veri bulunmaktadır. Verileri sildikten sonra tekrar deneyebilirsiniz.' : __('Whoops, something went wrong on our servers.')
            );
        } catch (Exception $e) {
            return Response::message('ERROR', __('Whoops, something went wrong on our servers.'));
        }

        return Response::message('OK');
    }
}
