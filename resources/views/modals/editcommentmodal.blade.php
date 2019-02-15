<!-- This is the popup edit comment modal for the entire site -->
<div class="modal fade" id="editComment_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header for the modal -->
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><i class="fa fa-commenting"></i> Edit Comment</h2>
            </div>
            
            <!-- Edit Comment form on the modal -->
            <div class="modal-body">
                <form id="editcomment_form" method="post" class="form-horizontal">
                    <!-- Comment field to edit -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            Edit your comment:<br>
                            <textarea class="form-control" rows="5" id="editcomment_text" name="editcomment_text"></textarea>
                        </div>
                    </div>
  
                    <!-- Comment rating to edit -->
                    <div style="display:none;" id="ratingEdit" class="form-group">
                        <label for="editcomment_rating" class="col-sm-offset-2 col-sm-4 control-label">Edit Rating</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="editcomment_rating" name="editcomment_rating">
                                
                            </select>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div class="col-sm-offset-1 col-sm-10" style="padding:0; z-index:1">
                        <div id="editcomment_error" name="editcomment_error" class="alert alert-danger text-center hidden" style="padding:5px">
                        </div>
                    </div>


                    <!-- 'Submit' (Edit) button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 text-center">
                            <button type="submit" class="hvr-grow btn btn-primary btn-lg btn-block pull-right" name="editcomment">
                                Update
                            </button>
                            <br><br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        if(window.location.href.indexOf("book") > -1) {
           document.getElementById("ratingEdit").style = ""; 
           document.getElementById("editcomment_rating").innerHTML = "<option value='1' [[DB::table('book_comment')->where('email', Auth::user()->email)->pluck('rating') == 1 ? 'selected' : '']]>1</option>"
                                   + "<option value='2' [[DB::table('book_comment')->where('email', Auth::user()->email)->pluck('rating') == 2 ? 'selected' : '']]>2</option>"
                                   + "<option value='3' [[DB::table('book_comment')->where('email', Auth::user()->email)->pluck('rating') == 3 ? 'selected' : '']]>3</option>"
                                   + "<option value='4' [[DB::table('book_comment')->where('email', Auth::user()->email)->pluck('rating') == 4 ? 'selected' : '']]>4</option>"
                                   + "<option value='5' [[DB::table('book_comment')->where('email', Auth::user()->email)->pluck('rating') == 5 ? 'selected' : '']]>5</option>";
        }

    });
</script>
 