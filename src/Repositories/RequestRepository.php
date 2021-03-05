<?php

namespace Lumberjack\Repositories;

use Illuminate\Support\Facades\DB;
use Lumberjack\Contracts\RequestRepository as Contract;

use Lumberjack\Models\Request;

/**
 * Lumberjack\Repositories\RequestRepository RequestRepository.
 *
 * The repository for Request.
 * Class RequestRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
class RequestRepository extends BaseRepository implements Contract
{
    /**
     *  Fields that are searchable.
     *
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model.
     *
     * @return String Request Model
     **/
    public function model()
    {
        return config('lumberjack.models.request');
    }

    /**
     * Add a new request into the system.
     *
     * @param Array $data The data to updateOrCreate.
     *
     * @return void
     */
    public function add(array $data): void
    {
        DB::connection('lumberjack')->transaction(
            function () use ($data) {
                $existing = $this->model->firstWhere('page_signature', $data['page_signature']);
                if (false !== $existing) {
                    // We have an existing record:
                    $data['is_new_visit'] = false;
                    $data['is_new_session'] = false;
                    $data['is_unique'] = false;
                    // So we need to unset the user_signature for the previous visit.
                    $existing->user_signature = '';
                    $existing->save();
                }
                $this->model->create($data);
            }
        );
    }
}
