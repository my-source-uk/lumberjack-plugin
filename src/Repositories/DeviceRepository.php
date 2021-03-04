<?php

namespace Lumberjack\Repositories;

use Lumberjack\Contracts\DeviceRepository as Contract;

use Lumberjack\Models\Device;

/**
 * Lumberjack\Repositories\DeviceRepository DeviceRepository.
 *
 * The repository for Device.
 * Class DeviceRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
class DeviceRepository extends BaseRepository implements Contract
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
     * @return String Device Model
     **/
    public function model()
    {
        return config('lumberjack.models.device');
    }
}
