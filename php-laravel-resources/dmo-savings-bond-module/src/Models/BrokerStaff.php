<?php

namespace DMO\SavingsBond\Models;

use Eloquent as Model;
use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BrokerStaff
 *
 * @version April 12, 2022, 7:27 pm UTC
 *
 * @property Broker $broker
 * @property User $user
 * @property string $organization_id
 * @property string $broker_id
 * @property string $user_id
 * @property string $status
 */
class BrokerStaff extends Model
{
    use GuidId;
    use HasFactory;
    use OrganizationalConstraint;
    use SoftDeletes;

    public $table = 'sb_broker_staff';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'organization_id',
        'broker_id',
        'user_id',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'display_ordinal' => 'integer',
        'status' => 'string',
        'role' => 'string',
    ];

    /**
     * @return HasOne
     **/
    public function broker()
    {
        return $this->hasOne(Broker::class, 'broker_id', 'id');
    }

    /**
     * @return HasOne
     **/
    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
