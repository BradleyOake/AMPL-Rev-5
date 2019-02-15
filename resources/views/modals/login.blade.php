<!-- This is the popup login module for the entire site -->
<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-center"><i class="fa fa-user"></i> Sign In</h3>
            </div>

            <!-- Login form on the modal -->
            <div class="modal-body">
                <!-- Social media login -->
                <div class="col-sm-offset-1 col-sm-10" style="padding: 0; z-index: 1">
                    <a class="btn btn-block btn-social btn-lg btn-facebook hvr-grow" onclick="fb_login();">
                        <i class="fa fa-facebook"></i> Sign In with Facebook
                    </a>

                    <a id="btn-google" class="btn btn-block btn-social btn-lg btn-google hvr-grow">
                        <i class="fa fa-google"></i> Sign In with Google
                    </a>
                    <hr>
                </div>

                <!-- Login via site -->
                <form id="login_form" method="post" class="form-horizontal">
                    <!-- Login email -->
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input class="form-control input-lg" name="login_form_email" id="login_form_email" placeholder="E-mail" type="text" />
                            </div>
                        </div>
                    </div>

                    <!-- Login password -->
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="login_form_password" id="login_form_password" placeholder="Password" />
                            </div>
                        </div>
                    </div>

                    <!-- 'Remember Me' checkbox -->
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="checkbox btn-lg">
                                <label>
                                    <input type="checkbox" name="login_form_remember" id="login_form_remember" value="true">Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding: 0; z-index: 1">
                        <div id="login_error" name="login_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>

                    <!-- 'Sign In' button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center ">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="login_submit"> Sign In</button><br/><br/>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sign up (register) link -->
            <div class="modal-footer bg-dark">
                <a style="float: left;" href="#" data-dismiss="modal" data-toggle="modal" data-target="#register_modal">Sign Up With E-mail</a>
                <a style="float: right;" href="#" data-dismiss="modal" data-toggle="modal" data-target="#password-reset-modal">Forgot Your Password?</a>
            </div>
        </div>
    </div>
</div>

<script>
    //set focus to email input on load
    $(document).ready(function () {
        $('#login_modal').on('shown.bs.modal', function () {
            $("#login_form_email").focus();
        })  
    }); 
</script>