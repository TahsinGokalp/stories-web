<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Parent\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use function redirect;
use function view;

class UserController extends Controller
{
    protected UserService $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index(): Factory|View|Application
    {
        return view('parent.users.index');
    }

    public function data(): ?JsonResponse
    {
        return $this->user->data();
    }

    public function add(): Factory|View|Application
    {
        return view('parent.users.add');
    }

    public function save(SaveUserRequest $request): RedirectResponse
    {
        $this->user->saveItem($request);

        return redirect()->route('users')->with([
            'message' => 'Kullanıcı eklendi.',
        ]);
    }

    public function edit($id): Factory|View|Application
    {
        return view('parent.users.edit', [
            'edit' => $this->user->get($id),
        ]);
    }

    public function update($id, UpdateUserRequest $request): RedirectResponse
    {
        $request['id'] = $id;
        $this->user->saveItem($request);

        return redirect()->route('users')->with([
            'message' => 'Kullanıcı düzenlendi.',
        ]);
    }

    public function delete($id): JsonResponse
    {
        return $this->user->delete($id);
    }
}
