<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

use DMO\SavingsBond\Models\Bid;
use DMO\SavingsBond\Models\Offer;
use DMO\SavingsBond\Models\Broker;
use DMO\SavingsBond\Models\Subscription;

class OfferRelationshipTest extends TestCase
{
    private function makeOffer(): Offer
    {
        return Offer::create([
            'organization_id'        => $this->test_org->id,
            'display_ordinal'        => 1,
            'status'                 => 'open',
            'offer_title'            => 'FGN Savings Bond Test Offer',
            'price_per_unit'         => 1000.00,
            'max_units_per_investor' => 10000,
            'interest_rate_pct'      => 12.50,
            'offer_start_date'       => Carbon::now()->format('Y-m-d H:i:s'),
            'offer_end_date'         => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
            'offer_settlement_date'  => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'offer_maturity_date'    => Carbon::now()->addYears(2)->format('Y-m-d H:i:s'),
            'tenor_years'            => 2,
        ]);
    }

    private function makeBroker(): Broker
    {
        return Broker::create([
            'organization_id' => $this->test_org->id,
            'display_ordinal' => 1,
            'status'          => 'active',
            'broker_code'     => 'BRK001',
            'full_name'       => 'Test Broker Ltd',
            'short_name'      => 'TBL',
        ]);
    }

    /** @test */
    public function bids_relationship_returns_a_has_many_instance()
    {
        $offer = $this->makeOffer();

        $this->assertInstanceOf(HasMany::class, $offer->bids());
        $this->assertEquals('offer_id', $offer->bids()->getForeignKeyName());
    }

    /** @test */
    public function subscriptions_relationship_returns_a_has_many_instance()
    {
        $offer = $this->makeOffer();

        $this->assertInstanceOf(HasMany::class, $offer->subscriptions());
        $this->assertEquals('offer_id', $offer->subscriptions()->getForeignKeyName());
    }

    /** @test */
    public function offer_returns_its_related_bids()
    {
        $offer       = $this->makeOffer();
        $other_offer = $this->makeOffer();

        Bid::create([
            'organization_id' => $this->test_org->id,
            'offer_id'        => $offer->id,
            'user_id'         => $this->test_user->id,
            'status'          => 'pending',
            'price_per_unit'  => 1000.00,
            'total_price'     => 5000.00,
        ]);
        Bid::create([
            'organization_id' => $this->test_org->id,
            'offer_id'        => $offer->id,
            'user_id'         => $this->test_user->id,
            'status'          => 'pending',
            'price_per_unit'  => 1000.00,
            'total_price'     => 2000.00,
        ]);
        // a bid against a different offer should NOT come back
        Bid::create([
            'organization_id' => $this->test_org->id,
            'offer_id'        => $other_offer->id,
            'user_id'         => $this->test_user->id,
            'status'          => 'pending',
            'price_per_unit'  => 1000.00,
            'total_price'     => 1000.00,
        ]);

        $bids = $offer->bids()->get();

        $this->assertCount(2, $bids);
        $this->assertInstanceOf(Bid::class, $bids->first());
        $this->assertTrue($bids->every(fn ($b) => $b->offer_id === $offer->id));
    }

    /** @test */
    public function offer_returns_its_related_subscriptions()
    {
        $offer  = $this->makeOffer();
        $broker = $this->makeBroker();

        $base = [
            'organization_id'         => $this->test_org->id,
            'offer_id'                => $offer->id,
            'user_id'                 => $this->test_user->id,
            'broker_id'               => $broker->id,
            'broker_code'             => $broker->broker_code,
            'broker_name'             => $broker->full_name,
            'status'                  => 'active',
            'price_per_unit'          => 1000.00,
            'total_price'             => 10000.00,
            'interest_rate_pct'       => 12.50,
            'offer_start_date'        => Carbon::now()->format('Y-m-d H:i:s'),
            'offer_end_date'          => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
            'offer_settlement_date'   => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'offer_maturity_date'     => Carbon::now()->addYears(2)->format('Y-m-d H:i:s'),
            'tenor_years'             => 2,
            'investor_email'          => 'investor@example.com',
            'investor_telephone'      => '08000000000',
            'first_name'              => 'Ada',
            'middle_name'             => 'N',
            'last_name'               => 'Eze',
            'origin_geo_zone'         => 'south-east',
            'origin_lga'              => 'Aba North',
            'address_street'          => '1 Test Street',
            'address_town'            => 'Aba',
            'address_state'           => 'Abia',
            'bank_account_name'       => 'Ada Eze',
            'bank_account_number'     => '0123456789',
            'bank_name'               => 'Test Bank',
            'bank_verification_number'=> '12345678901',
            'national_id_number'      => 'NIN001',
            'cscs_id_number'          => 'CSCS001',
            'chn_id_number'           => 'CHN001',
        ];

        Subscription::create($base);
        Subscription::create(array_merge($base, ['investor_email' => 'second@example.com']));

        $subs = $offer->subscriptions()->get();

        $this->assertCount(2, $subs);
        $this->assertInstanceOf(Subscription::class, $subs->first());
        $this->assertTrue($subs->every(fn ($s) => $s->offer_id === $offer->id));
    }

    /** @test */
    public function offer_with_no_bids_or_subscriptions_returns_empty_collections()
    {
        $offer = $this->makeOffer();

        $this->assertCount(0, $offer->bids()->get());
        $this->assertCount(0, $offer->subscriptions()->get());
    }
}
