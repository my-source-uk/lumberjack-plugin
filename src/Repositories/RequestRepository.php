<?php

namespace Lumberjack\Repositories;

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
}
