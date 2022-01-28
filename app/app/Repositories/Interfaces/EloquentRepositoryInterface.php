<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EloquentRepositoryInterface
{
    public function find(int $id) : Model;

    public function all (array $relations, array $attributes, int $perPage = null);

    public function pluck(string $key, string $value): Collection;

    public function create(array $attributes): Response;

    public function createAndSync (array $attributes, string $relation): Response;

    public function createAndAssociate (array $attributes, string $relation): Response;

    public function update(array $attributes, Model $model) : Response;

    public function updateAndSync(array $attributes, Model $model, string $relation) : Response;

    public function updateAndAssociate(array $attributes, Model $model, string $relation) : Response;

    public function delete(Model $model) : Response;

    public function massDestroy(array $resourceIDs) : Response;

}
