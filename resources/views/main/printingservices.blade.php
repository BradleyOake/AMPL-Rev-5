@extends('layouts.layout_main')
@section('title', 'AMPL Printing Services')
@section('metatags')
    <meta name="description" content="Contact AMPL Publishing with any questions or concerns you may have. Contact us about our AMPL Team of editors, web-designers, artists and authors and what you need to do to become a team member." />
    <meta name="keywords" content="contact, team, dream, join, author, canadian, founders, talented" />
    <meta name="revisit-after" content="3 month">
    <meta name="author" content="AMPL Publishing" />
@stop

@section('content')
<style>
th, td
{
    padding:10px;
}
th
{
    text-align:center;
}

</style>

<!-- main-container -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">Printing Services</h1>
    </div>

    <div class="col-lg-12 text-center">
        <p class="col-sm-offset-1" id="edit_err">Looking to get something printed? Well, look no further! AMPL Publishing can print it for you.</p>
        <br>
    </div>

    <div class="col-lg-12">
        <h1 class="text-center" data-toggle="collapse" data-target="#demo">
            <i class="fa fa-calculator"></i> Print Cost Estimator <i class="fa fa-question-circle" data-toggle="tooltip" title="Click to show information about papers and inks!"></i>
        </h1>

        <div id="demo" class="collapse">
            <hr>
            <div class="row col-lg-12">
                <div class="row col-lg-center col-lg-6">
                    <table class="table table-striped ampl-table text-center">
                        <tr>
                            <th colspan="5" style="border-bottom:1px solid black;text-align:center;">
                                Cover
                            </th>
                        </tr>
                        
                        <tr style="border-bottom:1px solid black">
                            <td style="text-align:left;">Name</td>
                            <td style="text-align:left;">Type</td>
                            <td style="text-align:right;">Size</td>
                            <td style="text-align:left;">Usage</td>
                        </tr>

                        @foreach ($papers as $paper)
                            @if($paper->paper_usage == 1)
                                <tr>
                                    <td style="text-align:left;">[[ $paper->paper_name ]]</td>
                                    <td style="text-align:left;">[[ $paper->paper_type_description ]]</td>
                                    <td style="text-align:right;">[[ $paper->paper_size ]]</td>
                                    <td style="text-align:left;">[[ $paper->paper_usage_description ]]</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>

                <div class="row col-lg-center col-lg-6">
                    <table class="table table-striped ampl-table text-center">
                        <tr>
                            <th colspan="5" style="border-bottom:1px solid black;text-align:center;">
                                Paper
                            </th>
                        </tr>
                        
                        <tr style="border-bottom:1px solid black">
                            <td style="text-align:left;">Name</td>
                            <td style="text-align:left;">Type</td>
                            <td style="text-align:right;">Size</td>
                            <td style="text-align:left;">Usage</td>
                        </tr>
                        
                        @foreach ($papers as $paper)
                            @if($paper->paper_usage != 1)
                                <tr>
                                    <td style="text-align:left;">[[ $paper->paper_name ]]</td>
                                    <td style="text-align:left;">[[ $paper->paper_type_description ]]</td>
                                    <td style="text-align:right;">[[ $paper->paper_size ]]</td>
                                    <td style="text-align:left;">[[ $paper->paper_usage_description ]]</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form class="print_calculator" name="calculate" id="calculate">
        <div class="row col-lg-offset-1 col-lg-10">
            <div class="row">
                <hr>
                <br>
                <div class="col-lg-3">
                    <label for="calcCover" class="control-label">Cover Material</label>
                    <select class="form-control" id="calcCover" name="calcCover" onChange="Calculate()">
                        <option selected hidden value="">Select a cover material</option>
                        <option value="0">None</option>
                        @foreach($papers as $paper)
                            @if($paper->paper_usage == 1)
                                <option id="optionCover" value="[[ $paper->unit_cost ]]">[[ $paper->paper_name ]]</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="calcPaper" class="control-label">Paper Material</label>
                    <select class="form-control" id="calcPaper" name="calcPaper" onChange="Calculate()">
                        <option selected hidden value="">Select a paper type</option>
                        @foreach($papers as $paper)
                            @if($paper->paper_usage != 1)
                                <option id="optionPaper" value="[[ $paper->unit_cost ]]">[[ $paper->paper_name ]]</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="calcInk" class="control-label">Ink Type</label>
                    <select class="form-control" id="calcInk" name="calcInk" onChange="Calculate()">
                        <option selected hidden value="">Select an ink type</option>
                        @foreach($inks as $ink)
                            <option id="optionInk" value="[[ $ink->cost_per_side ]]">[[ $ink->ink_name ]]</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="numPages" class="control-label">Number of pages</label>
                    <input type="text" class="form-control" id="numPages" name="numPages" onChange="Calculate()" onkeypress="return isNumberKey(event)" maxlength="4" value="10" />
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-3 text-center">
                    Cover Cost:<input type="text" class="text-center" id="coverCost" name="coverCost" readonly size="6" value=' $0.00' style="border:none; color:#008000;" />
                </div>

                <div class="col-lg-3 text-center">
                    Paper Cost:<input type="text" class="text-center" id="paperCost" name="paperCost" readonly size="6" value=' $0.00' style="border:none; color:#008000;" />
                </div>

                <div class="col-lg-3 text-center">
                    Ink Cost:<input type="text" class="text-center" id="inkCost" name="inkCost" readonly size="6" value=' $0.00' style="border:none; color:#008000;" />
                </div>
            </div>
        
            <div class="row">
                <br><br>
                <div class="col-lg-4 text-center">
                    Cost Per Page:<br>
                    <input type="text" class="printCost" id="pageCost" name="pageCost" readonly size="6" value='$0.00'/>
                </div>

                <div class="col-lg-4 text-center">
                    Subtotal:<br>
                    <input type="text" class="printCost" id="subtotal" name="subtotal" readonly size="6" value='$0.00'/>
                </div>

                <div class="col-lg-4 text-center">
                    Grand Total:<br>
                    <input type="text" class="printCost" id="total" name="total" readonly size="6" value='$0.00'/>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-lg-12 text-center">
            <br>
            <hr>
            <br>

            <h1><strong>Get A Quote!</strong></h1>
            <p>
                Please fill out the information below to get a customized quote from AMPL!
            </p>
        </div>
    </div>

    <form id="print_form" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="row col-lg-offset-3 col-lg-12"  style="width:50%">
            <div class="row">
                <div class="col-lg-6">
                    <label for="printEmail" class="control-label">Your E-mail</label>
                    <input type="text" class="form-control" id="printEmail" name="printEmail" placeholder="Please enter your e-mail..." />
                </div>

                <div class="col-lg-6">
                    <label for="jobName" class="control-label">Job Name</label>
                    <input type="text" class="form-control" id="jobName" name="jobName" placeholder="Please enter a job name..." />
                </div>
            </div>

            <div class="row" style="margin-top:2%;">
                <div class="col-lg-6">
                    <label for="orderCover" class="control-label">Cover Material</label>
                    <select class="form-control" id="orderCover" name="orderCover">
                        <option selected hidden value="">Select a cover material</option>
                        <option value="0" >None</option>
                        @foreach ($papers as $paper)
                            @if($paper->paper_usage == 1)
                                <option id="optionOrderCover" value="[[ $paper->unit_cost ]]">[[ $paper->paper_name ]]</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="orderPaper" class="control-label">Paper Material</label>
                    <select class="form-control" id="orderPaper" name="orderPaper">
                        <option selected hidden value="">Select a paper type</option>
                        @foreach ($papers as $paper)
                            @if($paper->paper_usage != 1)
                                <option id="optionOrderPaper" value="[[ $paper->unit_cost ]]">[[ $paper->paper_name ]]</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top:2%;">
                <div class="col-lg-6">
                    <label for="orderInk" class="control-label">Ink Type</label>
                    <select class="form-control" id="orderInk" name="orderInk">
                        <option selected hidden value="">Select an ink type</option>
                        @foreach ($inks as $ink)
                            <option id="optionOrderInk" value="[[ $ink->cost_per_side ]]">[[ $ink->ink_name ]]</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="numPagesOrder" class="control-label">Number of pages</label>
                    <input type="text" pattern="\d*" maxlength="4" class="form-control" id="numPagesOrder" name="numPagesOrder" onkeypress="return isNumberKey(event)" min="1" step="1" max="9999" value="10" />
                </div>
            </div>

            <div class="row" style="margin-top:2%;">
                <div class="col-lg-6">
                    <label for="orderAdditional" class="control-label">Additional Instructions</label>
                    <textarea class="form-control" style="resize:vertical;" id="orderAdditional" name="orderAdditional"></textarea>
                </div>

                
                <div class="col-lg-6">
                    <label for="uploadText" class="control-label">Upload Your File</label> 
                    <input type="file" class="form-control" id="uploadText" name="uploadText"/>  
                </div>
            </div>
            <br><br>
        </div>

        <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
            <div id="print_error" name="print_error" class="alert alert-danger text-center hidden" style="padding:5px"></div>
        </div>
        
        <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
            <div id="print_message" name="print_message" class="text-center hidden" style="padding:5px"></div>
        </div>

        <div class="form-group text-center">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-lg" name="submit_print" id="submit_print">
                    <i class="fa fa-paper-plane"></i> Submit Request
                </button>
            </div>
        </div>  
    </form>        
