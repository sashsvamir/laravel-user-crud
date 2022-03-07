<?php

namespace Sashsvamir\LaravelUserCRUD\Http\Controllers;

use App\Models\User;
use Sashsvamir\LaravelUserCRUD\Http\Requests\UserCreateRequest;
use Sashsvamir\LaravelUserCRUD\Http\Requests\UserUpdateRequest;
use Sashsvamir\LaravelUserCRUD\Services\UserService;


class UserController
{

    public function index()
    {
        $users = User::all();

        return view('user-crud::web.admin.user.index', compact('users'));
    }

    public function create()
    {
        $user = new User;
        $roles = User::getAvailableRoles();

        return view('user-crud::web.admin.user.show', compact('user', 'roles'));
    }

    public function store(UserCreateRequest $request)
    {
        UserService::create($request->validated());

        return redirect()
            ->route('admin.user.index')
            ->with('message', 'User created');
    }

    public function edit(User $user)
    {
        $roles = User::getAvailableRoles();

        return view('user-crud::web.admin.user.show', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        UserService::update($user, $request->validated());

        return redirect()
            ->route('admin.user.index')
            ->with('message', 'User saved');
    }

    public function destroy(User $user)
    {
        UserService::delete($user);

        return redirect()
            ->route('admin.user.index')
            ->with('message', 'User deleted');
    }

}
