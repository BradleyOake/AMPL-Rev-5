@extends('layouts.layout_main')
@section('title', 'AMPL Homepage')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-cog"></i> Account Settings</h1>
    </div>

    <div class="row">
        <form id="settings_form" class="form-horizontal" method="post">
            <div class="form-group text-center">
                <div class="err" id="user_err">
                    Your current information
                </div>
            </div>

            <!-- Form Name -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_email">Email</label>
                <div class="col-md-4">
                    <input data-toggle="tooltip" title data-original-title="The email tied to your account" name="user_email" id="user_email" type="email" class="form-control input-md" disabled value="[[Auth::user()->email]]" />
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_type">Account Type</label>
                <div class="col-md-4">
                    <input data-toggle="tooltip" title data-original-title="The type of account you have" name="account_type" id="account_type" type="text" class="form-control input-md" disabled value="[[Auth::user()->role_id]]" />
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_first">First Name</label>
                <div class="col-md-4">
                    <input id="user_first" name="user_first" type="text" class="form-control input-md" onchange="firstChange()" value="[[Auth::user()->first_name]]" maxlength="20" placeholder="Please enter your first name..." />
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_last">Last Name</label>
                <div class="col-md-4">
                    <input name="user_last" id="user_last" type="text" class="form-control input-md" onchange="lastChange()" value="[[Auth::user()->last_name ]]" maxlength="20" placeholder="Please enter your last name..." />
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-sm-112">
                    <button type="submit" class="btn btn-primary" name="login">
                        Save Changes
                    </button>
                    <h1 id="errorMessage"></h1>
                </div>
            </div>
        </form>
        <br>
        <hr>

        <div class="form-group text-center">
            <div class="err" id="pass_err">
                Change Your Password
            </div>
        </div>

        <form id="mypassword_form" class="form-horizontal" method="post">
            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_password">Old Password</label>
                <div class="col-md-4">
                    <input name="user_oldpassword" id="user_oldpassword" type="password" maxlength="60" placeholder="" class="form-control input-md" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="user_password">New Password</label>
                <div class="col-md-4">
                    <input name="user_password" id="user_password" type="password" maxlength="60" placeholder="" class="form-control input-md" />
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_confpassword">Confirm Password</label>
                <div class="col-md-4">
                    <input id="user_confpassword" name="user_confpassword" type="password" maxlength="60" class="form-control input-md" />
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-sm-112">
                    <button type="submit" class="btn btn-primary" name="login">
                        Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container -->



@stop

@section('scripts')
<script>
var oldFirstName = "";
var oldLastName = "";
function firstChange()
{
    oldFirstName=$("#user_first").val();
}
function lastChange()
{
    oldLastName=$("#user_last").val();
}
    $(document).ready(function()
    {
        $('#settings_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                user_first:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'First name is required'
                        },
                        regexp: {
                            regexp: /^[-'a-zA-Z\s]+$/,
                            message: 'Must contain only alpbabetical characters, \', and \-'
                        }
                    }
                },
                user_last:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Last name is required'
                        },
                        regexp: {
                            regexp: /^[-'a-zA-Z\s]+$/,
                            message: 'Must contain only alpbabetical characters, \', and \-'
                        }
                    }
                }
            },
        })
        .on('success.form.bv', function(e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            first=$("#user_first").val();
            last=$("#user_last").val();

            $.ajax(
            {
                type: "POST",
                url: base_url+"/user/nameUpdate",
                dataType : 'json', // expected returned data format.
                data:
                {
                    first: first,
                    last: last,
                },
                success: function(data)
                {
                    if(oldFirstName == "" && oldLastName == "")
                    {
                        $("#user_err").addClass("text-danger");
                        $("#user_err").html("Nothing was changed. Please try again.");
                        $('#settings_form').data('bootstrapValidator').resetForm();
                        $('#settings_form')[0].reset();
                    }
                    else if(data.valid==true)
                    {
                        $("#user_err").removeClass('text-danger').addClass("text-success");
                        $("#user_err").html(data.name+" has been updated");
                        oldFirstName = "";
                        oldLastName = "";

                        $('#settings_form').data('bootstrapValidator').resetForm();
                        $('#settings_form')[0].reset();

                        document.getElementById("user_first").value = first;
                        document.getElementById("user_last").value = last;
                        document.getElementById("navName").innerHTML = first + " " + last;
                    }
                    else
                    {
                        $("#user_err").addClass("text-danger");
                        $("#user_err").html("An error occurred in submitting the form");
                    }
                },
                beforeSend:function()
                {
                    $("#user_err").html("Loading...")
                }
            });

            return false;
        });
    });

    $(document).ready(function()
    {
        $('#mypassword_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                user_oldpassword:
                {
                    validators:
                    {
                        stringLength:
                        {
                            min: 6,
                            message: 'Must be at least 6 characters'
                        },
                        notEmpty:
                        {
                            message: 'You must enter your old password'
                        }
                    }
                },
                user_password:
                {
                    validators:
                    {
                        identical:
                        {
                            field: 'user_confpassword',
                            message: 'The password and its confirm are not the same'
                        },
                        stringLength:
                        {
                            min: 6,
                            message: 'Must be at least 6 characters'
                        },
                        notEmpty:
                        {
                            message: 'You must enter a new password'
                        }
                    }
                },
                user_confpassword:
                {
                    validators:
                    {
                        identical:
                        {
                            field: 'user_password',
                            message: 'The password and its confirm are not the same'
                        },
                        stringLength:
                        {
                            min: 6,
                            message: 'Must be at least 6 characters'
                        },
                        notEmpty:
                        {
                            message: 'You must confirm the new password'
                        }
                    }
                }
            },
        })
        .on('success.form.bv', function(e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            oldpassword=$("#user_oldpassword").val();
            password=$("#user_password").val();
            confirm=$("#user_confpassword").val();

            $.ajax(
            {
                type: "POST",
                url: base_url+"/user/passwordUpdate",
                dataType : 'json', // expected returned data format.
                data:
                {
                    oldpassword: oldpassword,
                    password: password,
                    confirm: confirm
                },
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $("#pass_err").removeClass('text-danger').addClass('text-success');
                        $("#pass_err").html(data.message);
                        $('#mypassword_form').data('bootstrapValidator').resetForm();
                        $('#mypassword_form')[0].reset();                       
                        $.ajax(
                        {
                            type: "POST",
                            url: base_url+"/email/changePassword",
                        });
                    }
                    else
                    {
                        $("#pass_err").addClass("text-danger");
                        $("#pass_err").html(data.message);
                    }
                },
                beforeSend:function()
                {
                    $("#pass_err").html("Loading...")
                }
            });
            

            return false;
        });
    });
</script>
@stop
