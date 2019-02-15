@extends('layouts.layout_main')
@section('title', 'Add User')
@section('metatags')
@stop
@section('content')

<!-- main-container -->
<div class="container main-content">

   <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add User</h1>

            </div>
        </div>
<div class="row">
            <form id="user" class="form-horizontal" method="post">
<fieldset>
    <div class="form-group text-center">
            <div class="err" id="user_err">Enter user information</div>
        </div>
<!-- Form Name -->

<div class="form-group">
  <label class="col-md-4 control-label" for="user_email">Email</label>
  <div class="col-md-4">
  <input name="email2" id="email2" type="email" class="form-control input-md">

  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_first">First Name</label>
  <div class="col-md-4">
  <input id="user_first" name="user_first" type="text" class="form-control input-md">

  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_last">Last Name</label>
  <div class="col-md-4">
  <input name="user_last" id="user_last" type="text" class="form-control input-md">

  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_type">Account Type</label>
  <div class="col-md-4">
    <select name="user_type" id="user_type" class="form-control">
        <option value=""></option>
      @foreach ($userRoles as $role)
        <option value="[[ $role->role_id ]]">[[ $role->description ]]</option>
    @endforeach
    </select>
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_password">Password</label>
  <div class="col-md-4">
    <input name="user_password" id="user_password" type="password"class="form-control input-md">

  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_confpassword">Confirm Password</label>
  <div class="col-md-4">
    <input id="user_confpassword" name="user_confpassword" type="password" class="form-control input-md">

  </div>
</div>


       <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_description">Meta Description</label>
                    <div class="col-md-4">
                        <textarea id="m_description" name="m_description" class="form-control input-md" rows="4" cols="100"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_description">Meta Keywords</label>
                    <div class="col-md-4">
                        <textarea id="m_keywords" name="m_keywords" class="form-control input-md" rows="4" cols="100"></textarea>
                    </div>
                </div>
     <div class="form-group">
                    <label class="col-md-4 control-label" for="bio">Bio</label>
                    <div class="col-md-4">
                        <input type="file" name="bio" id="bio">
                    </div>
                </div>

      <div class="form-group">
                    <label class="col-md-4 control-label" for="image">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="image" id="image">
                    </div>
                </div>

    <hr>
<div class="form-group text-center">
        <div class="col-sm-112">

            <button type="submit" class="btn btn-primary" name="login">Submit</button>

        </div></div>

</fieldset>
</form>

        </div>
</div>
<!-- /.container -->

@stop

@section('scripts')
 <script type="text/javascript">
$(document).ready(function() {
     $('#user').bootstrapValidator({

        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            user_email: {
                validators: {
                  notEmpty: {
                        message: 'Email is required'
                    }
                    ,
                  remote: {
                        message: 'That email is already registered',
                        url: base_url + '/registerEmailCheck',

                        type: 'POST'

                    }
                    ,
                     regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Not a valid email address'
                        }
                }
            },
            user_first: {
                validators: {
                    notEmpty: {
                        message: 'First name is required'
                    }
                }
            },
             user_last: {
                validators: {
                    notEmpty: {
                        message: 'Last name is required'
                    }
                }
            },
             user_type: {
                validators: {
                    notEmpty: {
                        message: 'Account type name is required'
                    }
                }
            },

             user_confpassword: {
                validators: {
                    notEmpty: {
                        message: 'Please confirm password'
                    },
                    stringLength: {
                        min: 5,
                        message: 'Must be at least 5 characters'
                    },
                     identical: {
                        field: 'pass',

                    }
                }
            },
            user_password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    },
                    stringLength: {
                        min: 5,
                        message: 'Must be at least 5 characters'
                    }
                }
            },
             bio: {
                    validators: {
                        file: {
                            extension: 'txt',
                            type: 'text/plain',

                            message: 'Please enter a txt file'
                        }

                    }
                },
        },

    })
    .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            $.ajax({
                type: "POST",
                url: base_url + "/admin/users/postAdd",
                dataType : 'json', // expected returned data format.
                 data: new FormData(this),
                 processData: false,
                    contentType: false,
                success: function(data){

                    if(data.valid==true)
                    {

                        $("#user_err").addClass("text-success");
                        $("#user_err").html("User has been registered");
                        $("#user")[0].reset();
                        $('#user').data('bootstrapValidator').resetForm();
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
</script>
@stop
