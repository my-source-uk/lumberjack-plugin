<?php

namespace Lumberjack\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Lumberjack\Contracts\BaseRepository as Contract;

/**
 * Lumberjack\Repositories\BaseRepository BaseRepository.
 *
 * This BaseRepository all other Repositories should implent.
 * Class BaseRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
abstract class BaseRepository implements Contract
{
    /**
     * The model instance.
     *
     * @var Model $model
     */
    protected $model;

    /**
     * Application instance.
     *
     * @var Application $app
     */
    protected $app;

    /**
     * Order deatils.
     *
     * @var array $orderBy
     */
    protected $orderBy = [];

    /**
     * Contructor.
     *
     * @param Application $app Application instance.
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Make Model instance.
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (false === $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int   $perPage       Number of items per page.
     * @param array $columns       Columns to return.
     * @param array $relationships Relationships to eager load.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'], $relationships = [])
    {
        $query = $this->allQuery([], null, null, $relationships);

        return $query->paginate($perPage, $columns);
    }

    /**
     * Order by for scaffold.
     *
     * @param array|string $orderBy Column [, and dir] to order by.
     *
     * @return self
     */
    public function orderBy($orderBy)
    {
        if (false === is_array($orderBy)) {
            $this->orderBy[$orderBy] = 'asc';
        } else {
            foreach ($orderBy as $key => $value) {
                if (false === is_array($value)) {
                    // String...
                    if (false === in_array(strtolower($value), ['asc', 'desc'])) {
                        $this->orderBy[$value] = 'asc';
                    } else {
                        $this->orderBy[$key] = $value;
                    }
                } else {
                    // Array...
                    if (true === isset($value[0])) {
                        $this->orderBy[$value[0]] = 'asc';
                    } else {
                        $this->orderBy = array_merge($this->orderBy, $value);
                    }
                }
            }
        }//end if

        return $this;
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array    $search        Search parameters
     * @param int|null $skip          Number of items to skip
     * @param int|null $limit         Limit of the query results.
     * @param array    $relationships Relationships to eager load.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null, $relationships = [])
    {
        $query = $this->model->with($relationships)->newQuery();

        if (count($search) > 0) {
            foreach ($search as $key => $value) {
                if (true === in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, ...$value);
                }
            }
        }

        if (false === is_null($skip)) {
            $query->skip($skip);
        }

        if (false === is_null($limit)) {
            $query->limit($limit);
        }

        if (false === is_null($this->orderBy)) {
            foreach ($this->orderBy as $key => $value) {
                $query->orderBy($key, $value);
            }
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria.
     *
     * @param array    $search        Search parameters.
     * @param int|null $skip          Number of entries to skip.
     * @param int|null $limit         Number of entries to return.
     * @param array    $columns       Columns to return.
     * @param array    $relationships Relationships to eager load.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'], $relationships = [])
    {
        $query = $this->allQuery($search, $skip, $limit, $relationships);

        return $query->get($columns);
    }

    /**
     * Create model record.
     *
     * @param array $input Input values to save.
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Initiate new model record.
     *
     * @param array $input Input values to save.
     *
     * @return Model
     */
    public function new($input)
    {
        $model = $this->model->newInstance($input);

        return $model;
    }

    /**
     * Find model record for given id.
     *
     * @param int   $id            ID of the record.
     * @param array $columns       Columns to return.
     * @param array $relationships Relationships to eager load.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'], $relationships = [])
    {
        $query = $this->model->with($relationships)->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id.
     *
     * @param array $input Input values to save.
     * @param int   $id    ID for the record to update.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * Delete model record for a given id.
     *
     * @param int $id ID for the record to delete.
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * Delete model records where column in needles.
     *
     * @param int[]  $needles Needles for the record to delete.
     * @param string $column  Column name to "search". Default: id.
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function deleteWhereIn($needles, $column = 'id')
    {
        $query = $this->model->newQuery();

        $models = $query->whereIn($column, $needles);

        return $models->delete();
    }
}
