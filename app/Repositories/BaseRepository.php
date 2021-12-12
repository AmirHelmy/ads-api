<?php

namespace App\Repositories;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class BaseRepository
{

    protected $model;
    protected $filters = [];
    protected $extactFilters = [];
    protected $prePage = 10;

    public function create($inputs)
    {
        return $this->model->create($inputs);
    }

    public function all()
    {
        return QueryBuilder::for(get_class($this->model))
            ->allowedFilters(
                array_merge(
                    array_map(fn ($filter) => AllowedFilter::exact($filter), $this->extactFilters),
                    $this->filters
                )
            )
            ->with(request('includes', []))
            ->paginate($this->prePage);
    }

    public function findBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    public function find($id)
    {
        return $this->findBy('id', $id);
    }

    public function update($record, $inputs)
    {
        return tap($record)->update($inputs);
    }

    public function destroy($id)
    {
        try {
            $record = $this->find($id);
            return $record ? $record->delete() : response()
                ->json(['message' => 'record not found'])
                ->setStatusCode(404);
        } catch (QueryException $exception) {
            return response()
                ->json(['message' => 'DELETE is impossible on the resource'])
                ->setStatusCode(409);
        }
    }
}
