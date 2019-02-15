@extends('layouts.layout_main')
@section('title', 'Purchases')
@section('metaDescription', '')

@section('content')

<!-- Page Content -->
    <div class="container main-content">
        <div class="col-lg-12">
            <h1 class="page-header">Reset Purchase</h1>
        </div>

   <form id="reset_form" class="form-horizontal" method="post">

       <input name="sale_id" id="sale_id" type="hidden" class="form-control input-md" value="[[ $invoice->sale_id ]]">


        <div class="form-group">
            <label class="col-md-4 control-label" for="">Sale ID</label>
            <div class="col-md-4">
                <input disabled name="" id="" type="email" class="form-control input-md" value="[[ $invoice->sale_id ]]">

            </div>
        </div>

       <div class="form-group">
            <label class="col-md-4 control-label" for="book_id">Book ID</label>
            <div class="col-md-4">
                <input disabled name="book_id" id="book_id" type="email" class="form-control input-md" value="[[ $invoice->book_id ]]">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="title">Book Title</label>
            <div class="col-md-4">
                <input disabled id="title" name="title" type="text" class="form-control input-md" value="[[ $invoice->title]]">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-4">
                <input disabled name="email" id="email" type="text" class="form-control input-md" value="[[ $invoice->email]]">

            </div>
        </div>

           <div class="form-group">
            <label class="col-md-4 control-label" for="type">Type</label>
            <div class="col-md-4">
                <input disabled name="type" id="type" type="text" class="form-control input-md" value="[[ $invoice->description]]">

            </div>
        </div>

       <div class="form-group">
            <label class="col-md-4 control-label" for="sold_on">Date Purchased</label>
            <div class="col-md-4">
                <input disabled name="sold_on" id="sold_on" type="date" class="form-control input-md" value="[[ date('Y-m-d', strtotime($invoice->sold_on)) ]]">

            </div>
        </div>

       <div class="form-group">
            <label class="col-md-4 control-label" for="access_until">Access Until</label>
            <div class="col-md-4">
                <input name="access_until" id="access_until" type="date" class="form-control input-md" value="[[ date('Y-m-d', strtotime($invoice->access_until)) ]]">

            </div>
        </div>

        <div class="form-group text-center">
            <div class="col-sm-112">

                <button type="submit" class="btn btn-primary" name="login">Submit</button>

            </div>
        </div>

</form>




    </div>
    <!-- /.container -->

@stop


@section('scripts')

<script type="text/javascript">


$(document).ready(function()
{
     $('#reset_form').bootstrapValidator(
    {

        feedbackIcons:
        {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields:
        {
            access_until:
            {
                validators:
                {
                  notEmpty:
                  {
                        message: 'Author name must be inserted'
                  }
                }
            }




        },


    })
     .on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');

        $.ajax({
            type: "POST",
            url: base_url + "admin/users/resetAccess",
            dataType: 'json', // expected returned data format.

            data: new FormData( this ),
                processData: false,
                contentType: false,
            success: function (data)
            {

                if(data.valid==true)
                    {
                        $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-check-circle"></i> User Updated',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-home"></i> Panel',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('admin/panel') ]]";
                                    }
                                },

                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                    cssClass: 'pull-left btn-danger',
                                    action: function() {
                                        window.location.replace(document.referrer);
                                    }
                                }
                            ]
                        });
                    }
                    else
                    {

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-exclamation-circle"></i> An Error Occured',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                     cssClass: 'pull-left btn-danger',
                                    action: function() {
                                       window.location.replace(document.referrer);
                                    }
                                },
                                {
                                    label: 'Close',
                                    action: function(dialogItself){
                                        dialogItself.close();
                                    }
                                }
                            ]
                        });
                    }
                },

                error: function (xhr, status, error) {

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });
                        BootstrapDialog.alert(error);

                },
                beforeSend:function()
                {
                     BootstrapDialog.show({
                        title: '<div class="text-center">Submitting Data<div>',
                        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending..<div>'
                    });
                }


        });
        return false;

    });


});


</script>

@stop

