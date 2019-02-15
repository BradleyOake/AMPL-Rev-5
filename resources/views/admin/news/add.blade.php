@extends('layouts.layout_main')
@section('title', 'Add News Post')
@section('metatags')
@stop
@section('content')

<!-- main-container -->
<div class="container main-content">


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add News</h1>
        </div>
    </div>
    <div class="row">
        <form id="news" class="form-horizontal" method="post">
            <fieldset>
                <div class="form-group text-center">
                    <div class="err" id="news_err">Enter News Post</div>
                </div>
                <!-- Form Name -->

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="news_title">Title</label>
                    <div class="col-md-4">
                        <input id="news_title" name="news_title" type="text" class="form-control input-md" required />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="subtopic">Subtopic</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="subtopic" id="subtopic" rows="6" required></textarea>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label" for="news_content">Main Content</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="news_content" id="news_content" rows="6" required></textarea>
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
                        <textarea class="form-control" name="m_description" id="m_description" rows="6" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="m_keywords">Meta Keywords</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="m_keywords" id="m_keywords" rows="6" required></textarea>
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
                url: public_path+"admin/addNews",
                dataType : 'json', // expected returned data format.
                 data: new FormData( this ),
                 processData: false,
                 contentType: false,
                success: function(data){

                    if(data.valid==true)
                    {
                        $("#news_err").html("News posted successfully");
                        $("#news")[0].reset();
                        $('#news').data('bootstrapValidator').resetForm();
                    }
                    else
                    {
                        $("#news_err").html("An error occurred in submitting the form");
                    }
                },
                beforeSend:function()
                {
                    $("#news_err").html("Loading...")
                }
            });
            return false;

            });


});
</script>
@stop
