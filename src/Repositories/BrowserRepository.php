<?php

namespace Lumberjack\Repositories;

use Lumberjack\Contracts\BrowserRepository as Contract;

use Lumberjack\Models\Browser;

/**
 * Lumberjack\Repositories\BrowserRepository BrowserRepository.
 *
 * The repository for Browser.
 * Class BrowserRepository
 *
 * @package   Sticky Fox
 * @author    Richard Browne <hello@my-source.co.uk
 * @copyright 2020 my-source.co.uk.
 * @license   license.md All rights reserved.
 */
class BrowserRepository extends BaseRepository implements Contract
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
     * @return String Browser Model
     **/
    public function model()
    {
        return config('lumberjack.models.browser');
    }

    /**
     * Increment the browser count.
     *
     * @param Array $search Data to search for
     *
     * @return void
     */
    public function increment(array $search): void
    {
        $model = $this->model->firstOrNew($search);
        $model->count++;
        $model->save();
    }
}
