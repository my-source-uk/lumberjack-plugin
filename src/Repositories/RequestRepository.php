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
                $visitor = $this->model
                    ->orderBy('id', 'DESC')
                    ->firstWhere('user_signature', $data['user_signature']);

                $page = $this->model
                    ->orderBy('id', 'DESC')
                    ->firstWhere('page_signature', $data['page_signature']);

                if (false === is_null($visitor)) {
                    // We have an visitor record:
                    $data['is_new_visit'] = false;
                    $data['is_new_session'] = false;
                    $data['is_unique'] = is_null($page);
                    // So we need to update the previous visit.
                    $visitor->user_signature = '';
                    $visitor->is_bounce = false;
                    $visitor->save();
                }
                $this->model->create($data);
            }
        );
    }
}