</div>

@stop


@section('scripts')
<script type="text/javascript">

    //duplicate calculator entry to order form and vise versa
    $(document).ready(function ()
    {        
        //Cover type
        $(function()
        {
            $("#calcCover").change(function()
            {
                $("#orderCover").val($(this).val());
            });
        });

        $(function()
        {
            $("#orderCover").change(function()
            {
                $("#calcCover").val($(this).val());
                Calculate();
            });
        });
        
        //Paper type
        $(function()
        {
            $("#calcPaper").change(function()
            {
                $("#orderPaper").val($(this).val());
            });
        });

        $(function()
        {
            $("#orderPaper").change(function()
            {
                $("#calcPaper").val($(this).val());
                Calculate();
            });
        });
        
        //Ink type
        $(function()
        {
            $("#calcInk").change(function()
            {
                $("#orderInk").val($(this).val());
            });
        });
        
        $(function()
        {
            $("#orderInk").change(function()
            {
                $("#calcInk").val($(this).val());
                Calculate();
            });
        });
        
        //Number of pages
        $(function()
        {
            $("#numPages").keyup(function()
            {
                $("#numPagesOrder").val($(this).val());
            });
        });

        $(function()
        {
            $("#numPagesOrder").keyup(function()
            {
                $("#numPages").val($(this).val());
                Calculate();
            });
        });
        
        
        
        //Email print request
        $('#print_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                printEmail:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Email is required'
                        },
                        regexp:
                        {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Not a valid email address'
                        }
                    }
                },
                jobName:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Job name is required'
                        }, 
                        stringLength:
                        {
                            min: 5,
                            max: 40,
                            message: '5 to 40 characters in length'
                        }
                            
                    }
                },
                numPagesOrder:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Number of pages is required'
                        }               
                    }
                },
                orderCover:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Cover material is required'
                        }               
                    }
                },
                orderPaper:{
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Paper type is required'
                        }               
                    }
                },
                orderInk:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Ink colour is required'
                        }               
                    }
                },
                orderAdditional:
                {
                    validators:
                    {
                        stringLength:
                        {
                            max: 100,
                            message: 'Additional instructions cannot exceed 100 characters'
                        }               
                    }
                },
                uploadText: 
                {
                    validators: 
                    {
                        file: 
                        {
                            maxSize: 10*1024*1024, //10MB
                            message: 'The selected file is not valid, or may be too large'
                        },
                        notEmpty:
                        {
                            message: 'An upload is required'
                        } 
                    }
                }
            },
        })
        .on('success.form.bv', function (e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
     
            var form = document.forms.namedItem("print_form");
            var formdata = new FormData(form);
            
            formdata.append('orderCover', $("#orderCover option:selected").text());
            formdata.append('orderPaper', $("#orderPaper option:selected").text());
            formdata.append('orderInk', $("#orderInk option:selected").text());
           
           
            $.ajax(
            {
                async: true,
                type: "post",
                url: location.origin + "/printingservices/submit",
                dataType: 'json', // expected returned data format.
                contentType: false,               
                data:  formdata,            
                processData: false,                
                success: function (data)
                {                   
                    console.log("DATA: " + data);
                    closeAllDialogs();
                    displaySuccessfulPrintRequest();
                    $('#submit_print').prop('disabled', true);
                    $("#print_message").removeClass("hidden").addClass("visible");
                    $('#print_message').html('Print request has been sent');
                },
                error: function (xhr, status, error)
                {
                    closeAllDialogs();
                    console.log("ERROR: " + error);
                    $("#print_error").removeClass("hidden").addClass("visible");
                    $('#print_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);
                },
                beforeSend: function () {
                    displaySendingPrintRequest();
                }
            });
  
            return false;
        });
    });


    //Limit entry of characters in number of pages input
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
           return false;
        } 
        
        return true;
    }
           
    //empty appropriate fields when number of pages field is emptied by user       
    $("#numPages").keyup( function()
    {
        if(!$(this).val())
        {
            $("#total").val(" $0.00");
            $("#subtotal").val(" $0.00");
            $("#paperCost").val(" $0.00");
            $("#inkCost").val(" $0.00");
            $("#numPages").attr("placeholder", "Enter # of pages");
        }

        Calculate();
    });

    //calculate all estimate costs on 'print cost estimator'
    function Calculate()
    {
        //get values from calculate form
        var coverCost = document.getElementById("calcCover").value;
        var paperCost = document.getElementById("calcPaper").value;
        var inkCost = document.getElementById("calcInk").value;
        var numPages = document.getElementById("numPages").value;

        //initiate all calculation variables to 0
        var costOfCover = 0;
        var costOfPaper = 0;
        var costOfInk = 0;
        var costPerPage = 0;
        var subtotal = 0;
        var total = 0;

        //calculate cost of cover material
        costOfCover = parseFloat(coverCost) * 2;           
        //calculate cost of paper
        costOfPaper = (paperCost / 2) * numPages;
        //calculate cost of ink
        costOfInk = inkCost * numPages;
        //calculate cost of each individual page       
        costPerPage = parseFloat(paperCost) + parseFloat(inkCost);
        
        //display calculated fields only if valid
        if (!isNaN(costOfPaper) && costOfPaper != 0)
        {
            document.calculate.paperCost.value = ' $' + (Math.round(costOfPaper * 100) / 100).toFixed(2);
        }

        if (!isNaN(costOfInk) && costOfInk != 0)
        {
            document.calculate.inkCost.value = ' $' + (Math.round(costOfInk * 100) / 100).toFixed(2);
        }

        if (!isNaN(costOfCover)) 
        {
            document.calculate.coverCost.value = ' $' + (Math.round(costOfCover * 100) / 100).toFixed(2);
        }
        else
        {
            costOfCover = 0;
        }
        
        if (!isNaN(costPerPage))
        {
            document.calculate.pageCost.value = '$' + (Math.round(costPerPage * 100) / 100).toFixed(2);
        }
        
        //calculate the total before taxes
        subtotal =  parseFloat(costOfCover) + (parseFloat(costOfPaper) + parseFloat(costOfInk));
        //calculate total after taxes
        total = subtotal * 1.13;

        if (!isNaN(total) && calculate.numPages.value != ' ' && calculate.numPages.value != null)
        {
            document.calculate.subtotal.value = '$' + (Math.round(subtotal * 100) / 100).toFixed(2);
            document.calculate.total.value = '$' + (Math.round(total * 100) / 100).toFixed(2);
        }
    }
</script>
@stop
