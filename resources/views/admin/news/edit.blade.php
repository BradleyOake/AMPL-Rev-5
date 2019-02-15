@extends('layouts.layout_main')
@section('title', 'Edit News Post')
@section('metatags')
@stop
@section('content')

<!-- main-container -->
<div class="container main-content">


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit News</h1>
        </div>
    </div>
    <div class="row">
        <form id="news" class="form-horizontal" method="post">
            <fieldset>
                <div class="form-group text-center">
                    <div class="err" id="news_err">Enter News Post</div>
                </div>

                 <input  id="news_id" name="news_id" type="hidden" class="form-control input-md" value="[[ $post->news_id ]]">


                <!-- Form Name -->
                 <div class="form-group">
                    <label class="col-md-4 control-label" for="news_id">ID</label>
                    <div class="col-md-4">
                        <input disabled id="news_id" name="news_id" type="text" class="form-control input-md" value="[[ $post->news_id]]" />
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="news_title">Title</label>
                    <div class="col-md-4">
                        <input id="news_title" name="news_title" type="text" class="form-control input-md" required value="[[ $post->title]]" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="subtopic">Subtopic</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="subtopic" id="subtopic" rows="6" required>[[ $post->subtopic]]</textarea>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label" for="news_content">Main Content</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="news_content" id="news_content" rows="6" required>[[ $post->html ]]</textarea>
                    </div>
                </div>

                <label class="col-md-2 control-label" for="news_image">Add Image</label>
                <div class="col-md-5">
                    <input type="file" id="news_image" name="news_image" class="btn btn-primary" />
                    <br />
                </div>

                <div>
                    <label class="col-md-2 control-label" for="align">Choose Image Alignment</label>
                    <input type="radio" id="align" name="align" value="left" onclick="alignPic();">Align Left</input>
                    <br />
                    <input type="radio" id="align" name="align" value="middle" onclick="alignPic();">Align Center</input>
                    <br />
                    <input type="radio" id="align" name="align" value="right" onclick="alignPic();" checked>Align Right</input>
                    <br />
                </div>

    <hr>
      <div class="form-group">
                    <label class="col-md-3 control-label" for="m_description">Meta Description</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="m_description" id="m_description" rows="6" required>[[ $post->m_description ]]</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="m_keywords">Meta Keywords</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="m_keywords" id="m_keywords" rows="6" required>[[ $post->m_keywords ]]</textarea>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="col-sm-112">
                        <button class="btn" type="button" value="Preview News Post" onclick="previewPost();">Preview</button>
                        <button type="submit" class="btn btn-primary" name="login">Submit</button>
                    </div>
                </div>

            </fieldset>
        </form>
        <hr>
        <div id="previewTitle"></div>
        <p id="previewContent">
            <img id="imagePrev" name="imagePrev" width="200" style="visibility:hidden" height="200" src="#" />
        </p>
    </div>
</div>
<!-- /.container -->
<script type="text/javascript">
    function alignPic() {
        var alignment = document.getElementById("align").value;
        var pic = document.getElementById("news_image");

        if (pic.files && pic.files[0]) {
            document.getElementById("imagePrev").align = alignment;
        }
    }

    function previewPost() {
        var title = document.getElementById("news_title").value;
        var content = document.getElementById("news_content").value;
        var alignment = document.getElementById("align").value;
        var pic = document.getElementById("news_image");

        if (title == "" || title == null || content == "" || content == null) {
            window.alert("You must have both a title and some content to see a preview.");
        } else {
            document.getElementById("previewTitle").innerHTML = "<div class='col-xs-12'><div class='text-center'> <h2>" + title + "</h2></div></div>";
            document.getElementById("previewContent").innerHTML = "<div class='col-xs-12 col-sm-8' style='margin-top:10px; margin-bottom:30px'><p>" + content + "</p></div>";
        }

        if (pic.files && pic.files[0]) {
            document.getElementById("previewContent").innerHTML = "<div class='col-xs-12 col-sm-8' style='margin-top:10px; margin-bottom:30px'><p> <img id='imagePrev' name='imagePrev' width='200' style='visibility:hidden' height='200' src='#' />" + content + "</p></div>";
            document.getElementById("imagePrev").style.visibility = "visible";
            document.getElementById("imagePrev").align = alignment;
            var file = new FileReader();
            file.onload = function (e) {
                var etr = file.result;
                var img = document.getElementById("imagePrev");
                img.src = etr;
            };

            file.readAsDataURL(pic.files[0]);
        } else {
            document.getElementById("previewContent").innerHTML = "<div class='col-xs-12 col-sm-8' style='margin-top:10px; margin-bottom:30px'><p> " + content + "</p></div>";
        }
    }
</script>
@stop

@section('javascripts')

 <script type="text/javascript">
$(document).ready(function() {
     $('#news').bootstrapValidator({

        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            news_title: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a title for this news item.'
                    }
                }
            },
            news_content: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the content of this news item.'
                    }
                }
            },
            news_image: {
                validators: {
                    file: {
                        extension: 'tif,gif,jpg,png',
                        message: 'Please enter an image file.'
                    }
                }
            }
        },

    })
    .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            $.ajax({
                    type: "POST",
                    url: public_path+"admin/editNews",
                    dataType : 'json', // expected returned data format.
                    data: new FormData( this ),
                    processData: false,
                    contentType: false,
                    success: function(data){

                    if(data.valid==true)
                    {
                        $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-check-circle"></i> News Post Updated',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-home"></i> Panel',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('admin/panel') ]]";
                                    }
                                },
                                {
                                    label: '<i class="fa fa-eye"></i> View',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('newspage', $post->news_id) ]]";
                                    }
                                },
                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                     cssClass: 'pull-left btn-danger',
                                    action: function() {
                                       window.location.replace(document.referrer);
                                    }
                                }
                            ]
                        });
                    }
                    else
                    {

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-exclamation-circle"></i> An Error Occured',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                     cssClass: 'pull-left btn-danger',
                                    action: function() {
                                       window.location.replace(document.referrer);
                                    }
                                },
                                {
                                    label: 'Close',
                                    action: function(dialogItself){
                                        dialogItself.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                error: function (xhr, status, error) {
                        BootstrapDialog.alert(error);
                },
                beforeSend:function()
                {
                     BootstrapDialog.show({
                        title: '<div class="text-center">Submitting Data<div>',
                        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending..<div>'
                    });
                }
            });
                return false;
            });


});
</script>
@stop
