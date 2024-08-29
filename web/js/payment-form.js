// File: web/js/payment-form.js

/**
 * Updates the total payment amount based on the rate and acres input fields.
 * It calculates the amount and updates the 'amount' field.
 */
function updateAmount() {
    const rate = parseFloat($('#payment-rate').val()) || 0;
    const acres = parseFloat($('#payment-acres').val()) || 0;
    const amount = rate * acres;
    $('#payment-amount').val(amount.toFixed(2));
}

/**
 * Fetches the rate based on the selected operation and staff.
 * The 'rate' field is updated with the fetched value, and the 'amount' field is recalculated.
 */
function fetchRate() {
    const operationId = $('#operation-id').val();
    const staffId = $('#staff-id').val();

    if (operationId && staffId) {
        $.ajax({
            url: '/payment/get-rate',
            type: 'POST',
            data: {operation_id: operationId, staff_id: staffId},
            success: function (response) {
                if (response && response.rate !== undefined) {
                    $('#payment-rate').val(response.rate);
                    updateAmount();
                } else {
                    console.error('Invalid response:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching rate:', status, error);
            }
        });
    } else {
        console.warn('Operation ID or Staff ID is missing.');
    }
}

/**
 * Toggles between using a custom rate and a predefined rate.
 * If custom rate is unchecked, fetches the predefined rate based on selected operation and staff.
 */
$('#use-custom-rate').change(function () {
    const useCustomRate = $(this).is(':checked');
    $('#payment-rate').prop('readonly', !useCustomRate);

    if (!useCustomRate) {
        fetchRate();
    }
});

/**
 * Fetches the rate when the operation ID changes, provided the custom rate checkbox is not checked.
 */
$('#operation-id').on('change', function (event) {
    const useCustomRate = $('#use-custom-rate').is(':checked');
    if (useCustomRate === false) {
        fetchRate();
    }
});

/**
 * Recalculates and updates the amount field whenever the rate or acres fields are modified.
 */
$('#payment-acres, #payment-rate').on('input', updateAmount);
