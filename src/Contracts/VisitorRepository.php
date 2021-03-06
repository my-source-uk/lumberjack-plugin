<?php

namespace Lumberjack\Contracts;

/**
 * Lumberjack\Contracts\VisitorRepository VisitorRepository.
 *
 * The RepositoryContract for Account.
 * Class VisitorRepository  *
 *
 * @package   Lumberjack
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
interface VisitorRepository
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
     * Return if the visitor is unique and add to the database if needed.
     *
     * @param String $hash   The visitor hash to check.
     * @param Int    $siteId The site_id to store against.
     *
     * @return Bool
     */
    public function isUnique(string $hash, int $siteId): Bool;
}
