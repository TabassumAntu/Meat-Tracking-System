<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\MassDestroyUserRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use App\Http\Requests\UpdateUserAvatarRequest;

class UserController extends BaseController
{

    public function index()
    {
        abort_if(Gate::denies('user_access'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $users = $this->userRepository->all(['roles'], ['id', 'name', 'email', 'created_at'], 10);

        $roles = $this->roleRepository->getRolesView();

        return view('users.index', compact('users', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $response =  $this->userRepository->createAndSync($request->all(), 'roles');
        return redirect()->route('users.index')->with('status', $response->content());
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = $this->roleRepository->getRolesView();

        $user->load('roles');

        return view('users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $response = $this->userRepository->updateAndSync($request->all(), $user, 'roles');

        return redirect()->back()->with('status', $response->content());
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $allRoles = $this->roleRepository->getRolesView();

        $user->load('roles');

        return view('users.show', compact('user', 'allRoles'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $this->userRepository->delete($user);

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $response = $this->userRepository->massDestroy(request('ids'));

        return back()->with('status', $response->content());
    }

    public function updateAvatar(UpdateUserAvatarRequest $request, User $user) {
        $response = $this->userRepository->updateAvatar($request, $user);

        return back()->with('status', $response->content());
    }
}
