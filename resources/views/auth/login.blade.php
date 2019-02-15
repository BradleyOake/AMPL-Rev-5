@extends('layouts.layout_main')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Login
                </div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-md-5">
                        <form id="loginForm" method="post" class="form-horizontal">
                            <div class="form-group">
                                <!--<label class="col-sm-3 control-label">Email</label>-->
                                <div class="col-sm-10  col-sm-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input class="form-control input-md" name="email" id="email" placeholder="E-mail" type="text" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <!--<label class="col-sm-3 control-label">Password</label>-->
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control input-md" name="password" id="password" placeholder="Password" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <!--<label class="col-sm-3 control-label">Password</label>-->
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="input-group center-block">
                                        <div class="checkbox btn-md">
                                            <label>
                                                <input type="checkbox" name="remember" id="remember" value=true>Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <button type="submit" class="hvr-grow btn btn-primary btn-md btn-block" name="login">Login</button>
                                    <button type="button" class="hvr-grow btn btn-default btn-md btn-block" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                            <div class="col-sm-10 col-sm-offset-1 text-center" style="top: 20px;">
                                <a href="" style=" color:white; font-size:16px" data-dismiss="modal" data-toggle="modal" data-target=".forgot-password-modal">Forgot Your Password?</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-5">
                        <a class="btn btn-block btn-social btn-md btn-facebook hvr-grow" onclick="fb_login();" style="z-index:1">
                            <i class="fa fa-facebook"></i> Sign in with Facebook
                        </a>

                        <a id='btn-google' class="btn btn-block btn-social btn-md btn-google hvr-grow"  style="z-index:1">
                            <i class="fa fa-google"></i> Sign in with Google
                        </a>

                        <a class="btn btn-link" onclick="fb_logout(); google_logout();" href="#">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function () {
    $('#loginForm').bootstrapValidator({
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
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
                }
            },

            password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    },
                    stringLength: {
                        min: 6,
                        message: 'Must be at least 6 characters'
                    }
                }
            },
            conf: {
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


        email = $("#email").val();
        password = $("#password").val();
        remember = $('#remember').is(":checked");


        $.ajax({

            type: "post",
            url: "auth/login",
            dataType: 'json', // expected returned data format.
            data: {
                email: email,
                password: password,
                 remember: remember
            },
            success: function (data) {
                 console.log('login.blade.php: ' + data.message);
                if(data.valid==true)
                    {


                    }
                    else
                    {
                         $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();
                    }
                },
                error: function (xhr, status, error) {
                        console.log('login.blade.php error: ' + error);
                },
                beforeSend:function()
                {

                }
        });
        return false;

    });
});
</script>
@stop
