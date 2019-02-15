<!-- Who are we -->
<section id="contact" style="padding:0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading"><i class="fa fa-envelope"></i> Let's Get In Touch!</h2>
                <hr class="primary">
                <p>
                    Ready to publish your next book? That's great! Throw us an email and we will get back to you as soon as possible!
                </p>
            </div>

            <div class="col-lg-offset-4 col-lg-4 text-center">
                <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                <br><br>
            </div>
        </div>

        <!-- Inputs for contact form -->
        <div class="col-md-12">
            <form class="form-horizontal" method="post" id="contact_form">   
                <!-- Name -->
                <div class="form-group">
                    <label for="contact_name" class="col-sm-4 control-label">Your Name</label>
                    <div class="col-sm-4">
                        <input placeholder="What do we call you?" type="text" class="form-control input-lg" id="contact_name" name="contact_name" @if(Auth::check()) value="[[ Auth::user()->first_name . " " . Auth::user()->last_name ]]" @else value="" @endif required />
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="contact_email" class="col-sm-4 control-label">Your Email</label>
                    <div class="col-sm-4">
                        <input placeholder="Who shall we respond to?" class="form-control input-lg" id="contact_email" name="contact_email" @if(Auth::check()) value="[[ Auth::user()->email ]]" @else value="" @endif />
                    </div>
                </div>

              <!-- Subject -->
                <div class="form-group">
                    <label for="contact_subject" class="col-sm-4 control-label">Subject</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="contact_subject" name="contact_subject">
                            <option selected hidden>Select a reason for contact</option>
                            <option value="Complaint">Complaint</option>
                            <option value="Compliment">Compliment</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Ideas & Suggestions">Ideas & Suggestions</option>
                            <option value="Offer Inquiry">Offer Inquiry</option>
                            <option value="Question">Question</option>
                            <option value="Technical Inquiry">Technical Inquiry</option>
                        </select>
                    </div>
                </div>


                <!-- Message -->
                <div class="form-group">
                    <label for="contact_message" class="col-sm-3 control-label">Message</label>
                    <div class="col-sm-6">
                        <textarea placeholder="What is it that you would like us to help you with?" class="form-control input-lg" rows="8" id="contact_message" name="contact_message" maxlength="5000" style="resize:vertical" required></textarea>
                    </div>
                </div>

                <div id="contact_error" name="contact_error" class="col-sm-6 col-md-offset-3 alert alert-danger text-center hidden">
                </div>

                <!-- Submit Button -->
                <div class="form-group text-center">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-lg wow tada hvr-bounce-in" data-wow-duration="0s" name="login">
                            <i class="fa fa-paper-plane"></i> Send Email
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Validation for the registraion part of the modal
    $(document).ready(function ()
    {
        $('#contact_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                contact_name:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Name is required'
                        }                      
                    }
                },  
                contact_email:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Email is required'
                        },
                        regexp:
                        {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'This is not a valid email address'
                        }
                    }
                },
                contact_subject:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Subject is required'
                        },
                        stringLength:
                        {
                            max: 20,
                            message: 'Subject is required'
                        }
                    }
                },
                contact_message:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'A message is required'
                        }                      
                    }
                },                 
            },
        })
        .on('success.form.bv', function (e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            contact_name = $("#contact_name").val();
            contact_email = $("#contact_email").val();
            contact_subject = $("#contact_subject option:selected").text();
            contact_message = $("#contact_message").val();

            $.ajax(
            {
                type: "POST",
                url: base_url + "/email/contact",
                dataType: 'json', // expected returned data format.
                data:
                {
                    contact_name: contact_name,
                    contact_email: contact_email,
                    contact_subject: contact_subject,
                    contact_message: contact_message,
                },
                //timeout: 5000, // timeout set to 5 seconds
                success: function (data)
                {
                    console.log(data.message);

                    if (data.valid === 'true')
                    {
                        location.reload();
                        closeAllDialogs();
                        displayEmailSendingDialog(); 
                    }
                    else
                    {
                        console.log(data);
                        $("#contact_error").removeClass("hidden").addClass("visible");
                        $('#contact_error').html('<i class="fa fa-exclamation-triangle"></i> An error has occured. Please try again.');
                    }
                },
                error: function (xhr, status, error)
                {
                    console.log(error);
                    closeAllDialogs();
                    $("#contact_error").removeClass("hidden").addClass("visible");
                    $('#contact_error').html('<i class="fa fa-exclamation-triangle"></i> Error: ' + error);
                },
            });
            
            return false;
        });
    });
</script>
