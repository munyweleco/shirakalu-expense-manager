// File: web/js/payment-form.js

/*
 * Function: updateAmount
 * Description: This function computes the total payment amount based on the rate and acres input fields.
 * It updates the 'amount' field with the calculated value.
 */
function updateAmount() {
    const rate = parseFloat($('#payment-rate').val()) || 0; // Get the rate value or default to 0 if empty
    const acres = parseFloat($('#payment-acres').val()) || 0; // Get the acres value or default to 0 if empty
    const amount = rate * acres; // Calculate the total amount
    $('#payment-amount').val(amount.toFixed(2)); // Update the amount field with the calculated value (fixed to 2 decimal places)
}

/*
 * Function: fetchRate
 * Description: This function performs an AJAX request to fetch the rate based on the selected operation and staff.
 * It updates the 'rate' field with the fetched value and calls updateAmount() to update the 'amount' field.
 */
function fetchRate() {
    $.ajax({
        url: '/payment/get-rate', // Replace with the correct URL for fetching the rate
        type: 'POST',
        data: {
            operation_id: $('#operation-id').val(), // Send selected operation ID
            staff_id: $('#staff-id').val() // Send selected staff ID
        },
        success: function (data) {
            $('#payment-rate').val(data.rate); // Update the rate field with the fetched rate
            updateAmount(); // Update the amount field after setting the rate
        }
    });
}

/*
 * Event: Checkbox Change - Custom Rate
 * Description: Toggles between using a custom rate and a predefined rate.
 * If custom rate is unchecked, fetches the predefined rate based on selected operation and staff.
 */
$('#use-custom-rate').change(function () {
    const isChecked = $(this).is(':checked'); // Check if the custom rate checkbox is checked
    $('#payment-rate').prop('readonly', !isChecked); // Toggle the readonly property of the rate field
    if (!isChecked) {
        fetchRate();
    }
});

/*
 * Event: DepDrop Change - Operation ID
 * Description: Fetches the rate when the operation ID changes, provided the custom rate checkbox is not checked.
 */
$('#operation-id').on('depdrop:afterChange', function (event, id, value) {
    if (!$('#use-custom-rate').is(':checked')) {
        fetchRate(); // Fetch the rate based on the selected operation and staff
    }
});

/*
 * Event: Input Change - Rate or Acres
 * Description: Updates the amount field whenever the rate or acres fields are modified.
 */
$('#payment-acres, #payment-rate').on('input', function () {
    updateAmount(); // Recalculate and update the amount field based on the new values
});