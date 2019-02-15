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
