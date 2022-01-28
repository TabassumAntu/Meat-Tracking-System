<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class BaseController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $permissionRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                RoleRepositoryInterface $roleRepository,
                                PermissionRepositoryInterface $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }
}
