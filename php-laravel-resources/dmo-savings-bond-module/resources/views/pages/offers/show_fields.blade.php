@php
    $statusBadge = function ($status) {
        $map = [
            'open'      => 'success',
            'draft'     => 'secondary',
            'closed'    => 'warning',
            'settled'   => 'info',
            'matured'   => 'primary',
            'cancelled' => 'danger',
        ];
        $key = is_string($status) ? strtolower($status) : '';
        return $map[$key] ?? 'secondary';
    };
@endphp

<div class="row g-3">

    <!-- Offer Title -->
    <div id="div_offer_offer_title" class="col-md-12">
        <label class="form-label text-muted small mb-1">Offer Title</label>
        <div class="fw-semibold fs-5" id="spn_offer_offer_title">
            {{ $offer->offer_title ?? 'N/A' }}
        </div>
    </div>

    <!-- Status -->
    <div id="div_offer_status" class="col-md-6">
        <label class="form-label text-muted small mb-1">Status</label>
        <div>
            <span id="spn_offer_status" class="badge bg-{{ $statusBadge($offer->status ?? null) }}">
                {{ $offer->status ?? 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Tenor -->
    <div id="div_offer_tenor_years" class="col-md-6">
        <label class="form-label text-muted small mb-1">Tenor</label>
        <div>
            <span id="spn_offer_tenor_years">{{ $offer->tenor_years ?? 'N/A' }}</span>
            @if (isset($offer->tenor_years) && $offer->tenor_years !== '')
                year{{ ((int) $offer->tenor_years) === 1 ? '' : 's' }}
            @endif
        </div>
    </div>

    <!-- Price per unit -->
    <div id="div_offer_price_per_unit" class="col-md-4">
        <label class="form-label text-muted small mb-1">Price Per Unit</label>
        <div>
            <span id="spn_offer_price_per_unit">
                {{ isset($offer->price_per_unit) ? number_format((float) $offer->price_per_unit, 2) : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Max units per investor -->
    <div id="div_offer_max_units_per_investor" class="col-md-4">
        <label class="form-label text-muted small mb-1">Max Units / Investor</label>
        <div>
            <span id="spn_offer_max_units_per_investor">
                {{ isset($offer->max_units_per_investor) ? number_format((int) $offer->max_units_per_investor) : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Interest rate -->
    <div id="div_offer_interest_rate_pct" class="col-md-4">
        <label class="form-label text-muted small mb-1">Interest Rate</label>
        <div>
            <span id="spn_offer_interest_rate_pct">
                {{ isset($offer->interest_rate_pct) ? number_format((float) $offer->interest_rate_pct, 2) . '%' : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Start date -->
    <div id="div_offer_offer_start_date" class="col-md-6">
        <label class="form-label text-muted small mb-1">Offer Start Date</label>
        <div>
            <span id="spn_offer_offer_start_date">
                {{ !empty($offer->offer_start_date) ? \Carbon\Carbon::parse($offer->offer_start_date)->format('jS M Y') : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- End date -->
    <div id="div_offer_offer_end_date" class="col-md-6">
        <label class="form-label text-muted small mb-1">Offer End Date</label>
        <div>
            <span id="spn_offer_offer_end_date">
                {{ !empty($offer->offer_end_date) ? \Carbon\Carbon::parse($offer->offer_end_date)->format('jS M Y') : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Settlement date -->
    <div id="div_offer_offer_settlement_date" class="col-md-6">
        <label class="form-label text-muted small mb-1">Settlement Date</label>
        <div>
            <span id="spn_offer_offer_settlement_date">
                {{ !empty($offer->offer_settlement_date) ? \Carbon\Carbon::parse($offer->offer_settlement_date)->format('jS M Y') : 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Maturity date -->
    <div id="div_offer_offer_maturity_date" class="col-md-6">
        <label class="form-label text-muted small mb-1">Maturity Date</label>
        <div>
            <span id="spn_offer_offer_maturity_date">
                {{ !empty($offer->offer_maturity_date) ? \Carbon\Carbon::parse($offer->offer_maturity_date)->format('jS M Y') : 'N/A' }}
            </span>
        </div>
    </div>

</div>
