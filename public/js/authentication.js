//reset password]
$(document).ready(function () {
    $('#password_Form').bootstrapValidator({

            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required'
                        },
                        
                        remote: {
                            message: 'That email is not registered',
                            url: base_url + "/auth/emailExist",
                            type: 'POST'
                        },

                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        }
                    }
                },           
            },
        })
        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            email = $("#email").val();
           
            $.ajax({
                type: "POST",
                url: base_url + "/email/resetPassword",                 
                dataType: 'json', // expected returned data format.
                data: {
                    
                    email: email,
                  
                },
                //timeout: 5000, // timeout set to 5 seconds
                success: function (data) {
                    console.log(data.message);

                    if (data.valid === 'true') {
                        location.reload();
                        closeAllDialogs();
                        displaySuccessDialog();
                    } else {
                        console.log(data);
                        $("#register_error").removeClass("hidden").addClass("visible");
                        $('#register_error').html('<i class="fa fa-exclamation-triangle"></i> An error has occured. Please try again.');

                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    closeAllDialogs();
                    $("#register_error").removeClass("hidden").addClass("visible");
                    $('#register_error').html('<i class="fa fa-exclamation-triangle"></i> Error: ' + error);
                }
            });
   
            return false;
        });
});

/*
 *  Filename: login-email.js
 *  ---------------------------------------
 *
 *  Author: Thomas Davison
 *  Date: Jan 27, 2016
 *  Description: This script handles the form submission for the login-form located in the login modal
 *
 *  Fields: login_form_email, login_form_password, login_form_remember
 *
 */

$(document).ready(function () {
    $('#login_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        excluded: [':disabled'],
        fields: {

            login_form_email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
                }
            },

            login_form_password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    },
                    stringLength: {
                        min: 6,
                        message: 'Must be at least 6 characters'
                    }
                }
            }
        }
    })

    .on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();
        // Get the form instance
        var $form = $(e.target);
        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');

        email = $("#login_form_email").val();
        password = $("#login_form_password").val();
        remember_me = $("#login_form_remember").val();

        $.ajax({
            type: "post",
            url: base_url + "/auth/login",
            dataType: 'json', // expected returned data format.
            data: {
                email: email,
                password: password,
                remember_me: remember_me,
            },
            timeout: 5000, // timeout set to 5 seconds
            success: function (data) {
                closeAllDialogs();

                console.log('login-email: ' + data.message);
                if (data.valid === 'true') {
                    window.location.reload();
                    displaySuccessDialog();
                } else {
                    $('#login_form').data('bootstrapValidator').resetForm();
                    console.log('login-email data.valid != true: ' + data);

                    $("#login_error").removeClass("hidden").addClass("visible");
                    $('#login_error').html('<i class="fa fa-exclamation-triangle"></i> You have entered an incorrect password');

                    $('#login_form').data('bootstrapValidator').resetForm();
                    $("#login_form_password").val(null);
                    $('#login_modal').modal('show');
                    console.log('login-email data.valid != true END');
                }
            },
            error: function (xhr, status, error) {
                console.log('login-email error: ' + error);
                closeAllDialogs();
                $("#login_error").removeClass("hidden").addClass("visible");
                $('#login_error').html('<i class="fa fa-exclamation-triangle"></i> Error: ' + error);
                $('#login_modal').modal('show');
            },
            beforeSend: function () {
                console.log('login-email: Submitting token to server.');
                //$('#login_modal').modal('hide'); Keeps the form hidden, even after .modal('show') is run 
                displayLoadingDialog();
            }
        });
        return false;

    });
});

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

// Validation for the registraion part of the modal
$(document).ready(function () {
    $('#register_form').bootstrapValidator({

            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                register_email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required'
                        },

                        remote: {
                            message: 'That email is already registered',
                            url: base_url + "/auth/emailCheck",
                            type: 'POST'
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        }
                    }
                },
                register_first: {
                    validators: {
                        notEmpty: {
                            message: 'First name is required'
                        },
                        regexp: {
                            regexp: /^[-'a-zA-Z\s]+$/,
                            message: 'Must contain only alpbabetical characters, \', and \-'
                        }
                    }
                },
                register_last: {
                    validators: {
                        notEmpty: {
                            message: 'Last name is required'
                        },
                        regexp: {
                            regexp: /^[-'a-zA-Z\s]+$/,
                            message: 'Must contain only alpbabetical characters, \', and \-'
                        }
                    }
                },

                register_confirm: {
                    validators: {
                        notEmpty: {
                            message: 'Please confirm password'
                        },
                        stringLength: {
                            min: 6,
                            message: 'Must be at least 6 characters'
                        },
                        identical: {
                            field: 'register_password',
                        }
                    }
                },
                register_password: {
                    validators: {
                        notEmpty: {
                            message: 'Password is required'
                        },
                        stringLength: {
                            min: 6,
                            message: 'Must be at least 6 characters'
                        },
                        identical: {
                            field: 'register_confirm',
                        }
                    }
                },
                register_agree: {
                    validators: {
                        notEmpty: {
                            message: 'Please accept our terms of service'
                        }
                    }
                }
            },

        })
        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            first_name = $("#register_first").val();
            last_name = $("#register_last").val();
            email = $("#register_email").val();
            password = $("#register_password").val();

            $.ajax({
                type: "POST",
                url: base_url + "/auth/register",
                dataType: 'json', // expected returned data format.
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    password: password,
                },
                timeout: 5000, // timeout set to 5 seconds
                success: function (data) {
                    console.log(data.message);

                    if (data.valid === 'true') {
                        location.reload();
                        closeAllDialogs();
                        displaySuccessDialog();
                         $.ajax({
                            type: "POST",
                            url: base_url + "/modals/registration",
                            dataType: 'json', // expected returned data format.
                            data: {
                                first_name: first_name,
                                last_name: last_name,
                                email: email,
                            }
                        });
                    } else {
                        console.log(data);
                        $("#register_error").removeClass("hidden").addClass("visible");
                        $('#register_error').html('<i class="fa fa-exclamation-triangle"></i> An error has occured. Please try again.');

                        $('#register-modal').modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    closeAllDialogs();
                    $("#register_error").removeClass("hidden").addClass("visible");
                    $('#register_error').html('<i class="fa fa-exclamation-triangle"></i> Error: ' + error);
                    $('#register_modal').modal('show');
                },
                beforeSend: function () {
                    console.log('Attempting registration');
                    $('#register_modal').modal('hide');
                    displayLoadingDialog();
                }
            });
        
            return false;
        });
});

//# sourceMappingURL=authentication.js.map
