@extends('layouts.layout_main')
@section('title', 'Learn more about AMPL Publishing and our team. Find out the ways you can contribute to AMPL')
@section('metatags')
    <meta name="description" content="Get the latest news updates from AMPL Publishing. Here is where you'll find out about new or upcoming books and their authors." />
    <meta name="keywords" content="news, updates, E-Books, Aspiring Authors, Canadian, Publisher, Publish your work, Reader, Read, Novel, Ampl, Electronic books, Buy e-books, Buy books, Cheap books, Cheap e-books, Writers, Write, Make money writing " />
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
@stop
@section('content')

<!-- main-container -->
<div class="container main-content">
<form id="comment_form" method="post" class="form-horizontal">
<fieldset>
    <div class="form-group text-center">
            <div class="err" id="comment_err">Edit Comment</div>
        </div>

<div class="form-group">
  <label class="col-md-3" for="comment_id">Comment ID:</label>
  <input class="col-md-1" id="comment_id" name="comment_id" value="[[$comments->comment_id]]" readonly />
  </div>
<div class="form-group">
  <label class="col-md-4 control-label" for="comment_name" >Name</label>
  <div class="col-md-4">
  <input id="comment_name" value="[[$comments->name]]" name="comment_name" type="text" class="form-control input-md" required>

  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="comment_content">Content</label>
  <div class="col-md-8">
<textarea class="form-control" value="" name="comment_content" id="comment_content" rows="6" required >[[$comments->text]]</textarea>
  </div>

</div>
        <div class="form-group text-center">

            <button type="submit" class="btn btn-primary" name="login">Submit</button>
            <form><input type="button" value="Go Back" class="btn btn-primary" onClick="history.go(-1);return true;"></form>

        </div>
</div>
</fieldset>
</form>
<!-- /.container -->

@stop

@section('javascripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#comment_form').bootstrapValidator({
        
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            comment_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a header for the comment.'
                    }
                }
            },
            comment_content: {
                validators: {
                    notEmpty: {
                        message: 'Please enter some content as a comment.'
                    }
                }
            }
        },
    })
    .on('success.form.bv', function(e) {
        
        e.preventDefault();
        
        var $form = $(e.target);
        
        var bv = $form.data('bootstrapValidator');
        
        id=$("#comment_id").val();
        name=$("#comment_name").val();
        content=$("#comment_content").val();
        
        $.ajax({
            type: "POST",
            url: public_path+"updateComment",
            dataType: 'json',
            data: {
                id: id,
                name: name,
                content: content
            },
            success: function(data){
                
                if(data.valid=true)
                {
                    $("#comment_err").html("Comment updated successfully");

                }
                else
                {
                    $("#comment_err").html("An error occurred in submitting this form.");
                }
            },
            beforeSend:function()
            {
                $("#comment_err").html("Loading...");
            }
        });
        return false;
        
    });
});
</script>
@stop