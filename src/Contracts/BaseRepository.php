<?php

namespace Lumberjack\Contracts;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

/**
 * Lumberjack\Contracts\BaseRepository BaseRepository.
 *
 * This BaseRepository all other Repositories should implent.
 * Class BaseRepository
 *
 * @package   Lumberjack
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
interface BaseRepository
{
    /**
     * Contructor.
     *
     * @param Application $app Application instance.
     *
     * @throws \Exception
     */
    public function __construct(Application $app);

    /**
     * Get searchable fields array.
     *
     * @return array
     */
    public function getFieldsSearchable();

    /**
     * Configure the Model.
     *
     * @return String
     */
    public function model();

    /**
     * Make Model instance.
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel();

    /**
     * Paginate records for scaffold.
     *
     * @param int   $perPage       Number of items per page.
     * @param array $columns       Columns to return.
     * @param array $relationships Relationships to eager load.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'], $relationships = []);

    /**
     * Order by for scaffold.
     *
     * @param array|string $orderBy Column [, and dir] to order by.
     *
     * @return self
     */
    public function orderBy($orderBy);

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
    public function allQuery($search = [], $skip = null, $limit = null, $relationships = []);

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
    public function all(
        $search = [],
        $skip = null,
        $limit = null,
        $columns = ['*'],
        $relationships = []
    );

    /**
     * Create model record.
     *
     * @param array $input Input values to save.
     *
     * @return Model
     */
    public function create($input);

    /**
     * New model record.
     *
     * @param array $input Input values to save.
     *
     * @return Model
     */
    public function new($input);

    /**
     * Find model record for given id.
     *
     * @param int   $id            ID of the record.
     * @param array $columns       Columns to return.
     * @param array $relationships Relationships to eager load.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'], $relationships = []);

    /**
     * Update model record for given id.
     *
     * @param array $input Input values to save.
     * @param int   $id    ID for the record to update.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id);

    /**
     * Delete model record for a given id.
     *
     * @param int $id ID for the record to delete.
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id);
}
