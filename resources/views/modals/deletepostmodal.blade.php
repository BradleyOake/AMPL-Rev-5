<!-- This is the popup delete post modal for the entire site -->
<div class="modal fade" id="deletePost_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-ban"></i> Delete News Post</h2>
            </div>
            
            <!-- Delete post form on the modal -->
            <div class="modal-body">
                <form id="deletepost_form" method="post" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-10">
                            Are you sure you want to delete this news post?
                             <br><br>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
                        <div id="deletepost_error" name="deletepost_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>

                    <!-- 'Submit' (Delete) button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="deletepost">
                                Delete
                            </button>
                            <br><br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 