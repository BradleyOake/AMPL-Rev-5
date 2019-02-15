<?php
use App\Author;
use App\BookComment;
use App\NewsComment;
?>

@extends('layouts.layout_main')
@section('title', 'AMPL Admin Panel')

@section('content')

<!-- Page Content -->
<div class="container main-content">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-lock"></i> Admin Panel</h1>
    </div>

    <div class="col-md-offset-1 col-md-11">
        Here you have access to all aspects of the website. Anything can be changed in these pages.<br>
        Please note that all "View" buttons will have links to edit on the View page.
    </div>

    <!-- ROW 1 -->
    <div class="row">
        <!-- AUTHORS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-pencil"></i> Authors</h2>

            <a href="[[-- URL::to('admin/author/add') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-plus-circle"></i> Add Author
            </a>
            <br>

            <a href="[[ URL::to('admin/author') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-eye"></i> View Authors
            </a>
        </div>

        <!-- BOOKS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-book"></i> Books</h2>

            <a href="[[ URL::to('admin/book/add') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-plus-circle"></i> Add Book
            </a>
            <br>

            <a href="[[ URL::to('admin/book/newSubmissions') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-exclamation"></i> New Submissions
            </a>
            <br>

            <a href="[[ URL::to('admin/book') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-eye"></i> View Books
            </a>
        </div>
    </div>
    <br>

    <!-- ROW 2 -->
    <div class="row">
        <!-- COMMENTS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-comment"></i> Comments</h2>

            <a href="[[ URL::to('admin/comment/newBookComments') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-comment"></i> Approve Books <span style="color:#B14D4D" class="badge">[[ BookComment::where('comment_status', '=', 0)->count()]] </span>
            </a>
            <br>

            <a href="[[ URL::to('admin/comment/newNewsComments') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-comment"></i> Approve News <span style="color:#B14D4D" class="badge">[[ NewsComment::where('comment_status', '=', 0)->count() ]] </span>
            </a>
        </div>

        <!-- EDITORS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-comment"></i> Editors</h2>
            
            <a href="[[-- URL::to('admin/editor/booksEditor') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-hand-o-right"></i> Assign Editor
            </a>
            <br>

            <a href="[[-- URL::to('admin/editor/editorCost') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-eye"></i> View Editor Status
            </a>
        </div>
    </div>
    <br>

    <!-- ROW 3 -->
    <div class="row">
        <!-- NEWS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-newspaper-o"></i> News</h2>

            <a href="[[ URL::to('admin/news/addNews') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-plus-circle"></i> Add News
            </a>
            <br>

            <a href="[[ URL::to('admin/news') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-eye"></i> View News
            </a>
        </div>

        <!-- PRINTING -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-comment"></i> Printing</h2>
            
            <a href="[[ URL::to('admin/printing/addink') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-plus-circle"></i> Add Ink
            </a>
            <br>

            <a href="[[ URL::to('admin/printing/addpaper') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-plus-circle"></i> Add Paper
            </a>
            <br>

            <a href="[[ URL::to('admin/printing') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-eye"></i> View Paper / Ink
            </a>
        </div>
    </div>
    <br>

    <!-- ROW 4 -->
    <div class="row">
        <!-- ROYALTIES -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-usd"></i> Royalties</h2>

            <a href="[[-- URL::to('admin/userSales') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-usd"></i> Sales by Book
            </a>
        </div>

        <!-- SALES -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-area-chart"></i> Sales</h2>
           
            <a href="[[-- URL::to('admin/userSales') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-area-chart"></i> Sales by Author
            </a>
            <br>

            <a href="[[-- URL::to('admin/userSales') --]]" class="btn btn-primary btn-fixed" disabled>
                <i class="fa fa-area-chart"></i> Sales by Book
            </a>
        </div>
    </div>

    <!-- ROW 5 -->
    <div class="row">
        <!-- USERS -->
        <div class="col-sm-6 text-center">
            <h2><i class="fa fa-user"></i> Users</h2>

            <a href="[[ URL::to('admin/user/add') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-plus-circle"></i> Add User
            </a>
            <br>

            <a href="[[ URL::to('admin/user') ]]" class="btn btn-primary btn-fixed">
                <i class="fa fa-eye"></i> View Users
            </a>
        </div>
    </div>
</div>

@stop

@section('javascripts')
@stop