<?php

namespace Tests\Feature;

use Carbon\Carbon;
use DMO\SavingsBond\Models\Offer;
use Tests\TestCase;

class OfferCrudTest extends TestCase
{
    /**
     * Build a deterministic payload for an Offer record. Factory faker values
     * are not always type-safe (e.g. price_per_unit -> faker word), so we build
     * the payload here to keep CRUD assertions stable.
     */
    private function offerPayload(array $overrides = []): array
    {
        return array_merge([
            'organization_id' => $this->test_org->id,
            'display_ordinal' => 1,
            'status' => 'open',
            'offer_title' => 'FGN Savings Bond March 2026',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 10000,
            'interest_rate_pct' => 12.50,
            'offer_start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'offer_end_date' => Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
            'offer_settlement_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'offer_maturity_date' => Carbon::now()->addYears(2)->format('Y-m-d H:i:s'),
            'tenor_years' => 2,
        ], $overrides);
    }

    /** @test */
    public function it_creates_an_offer_record()
    {
        $payload = $this->offerPayload();

        $offer = Offer::create($payload);

        $this->assertNotEmpty($offer->id);
        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
            'offer_title' => 'FGN Savings Bond March 2026',
            'status' => 'open',
            'tenor_years' => 2,
        ]);
    }

    /** @test */
    public function it_retrieves_a_single_offer_and_lists_offers()
    {
        $offer = Offer::create($this->offerPayload(['offer_title' => 'Bond A']));
        Offer::create($this->offerPayload(['offer_title' => 'Bond B']));
        Offer::create($this->offerPayload(['offer_title' => 'Bond C']));

        $found = Offer::find($offer->id);
        $this->assertNotNull($found);
        $this->assertEquals('Bond A', $found->offer_title);

        $all = Offer::all();
        $this->assertCount(3, $all);
        $this->assertEqualsCanonicalizing(
            ['Bond A', 'Bond B', 'Bond C'],
            $all->pluck('offer_title')->all()
        );
    }

    /** @test */
    public function it_updates_an_offer_record()
    {
        $offer = Offer::create($this->offerPayload(['status' => 'open', 'tenor_years' => 2]));

        $offer->fill([
            'status' => 'closed',
            'tenor_years' => 5,
            'offer_title' => 'FGN Savings Bond - Updated',
        ]);
        $offer->save();

        $reloaded = Offer::find($offer->id);
        $this->assertEquals('closed', $reloaded->status);
        $this->assertEquals(5, $reloaded->tenor_years);
        $this->assertEquals('FGN Savings Bond - Updated', $reloaded->offer_title);
        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
            'status' => 'closed',
            'tenor_years' => 5,
        ]);
    }

    /** @test */
    public function it_soft_deletes_an_offer_record()
    {
        $offer = Offer::create($this->offerPayload());
        $id = $offer->id;

        $offer->delete();

        // SoftDeletes: the row remains, but is excluded from default queries
        $this->assertNull(Offer::find($id));
        $this->assertNotNull(Offer::withTrashed()->find($id));
        $this->assertNotNull(Offer::withTrashed()->find($id)->deleted_at);
    }

    /** @test */
    public function it_force_deletes_an_offer_record()
    {
        $offer = Offer::create($this->offerPayload());
        $id = $offer->id;

        $offer->forceDelete();

        $this->assertNull(Offer::withTrashed()->find($id));
        $this->assertDatabaseMissing('sb_offers', ['id' => $id]);
    }
}
