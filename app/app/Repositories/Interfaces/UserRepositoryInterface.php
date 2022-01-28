<?php


namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function updateAvatar(Request $request, User $user) : Response;

    /**
     * @param array $attributes
     * @param string $relation
     * @return User
     */
    public function createAndSyncReturnModel(array $attributes, string $relation) : User;
}
