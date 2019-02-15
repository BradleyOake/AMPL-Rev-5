
<!-- This is the popup editing module for the editing page -->
<!-- CALCULATOR FORM -->
<div class="modal fade" id="paymentCalculatorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->

                <div class="tab-content">
                    <div class="tab-pane active" id="login-tab">

                        <!-- Header -->
                        <div class="col-sm-10 col-sm-offset-1 text-center" >
                            <h2>Payment Calculator</h2>
                           <hr>
                        </div>

                        <div class="col-sm-10 col-sm-offset-1 text-center" >
                            <div class="err" id="add_err"></div>
                        </div>

                        <!-- Form that the user can fill out to get their editing costs and a number on the amount of book sales needed to cover the costs -->
                        <form id="paymentCalculatorForm" method="post" class="form-horizontal">

                            <!--input type="hidden" name="_token_editing" id="_token_editing" value="<?php echo csrf_token(); ?>"-->

                            <!-- Group that contains the word count span and text box for input -->
                            <div class="form-group">
                                <div class="col-sm-10  col-sm-offset-1">
                                    <div class="input-group">
                                        <span class="input-group-addon">Word Count</span>
                                        <input class="form-control input-lg" name="wordCount" id="wordCount" placeholder="Word Count" type="text"  />
                                    </div>
                                </div>
                            </div>

                            <!-- Group that contains the cover art needed check box -->
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="input-group center-block">
                                        <div class="checkbox btn-lg">
                                            <label>
                                                <input type="checkbox" name="coverArt" id="coverArt" value=true />Cover Art Needed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Creates a horizontal rule to seperate the input from the output -->
                            <hr>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="input-group">
                                        <label id="totalCostLabel" class="input-group-addon">Total Cost:</label>
                                        <label id="totalCost" class="form-control input-lg"></label>
                                    </div>
                                </div>
                            </div>

                            <!-- Holds the divs for the output messages -->
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div id="costBreakdown" class="col-sm-10 col-sm-offset-1 text-center">
                                    </div>
                                    <div id="editingCost" class="input-group text-center">
                                    </div>
                                    <div id="adminCost" class="input-group">
                                    </div>
                                    <div id="coverArtCost" class="input-group">
                                    </div>
                                    <div id="isbnCost" class="input-group">
                                    </div>
                                </div>
                            </div>
<!--
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div id="options" class="col-sm-10 col-sm-offset-1 text-center">
                                    </div>
                                    <div id="optionOne" class="input-group">
                                    </div>
                                    <div id="optionTwo" class="input-group">
                                    </div>
                                </div>
                            </div>
-->
                            <div class="form-group text-center">
                                <div class="col-sm-10 col-sm-offset-1">

                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="calculate" id="calculate">Calculate Costs</button>
                                    <button type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">Close</button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
