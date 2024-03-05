jQuery(document).ready(function($) {
    // Retrieve the property name from localised variable
    var propertyName = es_php_vars.property_name;
    
    jQuery(".wf-form-wrapper").prepend("<input fvalidate='true' ftype='url' name='POTENTIALCF1' maxlength='255' type='text' value='' class='wf-field-item wf-field-input' style='display:none' oninput='removeError(this)'/>")
    jQuery(".wf-form-wrapper").prepend("<input name='POTENTIALCF3' maxlength='255' type='text' value='' class='wf-field-item wf-field-input' style='display:none'  oninput='removeError(this)'/>")

    // Set the value of the input field to the property name
    var inputField = $("input[name='POTENTIALCF3']");
    inputField.val(propertyName);
    
    // Get Set Url
    var getOrigin = jQuery(location).attr('hostname');
    jQuery("input[name='POTENTIALCF1']").val(getOrigin);

    // Hide the input field container and its label
    var fieldContainer = inputField.closest('.wf-field');
    fieldContainer.hide();
    fieldContainer.prev('.wf-label').hide();


    // alter PMS url
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the user is on a mobile device
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(window.navigator.userAgent);
        }
    
        if (isMobile()) {
            // Get all anchor elements (links) in the document
            let links = document.querySelectorAll('a');
    
            links.forEach(link => {
                let currentUrl = link.href;
    
                // Check if the URL has the structure
                if (/https:\/\/apps.hti-systems.com\/extraordinary\/[a-zA-Z0-9]+\/desktop.html/.test(currentUrl)) {
                    // Replace 'desktop' with 'mobile'
                    let mobileUrl = currentUrl.replace('/desktop.html', '/mobile.html');
                    
                    // Update the link's href
                    link.href = mobileUrl;
                }
            });
        }
    });
    

});