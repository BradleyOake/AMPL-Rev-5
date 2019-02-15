<!-- This is the popup edit comment modal for the entire site -->
<div class="modal fade" id="addPost_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div>
        <div class="modal-content" style="width:850px; margin:0 auto;">
            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-commenting"></i> Add News Post</h2>
            </div>
            
            <!-- add Comment form on the modal -->
            <div class="modal-body">
                <form id="addpost_form" method="post" class="form-horizontal">
                    <!-- Post fields to add -->
                    
                        <div class="updatePostFields">
                          <div class="form-group">  <h5>Title:</h5>
                            <textarea class="form-control" rows="1" id="addpost_title" name="addpost_title"></textarea></div>
                          <div class="form-group">  <h5>Keywords:</h5>
                            <textarea class="form-control" rows="1" id="addpost_key" name="addpost_key"></textarea></div>
                          <div class="form-group">  <h5>Description:</h5>
                            <textarea class="form-control" rows="1" id="addpost_description" name="addpost_description"></textarea></div>
                          <div class="form-group">  <h5>Subtopic:</h5>
                            <textarea class="form-control" rows="1" id="addpost_sub" name="addpost_sub"></textarea></div>
                          <div class="form-group">  <h5>HTML:</h5>
                            <textarea class="form-control" rows="6" id="addpost_html" name="addpost_html"></textarea></div>
                            </h5>
                        </div>
                    </div>        

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
                        <div id="addpost_error" name="addpost_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>

                    <!-- 'Submit' (add) button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="addpost">
                                add
                            </button>                      
                        </div>
                    </div>
                </form>
                <br><br><br><br>
            </div>
        </div>
    </div>
</div>