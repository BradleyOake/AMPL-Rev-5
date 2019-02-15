@extends('layouts.layout_main')
@section('title', 'Add Ink')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-eyedropper"></i> Add Ink</h1>
    </div>

    <h1 class="text-center" id="add_err">Ink Information</h1>

    <div class="col-lg-offset-1 col-lg-10 text-center">
        <form class="form-horizontal" method="post" id="addink_form">
            <div class="row col-lg-center">
                <label for="ink_name" class="control-label">Ink Name</label>
                <input type="text" class="form-control" id="ink_name" name="ink_name" placeholder="Enter ink name..." maxlength="40" />
                <br>

                <label for="cost_per_side" class="control-label">Cost/Side</label>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon3">$</span>
                    <input type="number" class="form-control" id="cost_per_side" name="cost_per_side" placeholder="Enter cost per side..." min="0" step="0.0001" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <br><br>
                    <button type="submit" class="add_ink btn btn-primary btn-lg" name="addink">
                        <i class="fa fa-eyedropper"></i> Add ink
                    </button>
                </div>
            </div>
        </form>
        <br><hr><br>

        <div class="row col-lg-12 text-center">
            <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin/printing') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Printing Services</a>
        </div>

        <div class="row col-lg-12 text-center">
            <br><br>
            <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script>
    $(document).ready(function()
    {
        $('#addink_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                ink_name:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter an ink name'
                        }
                    }
                },
                cost_per_side:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a cost per side'
                        },
                        numeric:
                        {
                            message: 'Cost per side must be a numeric value'
                        },
                        lessThan:
                        {
                            value: 9.9999,
                            message: 'Please enter a value between 0 and 9.9999'
                        },
                        stringLength:
                        {
                            max: 6,
                            message: 'Cost per side must be only 5 numbers long'
                        }
                    }
                }
            },
        })
        .on('success.form.bv', function(e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            ink_name = $('#ink_name').val();
            cost_per_side = $('#cost_per_side').val();

            $.ajax(
            {
                type: "POST",
                url: "[[URL::to('book/addInk')]]",
                dataType : 'json', // expected returned data format.
                data:
                {
                    ink_name: ink_name,
                    cost_per_side: cost_per_side,
                },
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $("#add_err").removeClass('text-danger').addClass('text-success');
                        $("#add_err").html(data.message);
                        $('#addink_form').data('bootstrapValidator').resetForm();
                        $('#addink_form')[0].reset();
                        
                        window.scrollTo(0,0);
                    }
                    else
                    {
                        $("#add_err").addClass("text-danger");
                        $("#add_err").html(data.message);
                        $('#addink_form').data('bootstrapValidator').resetForm();
                        //$('#addink_form')[0].reset();
                    }
                },
                beforeSend:function()
                {
                    $("#add_err").html("Loading...");
                }
            });
            
            return false;
        });
    });
</script>
@stop
