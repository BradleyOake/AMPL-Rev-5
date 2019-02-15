@extends('layouts.layout_main')
@section('title', 'View/Edit Users')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View/Edit Users</h1>
        </div>
    </div>

    <table width="100%" class="table table-striped table-bordered ampl-table">
        <tr>
            <th style="text-align:right;">ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th style="text-align:right;">Account Type</th>
            <th>Bio</th>
            <th>Image</th>
            <th>Options</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td style="text-align:right;">[[ $user->id]]</td>
                <td>[[ $user->email]]</td>
                <td>[[ $user->first_name]]</td>
                <td>[[ $user->last_name]]</td>
                <td style="text-align:right;">[[ $user->role_id ]]</td>
                <td>[!! $user->bioExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
                <td>[!! $user->coverExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
                
                <td class="text-center">
                    <a href="[[ URL::to('admin/user/edit', array($user->email)) ]]" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>

                    <a href="[[ URL::to('admin/purchases', array('email' => $user->email)) ]]" class="btn btn-sm btn-success">
                        <i class="fa fa-download"></i>
                    </a>

                    <a href="[[ URL::to('admin/userDetails', array($user->email)) ]]" class="btn btn-sm btn-primary">
                        <i class="fa fa-bar-chart"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>
@stop
