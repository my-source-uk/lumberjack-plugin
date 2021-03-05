<?php

namespace Lumberjack\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lumberjack\Traits\Migratable;

/**
 * Lumberjack\Models\Request Model.
 *
 * Standard Request Model.
 *
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Request extends Model
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
        'user_signature',
        'hostname',
        'pathname',
        'is_new_visit',
        'is_new_session',
        'is_unique',
        'is_bounce',
        'referrer_hostname',
        'referrer_pathname',
        'duration',
        'page_signature',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'site_id' => 'integer',
        'user_signature' => 'string',
        'hostname' => 'string',
        'pathname' => 'string',
        'is_new_visit' => 'boolean',
        'is_new_session' => 'boolean',
        'is_unique' => 'boolean',
        'is_bounce' => 'boolean',
        'referrer_hostname' => 'string',
        'referrer_pathname' => 'string',
        'duration' => 'integer',
        'page_signature' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'site_id' => 'required',
        'user_signature' => 'required',
        'hostname' => 'required',
        'pathname' => 'required',
        'page_signature' => 'required',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes additional attributes for model initialisation
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('lumberjack.table_names.requests'));
        parent::__construct($attributes);
    }
}
