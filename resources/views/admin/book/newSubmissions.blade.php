@extends('layouts.layout_main')
@section('title', 'Learn more about AMPL Publishing and our team. Find out the ways you can contribute to AMPL')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <div class="form-group text-center">
        <h1 class="page-header">New Submissions</h1>  
    </div>

    <div class="scrollTable">
        <table width="100%" class="table table-striped table-bordered">
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>View/Edit</th>
            </tr>
            
            @foreach ($submissions as $submission)
                @if($submission->status_id == 1)
                    <tr>
                	   <td>[[ $submission->book_id]]</td>
                        <td>[[ $submission->title]]</td>
                        <td>[[ $submission->name_on_book]]</td>
                        <td>[[ $submission->description]]</td>
                        <td class="text-center"><a href="[[ URL::to('admin/editBook', array($submission->book_id)) ]]" class="btn btn-primary" style="padding:0px 10px 0px 10px"><i class="fa fa-pencil-square-o"></i></a></td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>
@stop
