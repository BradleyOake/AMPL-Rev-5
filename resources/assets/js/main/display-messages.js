/*
 *  Displays the loading modal
 *
 *
 */
function displayLoadingDialog() {

    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-user"></i> Attempting Login',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Logging you in..<div>'
    });
}

/*
 *  Displays the success modal
 *
 *
 */
function displaySuccessDialog() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Login Successful',
        message: '<div class="text-center">You have been succesfully logged in.</div>',
        closable: true,
    });
}

function closeAllDialogs() {

    $.each(BootstrapDialog.dialogs, function (id, dialog) {
        dialog.close();
    });

}

function displayEmailSendingDialog() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-user"></i> Sending Email',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>We are sending your email...<div>'
    });
}

function displaySendingComment() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-comment"></i> Submitting Comment',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending...<div>'
    });
}

function displayEditingComment() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-comment"></i> Editing Comment',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending...<div>'
    });
}

function displaySuccessfulComment() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Commenting Successful',
        message: '<div class="text-center">Thank you for the comment!</div>',
        closable: true,
    });
}

function displaySuccessfulEdit() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Edit Successful',
        message: '<div class="text-center">Thank you for the comment!</div>',
        closable: true,
    });
}

function displaySuccessfulAddPost() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Post Added Successfully',
        message: '<div class="text-center">Your post has been added to the news page!</div>',
        closable: true,
    });
}

function displayAddingPost() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-comment"></i> Adding Post',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending...<div>'
    });
}

function displayEditingPost() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-comment"></i> Updating Post',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending...<div>'
    });
}

function displaySuccessfulEditPost() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Post Updated Successfully',
        message: '<div class="text-center">Your post has been changed on the news page!</div>',
        closable: true,
    });
}

function displaySuccessfulPrintRequest() {

    BootstrapDialog.alert({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> Print Request Sent Successfully',
        message: '<div class="text-center">Your request has been emailed!</div>',
        closable: true,
    });
}

function displaySendingPrintRequest() {
    BootstrapDialog.show({

        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-comment"></i> Sending Print Request',
        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending...<div>'
    });
}

function confirmReport() {
    BootstrapDialog.confirm({
        title: '<i class="fa fa-flag"></i> Report Comment',
        message: 'Are you sure you want to report this comment?',
        type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
        closable: true, // <-- Default value is false
        draggable: true, // <-- Default value is false
        btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
        btnOKLabel: 'Report', // <-- Default value is 'OK',
        btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
        callback: function (result) {
            // result will be true if button was click, while it will be false if users close the dialog directly.
            if (result) {
                return true;
            }
        }
    });

}

function confirmDelete() {

}

function displayTooManyPhysicalCopies() {

    BootstrapDialog.show({
        size: BootstrapDialog.SIZE_SMALL,
        title: '<i class="fa fa-check-circle"></i> That is a big order!',
        message: '<div class="text-center">If you would like to make an order that large, we recommend you contact us through email!</div>',
        closable: true,
         buttons: [{
                label: 'Contact Us',
                action: function(dialog) {
                    window.location.replace("/contact");
                }
   
            }]
    });
}
