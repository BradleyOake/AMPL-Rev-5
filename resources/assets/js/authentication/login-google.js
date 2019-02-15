/*
 *  Filename: login-google.js
 *  ---------------------------------------
 *
 *  Author: Thomas Davison
 *  Date: Jan 27, 2016
 *  Description: This script gets a token from google after a user logins and submits it to the server to be used by the backend
 *
 */


var googleUser = {};

// Initalize the sign in settings
var startApp = function () {
    gapi.load('auth2', function () {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '61758773854-t25ukdlf334hen4po09k5sju4v3ds4gg.apps.googleusercontent.com',
        });

        attachSignin(document.getElementById('btn-google'));
    });
};

// Attach sign in to button
function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function (googleUser) {
            onSignIn(googleUser); // Call the Onsign in function
        },
        function (error) {
            alert(JSON.stringify(error, undefined, 2));
        });
}

// On succesfull sign in
function onSignIn(googleUser) {

    access_token = googleUser.getAuthResponse().id_token; //get access token
    console.log('Token: ' + access_token);
    $.ajax({
        type: "POST",
        url: base_url + '/auth/google',
        dataType: 'json',
        data: {
            token: access_token
        },
        timeout: 5000, // timeout set to 5 seconds
        success: function (data) {

            console.log(data.message);
            if (data.valid === 'true') {

                window.location.reload();
                closeAllDialogs();
                displaySuccessDialog();

            } else {

                console.log(data);
                closeAllDialogs();
                $('#login_modal').modal('show');

            }
        },
        error: function (xhr, status, error) {

            console.log(error);
            closeAllDialogs();
            $("#login_error").removeClass("hidden").addClass("visible");
            $('#login_error').html('<i class="fa fa-exclamation-triangle"></i> Error: ' + error);
            $('#login_modal').modal('show');

        },
        beforeSend: function () {

            console.log('Submitting token to server.');
            $('#login_modal').modal('hide');
            displayLoadingDialog();

        }
    });

}


// Sign out of google
function google_logout() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out of google on app.');
    });
}
// Start app
startApp();
