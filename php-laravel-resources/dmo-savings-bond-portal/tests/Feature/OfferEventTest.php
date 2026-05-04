<?php

namespace Tests\Feature;

use Carbon\Carbon;
use DMO\SavingsBond\Events\OfferCreated;
use DMO\SavingsBond\Events\OfferDeleted;
use DMO\SavingsBond\Events\OfferUpdated;
use DMO\SavingsBond\Listeners\OfferCreatedListener;
use DMO\SavingsBond\Listeners\OfferDeletedListener;
use DMO\SavingsBond\Listeners\OfferUpdatedListener;
use DMO\SavingsBond\Models\Offer;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OfferEventTest extends TestCase
{
    private function makeOffer(): Offer
    {
        return Offer::create([
            'organization_id' => $this->test_org->id,
            'display_ordinal' => 1,
            'status' => 'open',
            'offer_title' => 'FGN Savings Bond - Event Test',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 10000,
            'interest_rate_pct' => 12.50,
            'offer_start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'offer_end_date' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
            'offer_settlement_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'offer_maturity_date' => Carbon::now()->addYears(2)->format('Y-m-d H:i:s'),
            'tenor_years' => 2,
        ]);
    }

    /** @test */
    public function offer_created_event_is_dispatched_with_the_offer()
    {
        Event::fake([OfferCreated::class]);

        $offer = $this->makeOffer();
        OfferCreated::dispatch($offer);

        Event::assertDispatched(
            OfferCreated::class,
            fn (OfferCreated $event) => $event->offer->id === $offer->id
        );
    }

    /** @test */
    public function offer_updated_event_is_dispatched_with_the_offer()
    {
        Event::fake([OfferUpdated::class]);

        $offer = $this->makeOffer();
        $offer->fill(['status' => 'closed'])->save();
        OfferUpdated::dispatch($offer);

        Event::assertDispatched(
            OfferUpdated::class,
            fn (OfferUpdated $event) => $event->offer->id === $offer->id
                && $event->offer->status === 'closed'
        );
    }

    /** @test */
    public function offer_deleted_event_is_dispatched_with_the_offer()
    {
        Event::fake([OfferDeleted::class]);

        $offer = $this->makeOffer();
        OfferDeleted::dispatch($offer);
        $offer->delete();

        Event::assertDispatched(
            OfferDeleted::class,
            fn (OfferDeleted $event) => $event->offer->id === $offer->id
        );
    }

    /** @test */
    public function offer_event_is_not_dispatched_when_no_action_is_taken()
    {
        Event::fake([OfferCreated::class, OfferUpdated::class, OfferDeleted::class]);

        Event::assertNotDispatched(OfferCreated::class);
        Event::assertNotDispatched(OfferUpdated::class);
        Event::assertNotDispatched(OfferDeleted::class);
    }

    /** @test */
    public function offer_created_listener_is_invoked_when_event_fires()
    {
        Event::listen(OfferCreated::class, OfferCreatedListener::class);

        $invoked = false;
        Event::listen(OfferCreated::class, function (OfferCreated $e) use (&$invoked) {
            $invoked = true;
        });

        $offer = $this->makeOffer();
        OfferCreated::dispatch($offer);

        $this->assertTrue($invoked, 'OfferCreated listeners were not invoked.');
    }

    /** @test */
    public function offer_updated_listener_is_invoked_when_event_fires()
    {
        Event::listen(OfferUpdated::class, OfferUpdatedListener::class);

        $captured = null;
        Event::listen(OfferUpdated::class, function (OfferUpdated $e) use (&$captured) {
            $captured = $e->offer;
        });

        $offer = $this->makeOffer();
        $offer->fill(['status' => 'closed'])->save();
        OfferUpdated::dispatch($offer);

        $this->assertNotNull($captured);
        $this->assertEquals($offer->id, $captured->id);
        $this->assertEquals('closed', $captured->status);
    }

    /** @test */
    public function offer_deleted_listener_is_invoked_when_event_fires()
    {
        Event::listen(OfferDeleted::class, OfferDeletedListener::class);

        $captured_id = null;
        Event::listen(OfferDeleted::class, function (OfferDeleted $e) use (&$captured_id) {
            $captured_id = $e->offer->id;
        });

        $offer = $this->makeOffer();
        $offer_id = $offer->id;
        OfferDeleted::dispatch($offer);
        $offer->delete();

        $this->assertEquals($offer_id, $captured_id);
    }
}
