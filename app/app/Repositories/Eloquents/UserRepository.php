<?php


namespace App\Repositories\Eloquents;


use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $user;

    /**
     * UserRepository constructor.
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    public function updateAvatar(Request $request, User $user): Response
    {
        if ($request->hasFile('avatar')) {

            $path = Storage::putFile('public/avatars', $request->file('avatar'));

            $user->update(['avatar' => basename($path)]);
        }
        return response('Profile Updated Successfully', SymfonyResponse::HTTP_OK);
    }

    public function createAndSyncReturnModel(array $attributes, string $relation): User
    {
        if ($attributes['password']) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $user  = $this->user->create($attributes);

        $user->$relation()->sync($attributes[$relation] ?? []);

        return $user;
    }
}
