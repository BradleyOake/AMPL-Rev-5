<!DOCTYPE html>
<html lang="en-US">
    <body>
        <style>
            p
            {
                font-family: helvetica;
                font-size: 10pt;
            }
            a
            {
                font-family: helvetica;
                font-size: 10pt;
            }
            .emailContainer
            {     
                width: 100%;
                margin: auto;
            }
            .emailHeader
            {
                background-color: #008000;
            }
            .emailLogo
            {
                width: 70%;
            }
            .body
            {
                width: 90%;
                margin: auto;
            }
            .body p
            {
                font-family: helvetica;
            }
            hr
            {
                border: none;
                background-color: #eaeaea;
                height: 1px;
            }
            .emailFooter
            {
                background-color: #eaeaea;
            }
            .contact
            {
                background-color: #F4FFE8;
                padding: 2%;
                margin-left: 2%;
                width: 60%;
                border-top: solid 1px;
                border-left: solid 1px;
            }
        </style>

        <div>
            <div class="emailContainer">
                <div class="emailHeader">
                    <div class="emailLogo">
                        <img src="[[ $message->embed(public_path() . '/images/logos/ampl-logo-white.svg') ]]" width="100px" style="padding:2%; padding-left:4%; margin:0px;" />                     
                    </div>
                </div>
                <div class="body">
                    <p>
                        Dear [[ $firstname]],<br>
                        <br>
                        Our team would like to thank you for your registration! This account not only enables you purchase and download our selection of e-books, but also gives you the ability to submit a book of your own to be published!<br>
                        <br>
                        If you have any questions, please let us know!<br>
                        <br>
                        <br>
                        Regards,<br>
                        <br>AMPL Publishing
                        <br>
                        <br>
                        <h3><a href="mailto:leebodyj@amplbooks.com">Contact Us</a></h3>
                        <br>
                    </p>
                </div>
                <div class="emailFooter">
                    <div style="margin:auto; text-align:center;">
                        <p style="font-size: 8pt;"><br>Copyright &copy;<?php echo date( "Y"); ?> AMPL Publishing</p>
                        <a target="_blank" title="follow me on facebook" href="https://www.facebook.com/AMPL-Publishing-1000264530068098/"><img alt="follow me on facebook" width="20px" src="https://c866088.ssl.cf3.rackcdn.com/assets/facebook30x30.png" border=0></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
