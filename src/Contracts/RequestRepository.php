<?php

namespace Lumberjack\Contracts;

/**
 * Lumberjack\Contracts\RequestRepository RequestRepository.
 *
 * The RepositoryContract for Account.
 * Class RequestRepository  *
 *
 * @package   Lumberjack
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
interface RequestRepository
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

    /**
     * Add a new request into the system.
     *
     * @param Array $data The data to updateOrCreate.
     *
     * @return void
     */
    public function add(array $data): void;
}
