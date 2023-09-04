jQuery(document).ready(function($) {
    // Retrieve the property name from localized variable
    var propertyName = es_php_vars.property_name;

    // Set the value of the input field to the property name
    var inputField = $("input[name='POTENTIALCF3']");
    inputField.val(propertyName);

    // Hide the input field container and its label
    var fieldContainer = inputField.closest('.wf-field');
    fieldContainer.hide();
    fieldContainer.prev('.wf-label').hide();
});
