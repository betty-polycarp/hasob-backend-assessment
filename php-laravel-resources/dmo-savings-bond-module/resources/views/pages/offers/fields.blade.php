<div class="row">
    <!-- Status Field -->
    <div id="div-status" class="col-md-6 mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        {!! Form::select('status', [
            'draft'    => 'Draft',
            'open'     => 'Open',
            'closed'   => 'Closed',
            'settled'  => 'Settled',
            'matured'  => 'Matured',
            'cancelled'=> 'Cancelled',
        ], null, ['id' => 'status', 'class' => 'form-select', 'placeholder' => '— Select status —']) !!}
    </div>

    <!-- Offer Title Field -->
    <div id="div-offer_title" class="col-md-12 mb-3">
        <label for="offer_title" class="form-label">Offer Title <span class="text-danger">*</span></label>
        {!! Form::text('offer_title', null, ['id' => 'offer_title', 'class' => 'form-control', 'placeholder' => 'e.g. FGN Savings Bond - March 2026', 'maxlength' => 255]) !!}
    </div>

    <!-- Price Per Unit Field -->
    <div id="div-price_per_unit" class="col-md-4 mb-3">
        <label for="price_per_unit" class="form-label">Price Per Unit <span class="text-danger">*</span></label>
        {!! Form::number('price_per_unit', null, ['id' => 'price_per_unit', 'class' => 'form-control', 'min' => 0, 'max' => 100000000, 'step' => '0.01']) !!}
    </div>

    <!-- Max Units Per Investor Field -->
    <div id="div-max_units_per_investor" class="col-md-4 mb-3">
        <label for="max_units_per_investor" class="form-label">Max Units Per Investor <span class="text-danger">*</span></label>
        {!! Form::number('max_units_per_investor', null, ['id' => 'max_units_per_investor', 'class' => 'form-control', 'min' => 1, 'max' => 1000000000, 'step' => 1]) !!}
    </div>

    <!-- Interest Rate Pct Field -->
    <div id="div-interest_rate_pct" class="col-md-4 mb-3">
        <label for="interest_rate_pct" class="form-label">Interest Rate Pct <span class="text-danger">*</span></label>
        {!! Form::number('interest_rate_pct', null, ['id' => 'interest_rate_pct', 'class' => 'form-control', 'min' => 0, 'max' => 100, 'step' => '0.01']) !!}
    </div>

    <!-- Offer Start Date Field -->
    <div id="div-offer_start_date" class="col-md-6 mb-3">
        <label for="offer_start_date" class="form-label">Offer Start Date <span class="text-danger">*</span></label>
        {!! Form::date('offer_start_date', null, ['id' => 'offer_start_date', 'class' => 'form-control']) !!}
    </div>

    <!-- Offer End Date Field -->
    <div id="div-offer_end_date" class="col-md-6 mb-3">
        <label for="offer_end_date" class="form-label">Offer End Date <span class="text-danger">*</span></label>
        {!! Form::date('offer_end_date', null, ['id' => 'offer_end_date', 'class' => 'form-control']) !!}
    </div>

    <!-- Offer Settlement Date Field -->
    <div id="div-offer_settlement_date" class="col-md-6 mb-3">
        <label for="offer_settlement_date" class="form-label">Offer Settlement Date <span class="text-danger">*</span></label>
        {!! Form::date('offer_settlement_date', null, ['id' => 'offer_settlement_date', 'class' => 'form-control']) !!}
    </div>

    <!-- Offer Maturity Date Field -->
    <div id="div-offer_maturity_date" class="col-md-6 mb-3">
        <label for="offer_maturity_date" class="form-label">Offer Maturity Date <span class="text-danger">*</span></label>
        {!! Form::date('offer_maturity_date', null, ['id' => 'offer_maturity_date', 'class' => 'form-control']) !!}
    </div>

    <!-- Tenor Years Field -->
    <div id="div-tenor_years" class="col-md-6 mb-3">
        <label for="tenor_years" class="form-label">Tenor Years</label>
        {!! Form::number('tenor_years', null, ['id' => 'tenor_years', 'class' => 'form-control', 'min' => 0, 'max' => 100, 'step' => 1]) !!}
    </div>

</div>
