<?php

namespace App\Services\Parent;

use function __;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PDOException;
use function redirect;
use Response;
use function response;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function data(): ?JsonResponse
    {
        $model = User::query();
        try {
            return DataTables::of($model)->addColumn('actions', function ($item) {
                return '<a href="'.route('users.edit', $item->id).'" class="my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">Düzenle</a>'.
                       '<a href="'.route('users.delete', $item->id).'" class="delete-btn my-4 inline-flex justify-center mr-2 rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">Sil</a>';
            })->toJson();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([]);
        }
    }

    public function get($id): User
    {
        return User::findOrFail($id);
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
            $role = Role::where('name', $request['role'])->firstOrFail();
            $item = new User();
        }
        $item->name = $request['name'];
        $item->email = $request['email'];
        if (! empty($request['password'])) {
            $item->password = Hash::make($request['password']);
        }
        try {
            $item->save();
            if (isset($role)) {
                $item->assignRole($role);
            }
        } catch (Exception $e) {
            Log::error($e);

            $this->redirectBackWithError();
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $item = $this->get($id);
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
}
