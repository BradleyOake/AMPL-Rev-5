@extends('layouts.layout_main')
@section('title', 'Edit Ink')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-eyedropper"></i> Edit Ink &quot;<span id="ink_header">[[ $ink->ink_name ]]</span>&quot;</h1>
    </div>

    <h1 class="text-center" id="edit_err">Ink Information</h1>
    
    <form class="form-horizontal" method="post" id="editink_form">
        <div class="row col-lg-offset-4 col-lg-12">
            <div class="row">
                <div class="col-lg-2 text-center">
                    <label for="ink_name" class="control-label">Ink Name</label>
                    <input type="text" class="form-control" id="ink_name" name="ink_name" placeholder="Optional" value="[[ $ink->ink_name ]]" maxlength="40" />
                </div>

                <div class="col-lg-2 text-center">
                    <label for="cost_per_side" class="control-label">Cost/Side</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="number" class="form-control" id="cost_per_side" name="cost_per_side" placeholder="Enter cost per side..." value="[[ $ink->cost_per_side ]]" min="0" step="0.0001" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <br><br>
                <button type="submit" class="edit_ink btn btn-primary btn-lg" style="width:15%;" data-ink="[[ $ink->ink_id ]]" name="editink">
                    <i class="fa fa-eyedropper"></i> Edit ink
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

@stop

@section('scripts')
<script>
    $(".edit_ink").click(function(e)
    {
        var sender = $(this);
        window.ink_id = sender.data("ink");
    });

    $(document).ready(function()
    {
        $('#editink_form').bootstrapValidator(
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
                url: "[[URL::to('book/updateInk')]]",
                dataType : 'json', // expected returned data format.
                data:
                {
                    ink_id: window.ink_id,
                    ink_name: ink_name,
                    cost_per_side: cost_per_side,
                },
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $("#edit_err").removeClass('text-danger').addClass('text-success');
                        $("#edit_err").html(data.message);
                        $('#editink_form').data('bootstrapValidator').resetForm();
                        //$('#editink_form')[0].reset();

                        $('#ink_header').html(ink_name);
                        
                        window.scrollTo(0,0);
                    }
                    else
                    {
                        $("#edit_err").addClass("text-danger");
                        $("#edit_err").html(data.message);
                        $('#editink_form').data('bootstrapValidator').resetForm();
                        //$('#editink_form')[0].reset();
                    }
                },
                beforeSend:function()
                {
                    $("#edit_err").html("Loading...");
                }
            });
            
            return false;
        });
    });
</script>
@stop
