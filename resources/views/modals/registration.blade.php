<!-- This is the popup register module for the entire site -->
<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-user-plus"></i> Registration</h2>
            </div>

            <!-- Registration form on the modal -->
            <div class="modal-body">
                <form id="register_form" method="post" class="form-horizontal">
                    <!-- First name -->
                    <div class="form-group">
                        <div class="col-sm-10  col-sm-offset-1">
                            <input class="form-control input-lg" name="register_first" id="register_first" placeholder="First Name" type="text" />
                        </div>
                    </div>

                    <!-- Last name -->
                    <div class="form-group">
                        <div class="col-sm-10  col-sm-offset-1">
                            <input class="form-control input-lg" name="register_last" id="register_last" placeholder="Last Name" type="text" />
                        </div>
                    </div>

                    <!-- Email address -->
                    <div class="form-group">
                        <div class="col-sm-10  col-sm-offset-1">
                            <input class="form-control input-lg" name="register_email" id="register_email" placeholder="E-mail" type="text" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="col-sm-10  col-sm-offset-1">
                            <input class="form-control input-lg" name="register_password" id="register_password" placeholder="Password" type="password" />
                        </div>
                    </div>

                    <!-- Confirm password -->
                    <div class="form-group">
                        <div class="col-sm-10  col-sm-offset-1">
                            <input class="form-control input-lg" name="register_confirm" id="register_confirm" placeholder="Confirm Password" type="password" />
                        </div>
                    </div>

                    <!-- Agree to terms checkbox -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="checkbox btn-lg">
                                <label>
                                    <input type="checkbox" id="register_agree" name="register_agree" value="true" required>I agree to the <a target="_blank" href="[[ URL::to('privacypolicy')]]">Terms of Service</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding: 0; z-index: 1">
                        <div id="register_error" name="login_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>

                    <!-- 'Register' button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center ">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="login">Register</button><br/><br/>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer at bottom of modal -->
            <div class="modal-footer bg-dark">
                <!-- Already registered link, goes to Login modal -->
                <a href="#" class="text-right" data-dismiss="modal" data-toggle="modal" data-target="#login_modal">Already Registered?</a>
            </div>
        </div>
    </div>
</div>

<script>
    //set focus to email input on load
    $(document).ready(function () {
        $('#register_modal').on('shown.bs.modal', function () {
            $("#register_first").focus();
        })  
    }); 
</script>
