<?php


namespace App\Repositories\Interfaces;




use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface extends EloquentRepositoryInterface
{
    public function getRolesView (): Collection;

}
