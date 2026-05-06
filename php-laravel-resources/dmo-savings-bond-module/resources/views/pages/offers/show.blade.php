@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
{{ $offer->offer_title ?? 'Offer Details' }}
@stop

@section('page_title')
{{ $offer->offer_title ?? 'Offer Details' }}
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('sb.offers.index') }}">
    <i class="bx bx-chevron-left"></i> Back to Offers
</a>
@stop

@section('page_title_buttons')
    <a data-toggle="tooltip"
        title="Edit"
        data-val='{{ $id }}'
        class="btn btn-outline-primary btn-edit-mdl-offer-modal" href="#">
        <i class="bx bxs-edit me-1"></i> Edit
    </a>

    <a data-toggle="tooltip"
        title="Delete"
        data-val='{{ $id }}'
        class="btn btn-outline-danger btn-delete-mdl-offer-modal ms-2" href="#">
        <i class="bx bxs-trash-alt me-1"></i> Delete
    </a>
@stop

@section('content')

    {{-- Offer details --}}
    <div class="card border-top border-0 border-4 border-primary mb-3">
        <div class="card-body">
            @include('dmo-savings-bond-module::pages.offers.show_fields')
        </div>
    </div>

    {{-- Bids on this offer --}}
    <div class="card border-top border-0 border-4 border-info mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="card-title mb-0">Bids</h5>
                <span class="badge bg-info ms-2">{{ $offer->bids->count() }}</span>
            </div>

            @if ($offer->bids->isEmpty())
                <p class="text-muted small mb-0">No bids have been placed against this offer.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Price / Unit</th>
                                <th class="text-end">Total Price</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offer->bids as $bid)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $bid->status ?? '—' }}</span></td>
                                    <td class="text-end">{{ isset($bid->price_per_unit) ? number_format((float) $bid->price_per_unit, 2) : '—' }}</td>
                                    <td class="text-end">{{ isset($bid->total_price) ? number_format((float) $bid->total_price, 2) : '—' }}</td>
                                    <td>{{ $bid->created_at ? \Carbon\Carbon::parse($bid->created_at)->format('jS M Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Subscriptions on this offer --}}
    <div class="card border-top border-0 border-4 border-success mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="card-title mb-0">Subscriptions</h5>
                <span class="badge bg-success ms-2">{{ $offer->subscriptions->count() }}</span>
            </div>

            @if ($offer->subscriptions->isEmpty())
                <p class="text-muted small mb-0">No investor has subscribed to this offer yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Investor</th>
                                <th>Broker</th>
                                <th>Status</th>
                                <th class="text-end">Total Price</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offer->subscriptions as $sub)
                                <tr>
                                    <td>
                                        {{ trim(($sub->first_name ?? '') . ' ' . ($sub->last_name ?? '')) ?: '—' }}
                                        @if (!empty($sub->investor_email))
                                            <div class="text-muted small">{{ $sub->investor_email }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $sub->broker_name ?? '—' }}</td>
                                    <td><span class="badge bg-secondary">{{ $sub->status ?? '—' }}</span></td>
                                    <td class="text-end">{{ isset($sub->total_price) ? number_format((float) $sub->total_price, 2) : '—' }}</td>
                                    <td>{{ $sub->created_at ? \Carbon\Carbon::parse($sub->created_at)->format('jS M Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @include('dmo-savings-bond-module::pages.offers.modal')
@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">Summary</h5></div>
        <ul class="list-unstyled small mb-0">
            <li class="d-flex justify-content-between py-1">
                <span class="text-muted">Bids</span>
                <strong>{{ $offer->bids->count() }}</strong>
            </li>
            <li class="d-flex justify-content-between py-1">
                <span class="text-muted">Subscriptions</span>
                <strong>{{ $offer->subscriptions->count() }}</strong>
            </li>
            <li class="d-flex justify-content-between py-1">
                <span class="text-muted">Created</span>
                <span>{{ $offer->created_at ? \Carbon\Carbon::parse($offer->created_at)->diffForHumans() : '—' }}</span>
            </li>
            <li class="d-flex justify-content-between py-1">
                <span class="text-muted">Updated</span>
                <span>{{ $offer->updated_at ? \Carbon\Carbon::parse($offer->updated_at)->diffForHumans() : '—' }}</span>
            </li>
        </ul>
    </div>
</div>
@stop

@push('page_scripts')
@endpush
