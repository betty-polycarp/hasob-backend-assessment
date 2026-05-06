@extends('layouts.app')

@section('app_css')
    {!! $cdv_offers->render_css() !!}
@stop

@section('title_postfix')
Offers
@stop

@section('page_title')
Offers
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a>
@stop

@section('page_title_buttons')
<a id="btn-new-mdl-offer-modal" class="btn btn-primary btn-new-mdl-offer-modal">
    <i class="bx bx-book-add me-1"></i>New Offer
</a>
@if (Auth()->user()->hasAnyRole(['', 'admin']))
    @include('dmo-savings-bond-module::pages.offers.bulk-upload-modal')
@endif
@stop

@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_offers->render() }}
        </div>
    </div>

    @include('dmo-savings-bond-module::pages.offers.modal')
@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">About Bond Offers</h5></div>
        <p class="small mb-2">
            A bond offer represents a savings bond available for subscription by investors during a defined window.
        </p>
        <ul class="small ps-3 mb-0">
            <li>Click <strong>New Offer</strong> to create a record.</li>
            <li>Use <i class="bx bx-show"></i> to view full details and related bids / subscriptions.</li>
            <li>Use <i class="bx bxs-edit"></i> to edit, <i class="bx bxs-trash-alt"></i> to delete.</li>
        </ul>
    </div>
</div>
@stop

@push('page_scripts')
    {!! $cdv_offers->render_js() !!}
@endpush
