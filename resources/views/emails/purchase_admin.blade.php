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
       <p>There has been a book sale!</p>

        <h3>Invoice Info</h3>
        <strong>Buyer Email:</strong> [[ $buyer_email ]]
        <br>
        <strong>Buyer First:</strong> [[ $buyer_first ]]
        <br>
        <strong>Buyer Last: </strong>[[ $buyer_last ]]
        <br>
        <strong>Book ID:</strong> [[ $book_id ]]
        <br>
        <strong>Book Title:</strong> [[ $title ]]
        <br>
         <strong>Type ID:</strong> [[ $type_id ]]
        <br>
         <strong>Amount:</strong> $[[ $amount ]]
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
