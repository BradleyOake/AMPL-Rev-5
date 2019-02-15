<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <!-- Custom CSS -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
        <body>
        <div class="container">
            
            <p>
                Dear [[ $name]],<br>
                <br>
                Just a reminder.<br>
                <br>
                The password for the [[ $email ]] account has been changed using the 'Account Settings' panel at amplbooks.com.<br>
                If this is news to you, please contact us immediately using the link below.<br>
                <br>
                <br>
                Regards,<br>
                AMPL Publishing                             
            </p>
            
            <a href="mailto:leebodyj@amplbooks.com">Contact Us</a></h3>
            <br>
            <hr>
        </div>
        <footer class="text-center">
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            Copyright &copy;<?php echo date( "Y"); ?> AMPL Publishing
                        </div>           
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
