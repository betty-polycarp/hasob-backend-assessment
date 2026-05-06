<div class="modal fade" id="mdl-offer-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-offer-modal-title" class="modal-title">Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div id="div-offer-modal-error" class="alert alert-danger d-none" role="alert"></div>

                <div id="alert-offer-offline" class="alert alert-warning d-none" role="alert">
                    You are currently offline. Please reconnect and try again.
                </div>

                <div id="spinner-offers" class="spinner-border text-primary d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <form class="form-horizontal" id="frm-offer-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    @csrf

                    <input type="hidden" id="txt-offer-primary-id" value="0" />

                    <div id="div-show-txt-offer-primary-id" class="d-none">
                        @include('dmo-savings-bond-module::pages.offers.show_fields', ['offer' => null])
                    </div>

                    <div id="div-edit-txt-offer-primary-id">
                        @include('dmo-savings-bond-module::pages.offers.fields')
                    </div>
                </form>
            </div>

            <div class="modal-footer" id="div-save-mdl-offer-modal">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-save-mdl-offer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function () {

    // helper: slice "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DD" so it fits <input type="date">
    function toDateInput(value) {
        if (!value) return '';
        return String(value).substring(0, 10);
    }

    function setOfferModalMode(mode) {
        $('#div-offer-modal-error').addClass('d-none').empty();

        if (mode === 'view') {
            $('#lbl-offer-modal-title').text('Offer Details');
            $('#div-show-txt-offer-primary-id').removeClass('d-none');
            $('#div-edit-txt-offer-primary-id').addClass('d-none');
            $('#btn-save-mdl-offer-modal').addClass('d-none');
        } else if (mode === 'edit') {
            $('#lbl-offer-modal-title').text('Edit Offer');
            $('#div-show-txt-offer-primary-id').addClass('d-none');
            $('#div-edit-txt-offer-primary-id').removeClass('d-none');
            $('#btn-save-mdl-offer-modal').removeClass('d-none');
        } else {
            $('#lbl-offer-modal-title').text('New Offer');
            $('#div-show-txt-offer-primary-id').addClass('d-none');
            $('#div-edit-txt-offer-primary-id').removeClass('d-none');
            $('#btn-save-mdl-offer-modal').removeClass('d-none');
        }
    }

    function checkOnline() {
        if (!window.navigator.onLine) {
            $('#alert-offer-offline').removeClass('d-none');
            return false;
        }
        $('#alert-offer-offline').addClass('d-none');
        return true;
    }

    // ---- New ----
    $(document).on('click', '.btn-new-mdl-offer-modal', function () {
        $('#frm-offer-modal').trigger('reset');
        $('#txt-offer-primary-id').val(0);
        setOfferModalMode('new');
        $('#spinner-offers').addClass('d-none');
        $('#mdl-offer-modal').modal('show');
    });

    // ---- View (read-only) ----
    $(document).on('click', '.btn-show-mdl-offer-modal', function (e) {
        e.preventDefault();
        if (!checkOnline()) return;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() } });
        $('#frm-offer-modal').trigger('reset');
        setOfferModalMode('view');
        $('#spinner-offers').removeClass('d-none');
        $('#mdl-offer-modal').modal('show');

        let itemId = $(this).attr('data-val');

        $.get("{{ route('sb-api.offers.show', '') }}/" + itemId).done(function (response) {
            $('#txt-offer-primary-id').val(response.data.id);
            $('#spn_offer_status').text(response.data.status || 'N/A');
            $('#spn_offer_offer_title').text(response.data.offer_title || 'N/A');
            $('#spn_offer_price_per_unit').text(response.data.price_per_unit ?? 'N/A');
            $('#spn_offer_max_units_per_investor').text(response.data.max_units_per_investor ?? 'N/A');
            $('#spn_offer_interest_rate_pct').text(response.data.interest_rate_pct ?? 'N/A');
            $('#spn_offer_offer_start_date').text(toDateInput(response.data.offer_start_date) || 'N/A');
            $('#spn_offer_offer_end_date').text(toDateInput(response.data.offer_end_date) || 'N/A');
            $('#spn_offer_offer_settlement_date').text(toDateInput(response.data.offer_settlement_date) || 'N/A');
            $('#spn_offer_offer_maturity_date').text(toDateInput(response.data.offer_maturity_date) || 'N/A');
            $('#spn_offer_tenor_years').text(response.data.tenor_years ?? 'N/A');

            $('#spinner-offers').addClass('d-none');
        });
    });

    // ---- Edit ----
    $(document).on('click', '.btn-edit-mdl-offer-modal', function (e) {
        e.preventDefault();
        if (!checkOnline()) return;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() } });
        $('#frm-offer-modal').trigger('reset');
        setOfferModalMode('edit');
        $('#spinner-offers').removeClass('d-none');
        $('#mdl-offer-modal').modal('show');

        let itemId = $(this).attr('data-val');

        $.get("{{ route('sb-api.offers.show', '') }}/" + itemId).done(function (response) {
            $('#txt-offer-primary-id').val(response.data.id);
            $('#status').val(response.data.status);
            $('#offer_title').val(response.data.offer_title);
            $('#price_per_unit').val(response.data.price_per_unit);
            $('#max_units_per_investor').val(response.data.max_units_per_investor);
            $('#interest_rate_pct').val(response.data.interest_rate_pct);
            $('#offer_start_date').val(toDateInput(response.data.offer_start_date));
            $('#offer_end_date').val(toDateInput(response.data.offer_end_date));
            $('#offer_settlement_date').val(toDateInput(response.data.offer_settlement_date));
            $('#offer_maturity_date').val(toDateInput(response.data.offer_maturity_date));
            $('#tenor_years').val(response.data.tenor_years);

            $('#spinner-offers').addClass('d-none');
        });
    });

    // ---- Delete ----
    $(document).on('click', '.btn-delete-mdl-offer-modal', function (e) {
        e.preventDefault();
        if (!checkOnline()) return;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() } });
        let itemId = $(this).attr('data-val');

        swal({
            title: 'Are you sure you want to delete this Offer?',
            text: 'You will not be able to recover this Offer if deleted.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (!isConfirm) return;

            let endPointUrl = "{{ route('sb-api.offers.destroy', '') }}/" + itemId;
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', 'DELETE');

            $.ajax({
                url: endPointUrl,
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (result) {
                    if (result.errors) {
                        swal('Error', 'Oops an error occurred. Please try again.', 'error');
                    } else {
                        swal({
                            title: 'Deleted',
                            text: 'Offer deleted successfully',
                            type: 'success',
                            confirmButtonClass: 'btn-success',
                            confirmButtonText: 'OK',
                            closeOnConfirm: false
                        }, function () { location.reload(true); });
                    }
                }
            });
        });
    });

    // ---- Save (create or update) ----
    $('#btn-save-mdl-offer-modal').click(function (e) {
        e.preventDefault();
        if (!checkOnline()) return;

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() } });
        $('#spinner-offers').removeClass('d-none');
        $('#btn-save-mdl-offer-modal').prop('disabled', true);

        let primaryId   = $('#txt-offer-primary-id').val();
        let isUpdate    = primaryId !== '0' && primaryId !== 0 && primaryId !== '';
        let actionType  = isUpdate ? 'PUT' : 'POST';
        let endPointUrl = isUpdate
            ? "{{ route('sb-api.offers.update', '') }}/" + primaryId
            : "{{ route('sb-api.offers.store') }}";

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        if (isUpdate) {
            formData.append('id', primaryId);
        }

        @if (isset($organization) && $organization != null)
            formData.append('organization_id', '{{ $organization->id }}');
        @endif

        formData.append('status', $('#status').val());
        formData.append('offer_title', $('#offer_title').val());
        formData.append('price_per_unit', $('#price_per_unit').val());
        formData.append('max_units_per_investor', $('#max_units_per_investor').val());
        formData.append('interest_rate_pct', $('#interest_rate_pct').val());
        formData.append('offer_start_date', $('#offer_start_date').val());
        formData.append('offer_end_date', $('#offer_end_date').val());
        formData.append('offer_settlement_date', $('#offer_settlement_date').val());
        formData.append('offer_maturity_date', $('#offer_maturity_date').val());
        formData.append('tenor_years', $('#tenor_years').val());

        $.ajax({
            url: endPointUrl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (result) {
                $('#spinner-offers').addClass('d-none');
                $('#btn-save-mdl-offer-modal').prop('disabled', false);

                if (result.errors) {
                    let $err = $('#div-offer-modal-error').empty().removeClass('d-none');
                    $.each(result.errors, function (key, value) {
                        $err.append('<li>' + value + '</li>');
                    });
                } else {
                    $('#div-offer-modal-error').addClass('d-none');
                    swal({
                        title: 'Saved',
                        text: 'Offer saved successfully',
                        type: 'success',
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: 'btn-success',
                        confirmButtonText: 'OK'
                    }, function () { location.reload(true); });
                }
            },
            error: function (xhr) {
                console.log(xhr);
                $('#spinner-offers').addClass('d-none');
                $('#btn-save-mdl-offer-modal').prop('disabled', false);

                // Surface Laravel 422 validation errors as a list inside the modal
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let $err = $('#div-offer-modal-error').empty().removeClass('d-none');
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function (field) {
                        (errors[field] || []).forEach(function (msg) {
                            $err.append('<div>' + msg + '</div>');
                        });
                    });
                    return;
                }

                let detail = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error))
                    || xhr.statusText
                    || 'Unknown error';
                swal('Error ' + xhr.status, detail, 'error');
            }
        });
    });

});
</script>
@endpush
