jQuery(document).ready(function() {
    if (jQuery('#movvinSearch').length > 0) {
        var inputs = document.getElementsByClassName('movvin-autocomplete-input');
        var datePicker = document.getElementById('movvinDatePicker');
        var movvinDate = document.getElementById('movvinDate');
        var button = document.getElementById('movvinSubmit');

        for (var i = 0; i < inputs.length; i++) {
            initAutocomplete(inputs[i]);
        }

        button.addEventListener("click", function() {
            createMovvinDate();
        });

        jQuery(datePicker).datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0
        });
    }
});

function initAutocomplete(input) {
    var hiddenInputLatlng = input.nextElementSibling;
    var hiddenInputText = hiddenInputLatlng.nextElementSibling;
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.setComponentRestrictions({ 'country': ['gr'] });

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        var latlngvalue = place.geometry.location.lat() + "-" + place.geometry.location.lng();
        var textvalue = place.formatted_address;
        hiddenInputText.value = textvalue;
        hiddenInputLatlng.value = latlngvalue;
    })

    input.addEventListener('change', function() {
        if (input.value == "") {
            hiddenInputLatlng.value = "";
            hiddenInputText.value = "";
        }
    })
}

function createMovvinDate() {
    var currentDate = new Date();
    var selectedDate = jQuery(datePicker).datepicker("getDate").toISOString();
    movvinDate.value = selectedDate.slice(0, 10) + "_" + selectedDate.slice(11, 18);
    console.info(movvinDate.value);
}