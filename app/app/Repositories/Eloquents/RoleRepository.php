<?php


namespace App\Repositories\Eloquents;


use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    protected $role;

    /**
     * RoleRepository constructor.
     */
    public function __construct(Role $role)
    {
        $this->role = $role;

        parent::__construct($role);
    }

    public function getRolesView(): Collection
    {
        return $this->role::all()->pluck('name', 'id');
    }

}
