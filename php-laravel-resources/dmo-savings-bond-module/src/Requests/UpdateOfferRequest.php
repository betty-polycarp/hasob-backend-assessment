<?php

namespace DMO\SavingsBond\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class UpdateOfferRequest extends AppBaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*

        */
        return [
            'organization_id'        => 'required',
            'display_ordinal'        => 'nullable|integer|min:0|max:365',
            'status'                 => 'required|string|max:50',
            'wf_status'              => 'nullable|max:100',
            'wf_meta_data'           => 'nullable|max:1000',
            'offer_title'            => 'required|string|max:255',
            'price_per_unit'         => 'required|numeric|min:0|max:100000000',
            'max_units_per_investor' => 'required|integer|min:1|max:1000000000',
            'interest_rate_pct'      => 'required|numeric|min:0|max:100',
            'offer_start_date'       => 'required|date',
            'offer_end_date'         => 'required|date|after_or_equal:offer_start_date',
            'offer_settlement_date'  => 'required|date|after_or_equal:offer_end_date',
            'offer_maturity_date'    => 'required|date|after_or_equal:offer_settlement_date',
            'tenor_years'            => 'nullable|integer|min:0|max:100',
        ];
    }
}
