@extends('layouts.layout_main')
@section('title', 'Edit User')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit User "[[ $user->first_name]] [[ $user->last_name ]]"</h1>
        </div>
    </div>

    <div class="row">
        <form id="user" class="form-horizontal" method="post">
            <div class="form-group text-center">
                <div class="err" id="user_err">
                    Change user information
                </div>
            </div>
            
            <!-- Form Name -->
            <input  id="id" name="id" type="hidden" class="form-control input-md" value="[[ $user->id ]]">
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="">ID</label>
                
                <div class="col-md-4">
                    <input name="" id="" type="text" class="form-control input-md" disabled value="[[ $user->id ]]">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="user_email">Email</label>
                
                <div class="col-md-4">
                    <input name="user_email" id="user_email" type="email" class="form-control input-md" value="[[ $user->email ]]">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_first">First Name</label>
                
                <div class="col-md-4">
                    <input id="user_first" name="user_first" type="text" class="form-control input-md" value="[[ $user->first_name]]">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_last">Last Name</label>
                
                <div class="col-md-4">
                    <input name="user_last" id="user_last" type="text" class="form-control input-md" value="[[ $user->last_name ]]">
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_type">Account Type</label>
                
                <div class="col-md-4">
                    <select name="user_type" id="user_type" class="form-control">
                        @foreach ($userRoles as $role)
                            <option [[ ($user->role_id == $role->role_id) ? 'selected' : '' ]] value="[[ $role->role_id ]]">[[ $role->description ]]</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_password">New Password</label>
                
                <div class="col-md-4">
                    <input name="user_password" id="user_password" type="password"  placeholder="no change"  class="form-control input-md" >
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="user_confpassword">Confirm Password</label>
                
                <div class="col-md-4">
                    <input id="user_confpassword" name="user_confpassword" type="password" class="form-control input-md">
                </div>
            </div>
            <hr>

            <div class="form-group">
                <label class="col-md-4 control-label" for="book_description">Meta Description</label>
                
                <div class="col-md-4">
                    <textarea id="m_description" name="m_description" class="form-control input-md" rows="4" cols="100">[[ $user->m_description]]</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="book_description">Meta Keywords</label>
    
                <div class="col-md-4">
                    <textarea id="m_keywords" name="m_keywords" class="form-control input-md" rows="4" cols="100">[[ $user->m_keywords ]]</textarea>
                </div>
            </div>

            <div class="form-group">
                @if ($user->bioExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[ $user->id ]]" data-type="txtsample" class="delete_bio btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        
                        <a href="[[ URL::to('download/bio', array('id' => $user->id )) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                @endif
                
                <label class="col-md-4 control-label" for="bio">Bio</label>
    
                <div class="col-md-4">
                    <input type="file" name="bio" id="bio">
                </div>
            </div>

            <div class="form-group">
                @if ($user->coverExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-email="[[ $user->email ]]" data-type="txtsample" class="delete_image btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        
                        <a href="[[ URL::to('download/authorImage', array('id' => $user->id )) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                @endif
            
                <label class="col-md-4 control-label" for="image">Image</label>
    
                <div class="col-md-4">
                    <input type="file" name="image" id="image">
                </div>
            </div>
            <hr>
            
            <div class="form-group text-center">
                <div class="col-sm-112">
                    <button type="submit" class="btn btn-primary btn-lg" name="login">
                        <i class="fa fa-floppy-o"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
        <br><hr><br>
        
        <div class="row col-lg-12 text-center">
            <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin/user') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Edit Users</a>
        </div>

        <div class="row col-lg-12 text-center">
            <br><br>
            <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    // this is the id of the submit button
    $(".delete_bio").click(function ()
    {
        var sender = $(this);
        var id = sender.data("id");

        BootstrapDialog.confirm(
        {
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete this author bio?',
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result)
            {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result)
                {
                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax(
                    {
                        type: "POST",
                        url: "[[URL::to('admin/deleteBio')]]",
                        data:
                        {
                            id: id,
                        },
                        success: function (data)
                        {
                           location.reload();
                        }
                    });
                }
            }
        });
    });

    // this is the id of the submit button
    $(".delete_image").click(function ()
    {
        var sender = $(this);
        var email = sender.data("email");

        BootstrapDialog.confirm(
        {
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete this author image?',
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result)
            {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result)
                {
                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax(
                    {
                        type: "POST",
                        url: "[[URL::to('admin/deleteAuthorImage')]]",
                        data:
                        {
                            email: email,
                        },
                        success: function (data)
                        {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    $(document).ready(function()
    {
        $('#user').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                user_email:
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
                user_first:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'First name is required'
                        }
                    }
                },
                user_last:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Last name is required'
                        }
                    }
                },
                user_type:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Account type name is required'
                        }
                    }
                },
                user_password:
                {
                    validators:
                    {
                        identical:
                        {
                            field: 'user_confpassword',
                            message: 'The password and its confirm are not the same'
                        },
                        stringLength:
                        {
                            min: 5,
                            message: 'Must be at least 5 characters'
                        }
                    }
                },
                user_confpassword:
                {
                    validators:
                    {
                       identical:
                       {
                            field: 'user_password',
                            message: 'The password and its confirm are not the same'
                        },
                        stringLength:
                        {
                            min: 5,
                            message: 'Must be at least 5 characters'
                        }

                    }
                }
            },
        })
        .on('success.form.bv', function(e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            $.ajax(
            {
                type: "POST",
                url: base_url + "/admin/users/postUpdate",
                dataType : 'json', // expected returned data format.
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();

                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        BootstrapDialog.show(
                        {
                            title: '<i class="fa fa-check-circle"></i> User Updated',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                            {
                                label: '<i class="fa fa-home"></i> Panel',
                                cssClass: 'btn-primary',
                                action: function()
                                {
                                    window.location.href = "[[URL::to('admin/panel') ]]";
                                }
                            },
                            {
                                label: '<i class="fa fa-eye"></i> Author Page',
                                cssClass: 'btn-primary',
                                action: function()
                                {
                                    window.location.href = "[[URL::to('author', array($user->id,  $user->first_name.' '.$user->last_name)) ]]";
                                }
                            },
                            {
                                label: '<i class="fa fa-arrow-left"></i> Back',
                                cssClass: 'pull-left btn-danger',
                                action: function()
                                {
                                    window.location.replace(document.referrer);
                                }
                            }]
                        });
                    }
                    else
                    {
                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        BootstrapDialog.show(
                        {
                            title: '<i class="fa fa-exclamation-circle"></i> An Error Occured',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                            {
                                label: '<i class="fa fa-arrow-left"></i> Back',
                                cssClass: 'pull-left btn-danger',
                                action: function()
                                {
                                    window.location.replace(document.referrer);
                                }
                            },
                            {
                                label: 'Close',
                                action: function(dialogItself)
                                {
                                    dialogItself.close();
                                }
                            }]
                        });
                    }
                },
                error: function (xhr, status, error)
                {
                    BootstrapDialog.alert(error);
                },
                beforeSend:function()
                {
                    BootstrapDialog.show(
                    {
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
