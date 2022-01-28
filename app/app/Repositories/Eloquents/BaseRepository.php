<?php


namespace App\Repositories\Eloquents;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use \App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use App\Helpers\FormatData;

class BaseRepository implements EloquentRepositoryInterface
{
    use FormatData;

    private $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $relations = [], array $attributes = ['*'] , int $perPage = null)
    {
        if( ! $relations && !$perPage ) {
            return $this->model->select($attributes)->get();
        }
        // this is required because the APIs does not require pagination
        if ( !$perPage ) {
            return $this->model::with($relations)->select($attributes)->get();
        }

        return $this->model::with($relations)->select($attributes)->paginate($perPage);
    }

    public function pluck(string $key, string $value): Collection
    {
        return $this->model->pluck($value, $key);
    }

    public function create(array $attributes): Response
    {
        if (isset ( $attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $this->model->create($attributes);

        return response($this->getClassName($this->model) . ' created Successfully', SymfonyResponse::HTTP_OK);
    }

    public function createAndSync(array $attributes, string $relation): Response
    {
        if(isset ( $attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $model  = $this->model->create($attributes);

        $model->$relation()->sync($attributes[$relation] ?? []);

        return response( $this->getClassName($this->model) . ' created Successfully', SymfonyResponse::HTTP_OK);
    }

    public function createAndAssociate(array $attributes, string $relation): Response
    {
        if (isset ( $attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        $model  = $this->model->create($attributes);

        $model->$relation()->associate($attributes[$relation] ?? null);

        $model->save();

        return response( $this->getClassName($this->model) . ' created Successfully', SymfonyResponse::HTTP_OK);
    }

    public function update(array $attributes, Model $model): Response
    {
        $model->update($attributes);

        return response($this->getClassName($this->model) . ' updated Successfully', SymfonyResponse::HTTP_OK);
    }

    public function updateAndSync(array $attributes, Model $model, string $relation): Response
    {
        try {
            $model->update($attributes);
            $model->$relation()->sync($attributes[$relation] ?? []);
        } catch (\Exception $e) {
            return response($e);
        }

        return response($this->getClassName(get_class($model)) . ' updated Successfully', SymfonyResponse::HTTP_OK);
    }

    public function updateAndAssociate(array $attributes, Model $model, string $relation): Response
    {
        try {
            $model->update($attributes);
            $model->$relation()->associate($attributes[$relation] ?? null);
        } catch (\Exception $e) {
            return response($e);
        }

        return response($this->getClassName(get_class($model)) . ' updated Successfully', SymfonyResponse::HTTP_OK);
    }

    public function delete(Model $model): Response
    {
            $model->forceDelete();

        return response($this->getClassName($this->model) .' deleted Successfully', SymfonyResponse::HTTP_OK);
    }

    public function massDestroy(array $resourceIDs): Response
    {
        $this->model::whereIn('id', $resourceIDs('ids'))->delete();

        return response($this->getClassName($this->model) . ' deleted Successfully', SymfonyResponse::HTTP_OK);
    }

    public function find(int $id): Model
    {
        return $this->model::find($id);
    }
}
