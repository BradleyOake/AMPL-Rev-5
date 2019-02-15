/*
 *  Filename: login-facebook.js
 *  ---------------------------------------
 *
 *  Author: Thomas Davison
 *  Date: Jan 27, 2016
 *  Description: This script gets a token from facebook after a user logins and submits it to the server to be used by the backend
 *
 */


window.fbAsyncInit = function () {
    FB.init({
        appId: '726168714129895',
        xfbml: true,
        version: 'v2.2'
    });


    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            //console.log(response.authResponse.accessToken);
            // Logged into your app and Facebook.
            console.log('Logged into app and Facebook');
        } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            console.log('Logged into Facebook, but not app');
        } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            console.log('Not logged into Facebook, so we\'re not sure if they are logged into this app');
        }
    });
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fb_login() {

    FB.login(function (response) {

        if (response.authResponse) {

            access_token = response.authResponse.accessToken; //get access token

            console.log('Token: ' + access_token);
            FB.api('/me', function (response) {
                $.ajax({
                    type: "POST",
                    url: base_url + '/auth/facebook',
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
            });

        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    }, {
        scope: 'email,public_profile'
    });

}

/*
 *  fb_logout()
 *  ---------------------------------------
 *
 *  Signs the user our of facebook
 *
 */

function fb_logout() {
    FB.logout(function (response) {
        console.log('User signed out of facebook.');
    });
}
