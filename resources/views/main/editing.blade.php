@extends('layouts.layout_main')
@section('title', 'AMPL Editing Services')
@section('metatags')
    <meta name="keywords" content="writing, editor, royalty, author, write, royalties, manuscript, writer, publish, editing" />
    <meta name="description" content="New aspiring authors looking to publish there work for money. AMPL Publishing is a royalty paying e-Book Publisher. We are accepting new manuscripts (fiction only). See our submission guideline and application form. Become part of the AMPL Team today." />
    <meta name="robots" content="index,follow" />
    <meta name="author" content="AMPL Publishing" />
@stop

@section('content')

<!-- Include for editing Calculator -->
@include('modals.paymentcalculatormodal')
@include('modals.payment')

<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">Services to Authors</h1>
    </div>

    <div class="col-lg-12">
        <h2 class="text-center"> Editing </h2>
    </div>

    <div class="col-lg-12">
        <p>AMPL Publishing provides grammatical/content editing, including the summary for the back of the book</p>
        <p>AMPL provides each author with a product  page and editor profile free of charge. A member of the AMPL team will skim over each submission received to ascertain quality, grammatical correctness and content flow. There is no charge for this either.  If AMPL recommends additional editing or research, we have a team of editors and researchers that will assist you. Our rates and payment options are provided below:</p><br />
    </div>

    <!-- Button for the editing cost calculator -->
    <h2 class="text-center">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#paymentCalculatorModal">
            <i class="fa fa-calculator"></i> Editing Cost Calculator
        </button>
    </h2>
    <br>

    <div class="col-lg-12">
        <h2 class="text-center"> Cover art</h2>
    </div>

    <div class="col-lg-12">
        <p>
            Cover Art (this includes title, graphics, and layout in the form of a photograph or art) is available upon request.  AMPL reserves the right to negotiate the cost on a case by case basis. The minimum estimate is set at $100 .  The price depends upon the amount of work required, the type of artwork (computer graphics, hand drawn or photographed), and any special requests from the author. AMPL employs a network of talented artists and photographers skilled at creating the perfect visual presentation of your novel.
        </p>
        <br>
    </div>

    <div class="col-lg-12">
        <h2 class="text-center"> Payment Options</h2>
    </div>
    
    <div class="col-lg-12">
        <p>
            AMPL is very flexible.  We want to assist in making your dreams a reality.  Click below to view our three different payment options.
        </p>
        <br>
    </div>
    
    <div class="col-lg-12">
        <h2 class="text-center">
            <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#payment_modal">
                <i class="fa fa-list-ol"></i> Payment Options
            </a>
        </h2>
    </div>

    <div class="col-lg-12">
        <h2 class="text-center"> Additional Notes </h2>
    </div>

    <div class="col-lg-12">
        <p>
            The time frame for completion of each project varies according to length and services required.  The AMPL author/services contract must be signed before work begins. AMPL reserves the right to change or withdraw any of the above service(s) options for any present or future work(s) being submitted.
        </p>
    </div>
</div>

@stop

@section('javascripts')
<script type="text/javascript">
    $(document).ready(function() {
         $('#paymentCalculatorForm').bootstrapValidator({

            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                wordCount: {
                    validators: {
                        notEmpty: {
                            message: 'A word count is required'
                          },
                        regexp: {
                            regexp: '^([1-9]\\d*)$',
                            message: 'The word count must be a whole number greater than zero'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var wordCount = $('#wordCount').val();
            var coverArt = $('#coverArt').prop('checked');
            var adminCost = 0.00;
            var coverArtCost = 100;
            var editingCost;
            var totalCost;
            var booksToSell = 0;
            var hstRate = .13;
            var tax;

            //If the word count is greater than 100,000
            if (wordCount >= 100000)
            {
                //Editing cost is .8 cents per word
                editingCost = 450+(wordCount * .008);
                //Admin cost is 1% of the editing cost
                adminCost = editingCost * .01;
            }
            //If word count is above 50,000 and less than or equal to 100,000
            else if(wordCount >= 50000)
            {
                //Editing cost is $800 to 1250
                editingCost = 350 + (wordCount * .009);
                //Admin cost is 1.5% of the editing cost
                adminCost = editingCost * .015;
            }
            //If word count is about 10,000 and less than or equal to 50,000
            else if(wordCount >= 10000)
            {
                //Editing cost is equal to $350-750
                editingCost = 250+(wordCount * .01);
                //Admin cost is 2% of the editing cost
                adminCost = editingCost * .02;
            }
            else if (wordCount >= 1000)
            {
                //Editign cost is equal to $150-350
                editingCost = 130 + (wordCount * .02);
                // No admin cost
                adminCost = 0.00;
            }
            else if (wordCount >= 100)
            {
                //Editign cost is equal to $100 to 150
                editingCost = 100 + (wordCount * .05);
                // No admin cost
                adminCost = 0.00;

            }
             else
            {
                //Editign cost is equal to 100
                editingCost = 100.00;
                adminCost = 0.00;
            }

            totalCost = adminCost + editingCost;

            //If cover art is needed
            if (coverArt)
            {
                //Adds $100 to the cost for the cover art
                totalCost = totalCost + coverArtCost;
            }

            //Calculates the tax
            tax = totalCost * hstRate;

            //Adds tax onto the totalCost
            totalCost = totalCost + tax;

            //Calculates the number of books the author needs to sell to break even on costs
            //The book sale price is an assumed $5 and if one receives 20% of that $5.
            //Therefore booksToSell = totalCost / (5 * .20) Rounded up to accomodate for decimals, can't sell .31 of a book
            booksToSell = Math.ceil(totalCost / (5 * .2));

            //Sets the editing cost element's innerHTML to the cost that the author will have to pay
            $('#totalCost').text("$" + totalCost.toFixed(2));

            //Displays the breakdown of the cost
            $('#costBreakdown').html("<h4>Cost Breakdown</h4><hr>");

            $('#editingCost').html("<label>Editing Cost:</label> $" + editingCost.toFixed(2));
            $('#adminCost').html("<label>Tax:</label> $" + tax.toFixed(2));
            //Sets the html of the coverArtCost, if cover art is needed then it displays the label and the cost, if it isn't then it displays nothing
            $('#coverArtCost').html( "<label>Minimum Cover Art Cost:</label> " + ((coverArt) ? "$" + coverArtCost.toFixed(2) : "Not Selected"));
            $('#isbnCost').html("<label>ISBN Cost:</label> Free");

            //Displays the details of picking each option
            $('#options').html("<h4>Options</h4><hr>");
            $('#optionOne').html("<label>Option 1:</label> $" + totalCost.toFixed(2) + " paid upfront")
            $('#optionTwo').html("<label>Option 2:</label> " + booksToSell + " books will need to be sold to cover the cost with 50% of royalties");

            //Enables the calculate button
            $('#calculate').prop('disabled', false);
        });
    });
</script>

@stop
