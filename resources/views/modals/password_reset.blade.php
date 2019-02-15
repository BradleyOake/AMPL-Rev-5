<!-- This is the popup reset password module for the entire site -->
<div class="modal fade" id="password-reset-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-user-md"></i> Reset Password</h2>
            </div>
            
            <!-- Password Reset form on the modal -->
            <div class="modal-body">
                <form id="password_Form" method="post" class="form-horizontal">
                    <!-- E-mail to send password to -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            Please enter your e-mail
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input class="form-control input-lg" name="email" id="email" placeholder="E-mail" type="text" />
                            </div>
                        </div>
                    </div>

                    <!-- 'Reset' button and login link -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="login">Reset</button><br/><br/>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-dark">
                <a href="#" class="text-right" data-dismiss="modal" data-toggle="modal" data-target="#login_modal">Login</a>
            </div>
        </div>
    </div>
</div>