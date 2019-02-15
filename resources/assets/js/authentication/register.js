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
