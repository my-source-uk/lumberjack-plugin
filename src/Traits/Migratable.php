<?php

namespace Lumberjack\Traits;

/**
 * Lumberjack\Traits\Migratable.
 *
 * Trait providing additional functionalities for migratable models.
 *
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
trait Migratable
{
    /**
     * Accessor for the table name of the model, whether this is the Laravel default one
     * (derived from the model name), or explicitly set table name in the model.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return (string) with(new static())->getTable();
    }
}
