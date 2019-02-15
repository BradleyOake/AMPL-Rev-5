@extends('layouts.layout_main')
@section('title', 'Purchases')
@section('metaDescription', '')

@section('content')
<!-- Page Content -->
<div class="container main-content">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">[[ $user->email ]]'s Details</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <h2><i class="fa fa-user"></i> Account Details</h2>
    </div>
</div>
    <table width="100%"  class="table table-striped ampl-table">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Type</th>
            <th>Bio</th>
            <th>Image</th>
        </tr>

        <tr>
            <td>[[ $user->id]]</td>
            <td>[[ $user->email]]</td>
            <td>[[ $user->first_name]]</td>
            <td>[[ $user->last_name]]</td>
            <td></td>
            <td>[[ $user->bioExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
            <td>[[ $user->coverExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
        </tr>
    </table>

<div class="row">
    <div class="col-lg-12">
        <h2><i class="fa fa-book"></i> Current Books</h2>
    </div>
</div>
    <table width="100%" class="table table-striped table-bordered ampl-table" style="text-align: center">

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Cover</th>
            <th>Status</th>
            <th>Text</th>
            <th>Epub</th>
            <th>Pdf</th>
            <th>Mp3</th>
            <th>Author(s)</th>

        </tr>
        @foreach ($user->books as $book)
        <tr>
            <td style=" vertical-align: middle;">[[ $book->book_id ]]</td>
            <td style=" vertical-align: middle;">[[ $book->title ]]</td>
            <td style=" vertical-align: middle;">[[ $book->coverExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
            <td style=" vertical-align: middle;">[[ $book->getStatus() ]]</td>
            <td style=" vertical-align: middle;">[[ $book->txtFinalExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
            <td style=" vertical-align: middle;">[[ $book->epubFinalExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
            <td style=" vertical-align: middle;">[[ $book->pdfFinalExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>
            <td style=" vertical-align: middle;">[[ $book->mp3FinalExists()? '<i class="fa fa-check"></i>' : '-' ]]</td>

            <td>
                @foreach ($book->authors as $author) [[ $author->email ]] ([[ $author->name_on_book ]])
                <!--  <div class="pull-right">
   <button data-book-id="[[$book->book_id ]]" data-book-title="[[$book->title ]]" data-email="[[$author->email ]]" type="submit"  style="padding:0px 5px 0px 5px" class="delete_author btn-sm btn btn-danger" title="Remove Author" data-toggle="tooltip"><i class="fa fa-trash-o"></i></button>
 <a href="[[ URL::to('admin/editAuthor', array($book->book_id,$author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-warning" title="Change Author Details" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i></a>
 <a href="[[ URL::to('admin/editUser', array($author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-primary" title="View User Account" data-toggle="tooltip"><i class="fa fa-user"></i></a>

            </div>-->
                <br>@endforeach

            </td>

            <td style=" vertical-align: middle;">
               <a href="[[ URL::to('admin/editBook', array($book->book_id)) ]]" class="btn-sm btn btn-warning" title="Edit Book" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i> </a>
                    <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-success" title="Download Page" data-toggle="tooltip"><i class="fa fa-download"></i> </a>
                    <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-primary" title="View Comments" data-toggle="tooltip"> <i class="fa fa-comment"></i> [[ $book->getNumberComments() ]]</a>

            </td>

        </tr>

        @endforeach
    </table>
<hr>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <h2><i class="fa fa-money"></i> Royalties Accrual</h2>
        </div>
    </div>
      <form id="user" class="form-horizontal" method="post">
<fieldset>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_type">Book</label>
  <div class="col-md-4">
    <select name="user_type" id="user_type" class="form-control">
        <option value ="">All</option>
    @foreach ($user->books as $book)
        <option value ="[[ $book->book_id]]">[[ $book->title]]</option>
    @endforeach
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="start_date" >Start Date</label>
  <div class="col-md-4">
  <input name="start_date" id="start_date" type="date" class="form-control input-md" value="[[ date('Y-01-01', strtotime('-1 year')) ]]">

  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="end_date" >End Date</label>
  <div class="col-md-4">
  <input name="end_date" id="end_date" type="date" class="form-control input-md" value="[[ date('Y-01-01') ]]">

  </div>
</div>

      <div class="form-group text-center">
                    <div class="col-sm-112">
                            <button type="submit" class="btn btn-primary" name="login">Submit</button>
                    </div>
                </div>


          </fieldset>
    </form>



     <table width="100%"  class="table table-striped ampl-table" >
        <tr>
            <th>Book ID</th>
             <th>Title</th>
             <th>Date</th>
            <th>Type</th>
             <th>Sold for</th>

             <th>Rate</th>
             <th>Earned</th>
        </tr>
         <?php $total=0 ?>
          @foreach ($user->royalties('', '', '') as $royalty)
         <?php $total += $royalty->amount * $royalty->rate / 100 ?>
         <tr>
             <td>[[ $royalty->book_id ]]</td>
             <td>[[ $royalty->title ]]</td>
             <td>[[ date('F j, Y \a\t g:ia', strtotime($royalty->created_on)) ]]</td>
             <td>[[ $royalty->description ]]</td>
             <td>$[[ $royalty->amount ]] </td>
   <td>x [[ $royalty->rate ]]% </td>
             <td>$[[ number_format($royalty->amount * $royalty->rate / 100, 2, '.', ',') ]]</td>
</tr>

    @endforeach
          <tr>
            <td colspan="5"></td>
            <th>Total</th>

            <th>$[[ number_format($total, 2, '.', ',') ]]</th>
        </tr>
    </table>


    <table width="100%"  class="table table-striped ampl-table" >
        <tr>
            <th style="vertical-align: middle;" rowspan="2">ID</th>
            <th style="vertical-align: middle;" rowspan="2">Title</th>
            <th style="text-align: center; border-left: 1px solid grey;"  colspan="2">Electronic</th>
            <th style="text-align: center; border-left: 1px solid grey;"  colspan="2">Audio</th>
            <th style="text-align: center; border-left: 3px solid black;"  colspan="2">Total</th>
        </tr>
        <tr>

            <th style="border-left: 3px solid black;"># Sold</th>
            <th>Earned</th>

            <th style="border-left: 3px solid black;"># Sold</th>
            <th>Earned</th>
            <th  style="border-left: 3px solid black;"># Sold</th>
            <th>Earned</th>
        </tr>

<?php $totalSales= 0; $totalEarned= 0; ?>

            @foreach($user->books as $book)



        <tr>
            <td>[[ $book->book_id ]]</td>
<td>[[ $book->title ]]</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><button class="btn btn-primary">Details</button></td>
        </tr>
            @endforeach
        <tr>
            <td colspan="5"></td>
            <th style="background: #00CFAF">Total</th>
            <th>[[ $totalSales ]]</th>
            <th>$[[ number_format($totalEarned, 2, '.', ',') ]]</th>
        </tr>
    </table>




    <div class="row">
        <div class="col-lg-12">
            <h2><i class="fa fa-arrows-h"></i> Account Transactions</h2>
        </div>
    </div>

    <table class="table ampl-table table-striped">
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Date</th>
            <th>Credit</th>
            <th>Debit</th>
        </tr>
        <?php $totalPaid= 0; ?>
        @foreach($user->payments as $payment)
            <?php

                    $totalPaid += $payment->amount;

            ?>
        <tr>
            <td>[[ $payment->payment_id]]</td>
            <td>[[ $payment->description]]</td>
            <td>[[ date('F j, Y \a\t g:ia', strtotime($payment->created_on)) ]]</td>
            <td>@if($payment->amount < 0)$ [[ number_format($payment->amount, 2, '.', ',') ]] @endif</td>
            <td>@if($payment->amount >= 0)$ [[ number_format($payment->amount, 2, '.', ',') ]] @endif</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
            <th>Total</th>
            <th>$[[ number_format($totalPaid, 2, '.', ',') ]]</th>
             <th></th>
        </tr>
    </table>

    <div class="row">
        <div class="col-lg-12">
            <h2><i class="fa fa-university"></i> Account Balance</h2>
        </div>
    </div>

    <div class="col-sm-6">

         <table class="table ampl-table table-striped">
        <tr>
            <td>Accrued Earnings</td>
            <td>$[[ number_format($total, 2, '.', ',') ]] </td>

        </tr>

        <tr>
            <td>Account Balance</td>
            <td>$[[ number_format($user->accountBalance(), 2, '.', ',') ]] </td>


        </tr>

               <tr>
            <th>Net Payable</th>
            <th >$[[ number_format($total + $user->accountBalance(), 2, '.', ',') ]] </th>


        </tr>

    </table>

</div>
    </div>
    <!-- /.container -->

@stop
