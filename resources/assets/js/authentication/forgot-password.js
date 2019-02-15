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
