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
            Dear {{ $name}},
        </p>

        <p>Our teamn would like to thank you for your book submission of {{ $title }}. {{ $title }} is currently being reviewed by our team.
            <br>
            <br>If you have any questions, please let us know!</p>
        <p>Regards,
            <br>
            <br>AMPL Publishing
            <br>
            <br><h3>
<a href="mailto:leebodyj@amplbooks.com">Contact Us</a></h3>

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
