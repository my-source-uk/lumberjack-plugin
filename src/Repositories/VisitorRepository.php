<?php

namespace Lumberjack\Repositories;

use Lumberjack\Contracts\VisitorRepository as Contract;

use Lumberjack\Models\Visitor;

/**
 * Lumberjack\Repositories\VisitorRepository VisitorRepository.
 *
 * The repository for Visitor.
 * Class VisitorRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
class VisitorRepository extends BaseRepository implements Contract
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
     * @return String Visitor Model
     **/
    public function model()
    {
        return config('lumberjack.models.visitor');
    }
}
