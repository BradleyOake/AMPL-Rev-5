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
       <p>A new user has been registered with AMPL.</p>

        <strong>Email:</strong> [[ $email ]]
        <br>
        <strong>First Name:</strong> [[ $firstname ]]
        <br>
        <strong>Last Name: </strong>[[ $lastname ]]
        <br>
        <strong>Created At:</strong> [[ $createdat ]]
        <br>
        </ul>
<br>
        <hr>
    </div>


    <footer class="text-center">
        <div class="footer-above">

        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy;<?php echo date( "Y"); ?> AMPL Publishing
                    </div>
                    <div class="col-lg-12">

                    </div>
                </div>
            </div>
        </div>
    </footer>


</body>

</html>
