<!-- This is the popup edit comment modal for the entire site -->
<div class="modal fade" id="editPost_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div>
        <div class="modal-content" style="width:850px; margin:0 auto;">
            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-commenting"></i> Edit News Post</h2>
            </div>
            
            <!-- Edit Comment form on the modal -->
            <div class="modal-body">
                <form id="updatepost_form" method="post" class="form-horizontal">
                    <!-- Post fields to edit -->
                    <div class="form-group">
                        <div class="updatePostFields">
                            <h5>Title:</h5>
                            <textarea class="form-control" rows="1" id="editpost_title" name="editpost_title"></textarea><br>
                            <h5>Keywords:</h5>
                            <textarea class="form-control" rows="1" id="editpost_key" name="editpost_key"></textarea><br>
                            <h5>Description:</h5>
                            <textarea class="form-control" rows="2" id="editpost_description" name="editpost_description"></textarea><br>
                            <h5>Subtopic:</h5>
                            <textarea class="form-control" rows="2" id="editpost_sub" name="editpost_sub"></textarea><br>
                            <h5>HTML:</h5>
                            <textarea class="form-control" rows="8" id="editpost_html" name="editpost_html"></textarea><br>
                            </h5>
                        </div>
                    </div>        

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
                        <div id="editpost_error" name="editpost_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>

                    <!-- 'Submit' (Edit) button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="editpost">
                                Update
                            </button>                      
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>