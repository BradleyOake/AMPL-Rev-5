@extends('layouts.layout_main')
@section('title', 'Add Paper')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-file"></i> Add Paper</h1>
    </div>

    <h1 class="col-sm-offset-1" id="add_err">Paper Information</h1>
    
    <form class="form-horizontal" method="post" id="addpaper_form">
        <div class="row col-lg-12">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-2">
                    <label for="paper_name" class="control-label">Paper Name</label>
                    <input type="text" class="form-control" id="paper_name" name="paper_name" placeholder="Optional" maxlength="40" required />
                </div>

                <div class="col-lg-2">
                    <label for="paper_type" class="control-label">Paper Type</label>
                    <select class="form-control" id="paper_type" name="paper_type">
                        <?php $i=1 ?>
                        @foreach($paperType as $paperTypes)
                            <option value=<?php echo $i ?>>[[ $paperTypes ]]</option>
                            <?php $i++ ?>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <label for="paper_usage" class="control-label">Paper Usage</label>
                    <select class="form-control" id="paper_usage" name="paper_usage">
                        <?php $i=1 ?>
                        @foreach($paperUsage as $paperUsages)
                            <option value=<?php echo $i ?>>[[ $paperUsages ]]</option>
                            <?php $i++ ?>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <label for="paper_size" class="control-label">Paper Size</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="paper_size_w" name="paper_size_w" placeholder="W" maxlength="2" min="1" max="12" required />
                        <span class="input-group-addon" id="sizing-addon1">W</span>
                        <input type="text" class="form-control" id="paper_size_l" name="paper_size_l" placeholder="L" maxlength="2" min="1" max="18" required />
                        <span class="input-group-addon" id="sizing-addon1">L</span>
                    </div>
                </div>

                <div class="col-lg-2">
                    <label for="unit_cost" class="control-label">Unit Cost</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="number" class="form-control" id="unit_cost" name="unit_cost" placeholder="Enter unit cost..." min="0" step="0.0001" required />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <br><br>
                <button type="submit" class="add_paper btn btn-primary btn-lg" name="addpaper">
                    <i class="fa fa-file"></i> Add Paper
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
    $(document).ready(function()
    {
        $('#addpaper_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                paper_name:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a paper name'
                        }
                    }
                },
                paper_type:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a paper type'
                        }
                    }
                },
                paper_usage:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a paper usage'
                        }
                    }
                },
                unit_cost:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a unit cost'
                        },
                        numeric:
                        {
                            message: 'Unit cost must be a numeric value'
                        },
                        lessThan:
                        {
                            value: 9.9999,
                            message: 'Please enter a value between 0 and 9.9999'
                        },
                        stringLength:
                        {
                            max: 6,
                            message: 'Unit cost must be only 5 numbers long'
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

            paper_name = $('#paper_name').val();
            paper_type = $('#paper_type').val();
            paper_usage = $('#paper_usage').val();
            paper_size = $('#paper_size_w').val() + "x" + $('#paper_size_l').val();
            unit_cost = $('#unit_cost').val();

            $.ajax(
            {
                type: "POST",
                url: "[[URL::to('book/addPaper')]]",
                dataType : 'json', // expected returned data format.
                data:
                {
                    paper_name: paper_name,
                    paper_type: paper_type,
                    paper_usage: paper_usage,
                    paper_size: paper_size,
                    unit_cost: unit_cost,
                },
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $("#add_err").removeClass('text-danger').addClass('text-success');
                        $("#add_err").html(data.message);
                        $('#addpaper_form').data('bootstrapValidator').resetForm();
                        $('#addpaper_form')[0].reset();
                        
                        window.scrollTo(0,0);
                    }
                    else
                    {
                        $("#add_err").addClass("text-danger");
                        $("#add_err").html(data.message);
                        $('#addpaper_form').data('bootstrapValidator').resetForm();
                        //$('#addpaper_form')[0].reset();
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
