<?php


namespace App\Repositories\Eloquents;


use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected $permission;

    /**
     * PermissionRepository constructor.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;

        parent::__construct($permission);
    }

}
