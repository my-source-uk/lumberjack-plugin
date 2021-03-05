<?php

namespace Lumberjack\Contracts;

/**
 * Lumberjack\Contracts\DeviceRepository DeviceRepository.
 *
 * The RepositoryContract for Account.
 * Class DeviceRepository  *
 *
 * @package   Lumberjack
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
interface DeviceRepository
{

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable();

    /**
     * Configure the Model.
     *
     * @return String Account Model
     **/
    public function model();
}