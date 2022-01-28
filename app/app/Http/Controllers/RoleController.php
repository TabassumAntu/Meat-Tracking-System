<?php

namespace App\Http\Controllers;

use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use \Spatie\Permission\Models\Role;
use Gate;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class RoleController extends BaseController
{

    public function index()
    {
        abort_if(Gate::denies('role_access'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = $this->roleRepository->all(['permissions'], ['id', 'name']);

        $permissions = $this->permissionRepository->all([], ['id', 'name']);


        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $response = $this->roleRepository->createAndSync($request->all(), 'permissions');

        return redirect()->route('roles.index')->with('status', $response->content());
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        $permissions = $this->permissionRepository->all([], ['id', 'name']);

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $response = $this->roleRepository->updateAndSync($request->all(), $role, 'permissions');

        return redirect()->route('roles.index')->with('status', $response->content());
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), SymfonyResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $response = $this->roleRepository->delete($role);

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        $response = $this->roleRepository->massDestroy(request('ids'));

        return back()->with('status', $response->content());
    }
}
