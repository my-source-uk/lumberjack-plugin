<?php

namespace Lumberjack\Repositories;

use Lumberjack\Contracts\ReferrerRepository as Contract;

use Lumberjack\Models\Referrer;

/**
 * Lumberjack\Repositories\ReferrerRepository ReferrerRepository.
 *
 * The repository for Referrer.
 * Class ReferrerRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
class ReferrerRepository extends BaseRepository implements Contract
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
     * @return String Referrer Model
     **/
    public function model()
    {
        return config('lumberjack.models.referrer');
    }

    /**
     * Increment the referrer count.
     *
     * @param Array $search Data to search for
     *
     * @return void
     */
    public function increment(array $search): void
    {
        $model = $this->model->firstOrNew($search);
        $model->referrals++;
        $model->save();
    }
}
