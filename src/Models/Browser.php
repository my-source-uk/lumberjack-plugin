<?php

namespace Lumberjack\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lumberjack\Traits\Migratable;

/**
 * Lumberjack\Models\Browser Model.
 *
 * Standard Browser Model.
 *
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Browser extends Model
{
    use Migratable;

    /**
     * Set the database connection.
     *
     * @var string
     */
    protected $connection = 'lumberjack';

    /**
     * The attributes that can be filled.
     *
     * @var string[]
     */
    public $fillable = [
        'site_id',
        'browser',
        'version',
        'count',
        'timestamp',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'site_id' => 'integer',
        'browser' => 'string',
        'version' => 'string',
        'count' => 'integer',
    ];

    /**
     * The attributes that should be cast to Carbon Dates.
     *
     * @var array
     */
    protected $dates = [
        'timestamp',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'site_id' => 'required',
        'browser' => 'required',
        'version' => 'required',
        'count' => 'required',
        'timestamp' => 'required',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes additional attributes for model initialisation
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('lumberjack.table_names.browser_stats'));
        parent::__construct($attributes);
    }
}
