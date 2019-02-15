// Inserts CSRF token onto each page
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
    }
});

// Auto clicks java link un url
$(document).ready(function () {

    var tabId = window.location.hash; // will look something like "#h-02"
    console.log(tabId);
    $(tabId).click(); // after you've bound your click listener
});

// Used for all ajax urls
var base_url = 'http://localhost';
