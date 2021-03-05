<?php

namespace Lumberjack\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lumberjack\Traits\Migratable;

/**
 * Lumberjack\Models\Referrer Model.
 *
 * Standard Referrer Model.
 *
 * @author    Richard Browne <hello@my-source.co.uk>
 * @copyright 2020 my-source.co.uk
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Referrer extends Model
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
        'referrer_hostname',
        'referrer_pathname',
        'referrals',
        'timestamp',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'site_id' => 'string',
        'referrer_hostname' => 'string',
        'referrer_pathname' => 'string',
        'referrals' => 'integer',
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
        'referrer_hostname' => 'required',
        'referrer_pathname' => 'required',
        'referrals' => 'required',
        'timestamp' => 'required',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes additional attributes for model initialisation
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('lumberjack.table_names.referrer_stats'));
        parent::__construct($attributes);
    }
}
