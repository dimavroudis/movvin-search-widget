var inputs = document.getElementsByClassName('movvin-autocomplete-input');

for (var i=0; i<inputs.length; i++){
    initAutocomplete(inputs[i]);
}

function initAutocomplete(input){
    var hiddenInput = input.nextElementSibling;
    var autocomplete = new google.maps.places.Autocomplete(input);
        
    autocomplete.setComponentRestrictions(
        {'country': ['gr']});
        
    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();
        var latlngvalue = place.geometry.location.lat() + "-" + place.geometry.location.lng();
        hiddenInput.value = latlngvalue;
    })
}