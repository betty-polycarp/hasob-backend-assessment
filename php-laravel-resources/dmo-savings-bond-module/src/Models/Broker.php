<?php

namespace DMO\SavingsBond\Models;

use Eloquent as Model;
use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Broker
 *
 * @version April 12, 2022, 7:27 pm UTC
 *
 * @property string $organization_id
 * @property string $status
 * @property string $broker_code
 * @property string $full_name
 * @property string $short_name
 */
class Broker extends Model
{
    use GuidId;
    use HasFactory;
    use OrganizationalConstraint;
    use SoftDeletes;

    public $table = 'sb_brokers';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'organization_id',
        'status',
        'broker_code',
        'full_name',
        'short_name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'display_ordinal' => 'integer',
        'status' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string',
        'broker_code' => 'string',
        'full_name' => 'string',
        'short_name' => 'string',
    ];
}
