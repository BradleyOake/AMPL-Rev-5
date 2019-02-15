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
                    <br>
                    
                        <h4>Thank you for your print request!</h4>
          
                        <p>
                        We have received your request, and will respond to you as soon as possible!<br>
                        <br>
                        <br>
                        The request we recieved from you:<br>
                        <div class="contact">
                            <h5>Print Job: [[ $jobname ]]</h5>
                            <p>Number of Pages: [[ $numpages ]]</p>
                            <p>Cover: [[ $ordercover ]]</p>
                            <p>Paper: [[ $orderpaper ]]</p>
                            <p>Ink: [[ $orderink ]]</p>
                            <p>Attachment: [[ $uploadname ]]</p>
                            <h5>Additional Instructions:</h5><p>[[ $orderadditional ]]</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <a href="http://www.amplbooks.com/">Visit the AMPL Publishing Website</a>
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

