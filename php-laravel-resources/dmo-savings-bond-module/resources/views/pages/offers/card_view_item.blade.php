@php
    $detail_page_url = route('sb.offers.show', $data_item->id);

    $statusKey = is_string($data_item->status) ? strtolower($data_item->status) : '';
    $statusBadgeMap = [
        'open'      => 'success',
        'draft'     => 'secondary',
        'closed'    => 'warning',
        'settled'   => 'info',
        'matured'   => 'primary',
        'cancelled' => 'danger',
    ];
    $statusBadge = $statusBadgeMap[$statusKey] ?? 'secondary';
@endphp

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-start">

            <div class="me-3 d-none d-md-block">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;">
                    <i class="bx bx-trending-up fs-3 text-primary"></i>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-1">
                    <h5 class="card-title mb-0">
                        <a href="{{ $detail_page_url }}" class="text-decoration-none">
                            {{ $data_item->offer_title ?: 'Untitled offer' }}
                        </a>
                    </h5>
                    <span class="badge bg-{{ $statusBadge }} ms-2">{{ $data_item->status ?: 'unknown' }}</span>

                    <div class="ms-auto">
                        <a data-toggle="tooltip"
                            title="View"
                            href="{{ $detail_page_url }}"
                            class="inline-block me-2">
                            <i class="bx bx-show text-primary" style="opacity:80%"></i>
                        </a>

                        <a data-toggle="tooltip"
                            title="Edit"
                            data-val='{{ $data_item->id }}'
                            class="btn-edit-mdl-offer-modal inline-block me-2" href="#">
                            <i class="bx bxs-edit text-warning" style="opacity:80%"></i>
                        </a>

                        <a data-toggle="tooltip"
                            title="Delete"
                            data-val='{{ $data_item->id }}'
                            class="btn-delete-mdl-offer-modal inline-block" href="#">
                            <i class="bx bxs-trash-alt text-danger" style="opacity:80%"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-2 small text-muted mt-1">
                    <div class="col-md-3">
                        <span class="d-block text-uppercase" style="font-size:10px;letter-spacing:.5px;">Price / Unit</span>
                        <span class="text-dark">
                            {{ isset($data_item->price_per_unit) ? number_format((float) $data_item->price_per_unit, 2) : '—' }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block text-uppercase" style="font-size:10px;letter-spacing:.5px;">Interest</span>
                        <span class="text-dark">
                            {{ isset($data_item->interest_rate_pct) ? number_format((float) $data_item->interest_rate_pct, 2) . '%' : '—' }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block text-uppercase" style="font-size:10px;letter-spacing:.5px;">Tenor</span>
                        <span class="text-dark">
                            @if (isset($data_item->tenor_years) && $data_item->tenor_years !== '')
                                {{ $data_item->tenor_years }} yr{{ ((int) $data_item->tenor_years) === 1 ? '' : 's' }}
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    <div class="col-md-3">
                        <span class="d-block text-uppercase" style="font-size:10px;letter-spacing:.5px;">Window</span>
                        <span class="text-dark">
                            {{ !empty($data_item->offer_start_date) ? \Carbon\Carbon::parse($data_item->offer_start_date)->format('j M') : '—' }}
                            &rarr;
                            {{ !empty($data_item->offer_end_date) ? \Carbon\Carbon::parse($data_item->offer_end_date)->format('j M Y') : '—' }}
                        </span>
                    </div>
                </div>

                <p class="card-text mt-2 mb-0">
                    <small class="text-muted">
                        Created {!! \Carbon\Carbon::parse($data_item->created_at)->diffForHumans() !!}
                    </small>
                </p>
            </div>

        </div>
    </div>
</div>
