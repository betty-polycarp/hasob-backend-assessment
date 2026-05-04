<?php

namespace DMO\SavingsBond\Models;

use Eloquent as Model;
use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bid
 *
 * @version April 12, 2022, 7:27 pm UTC
 *
 * @property Offer $offer
 * @property User $user
 * @property string $organization_id
 * @property string $offer_id
 * @property string $user_id
 * @property string $status
 * @property number $price_per_unit
 * @property number $total_price
 */
class Bid extends Model
{
    use GuidId;
    use HasFactory;
    use OrganizationalConstraint;
    use SoftDeletes;

    public $table = 'sb_bids';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'organization_id',
        'offer_id',
        'user_id',
        'status',
        'price_per_unit',
        'total_price',
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
        'units_requested' => 'integer',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * @return HasOne
     **/
    public function offer()
    {
        return $this->hasOne(Offer::class, 'offer_id', 'id');
    }

    /**
     * @return HasOne
     **/
    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
