@extends('layouts.layout_main')
@section('title', 'My Sales')
@section('metaDescription', '')

<?php
 $starting_year  = 2010;
 $ending_year = date('Y');
 $current_year = date('Y');

$selectedYear = isset($_GET['selectedYear']) ? $_GET['selectedYear'] : date('Y');

$select = '<select id="selectedYear" class="input-lg" name="selectedYear">';

 for($starting_year; $starting_year <= $ending_year; $starting_year++) {
     $select .= '<option value="'.$starting_year.'"';
     if( $starting_year == $selectedYear) {
           $select .= ' selected="selected"';
     }
     $select .= ' >'.$starting_year.'</option>';
 }
 $select .= '</select>';

?>


@section('content')
<div class="container main-content">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sales Yearly Summary</h1>
        </div>
    </div>
    <form class="form-horizontal" id="yearSelect">
        <fieldset>
    @if(Auth::user()->books->count() == 0)
    <h3 class="text-center">You have no books for sale</h3>
    @else
            <!-- Select Basic -->

            <div class="control-group text-center">
                <label class="control-label" for="selectbasic">Select Year</label>
                <div class="controls">
                    <?php echo $select; ?>
                </div>
            </div>
        </fieldset>
    </form>

<br/>
    <table width="100%"  class="table table-striped ampl-table" id="sales_table">
        <tr>
            <th>Title</th>
            <th style="text-align:right;">Electronic Sales</th>
            <th style="text-align:right;">Audio Sales</th>
            <th style="text-align:right;">Soft Cover Sales</th>
            <th style="text-align:right;">Hard Cover Sales</th>
            <th style="text-align:right;">Royalties Earned</th>
        </tr>

        <?php $totalSales= 0; $totalEarned= 0; ?>

        @foreach(Auth::user()->books as $book)
        <tr>
            <td>[[ $book->title ]]</td>
            <td style="text-align:right;">[[ $book->electronicSalesYear($selectedYear)->count() ]]</td>
            <td style="text-align:right;">[[ $book->audioSalesYear($selectedYear)->count() ]]</td>
            <td style="text-align:right;">[[ $book->softSalesYear($selectedYear)->count() ]]</td>
            <td style="text-align:right;">[[ $book->hardSalesYear($selectedYear)->count() ]]</td>
             @if($book->royaltiesEarned($selectedYear) != 0)
              <td align="right">$[[ number_format($book->royaltiesEarned($selectedYear), 2, '.', ',') ]]</td>
              @else
              <td align="right">-</td>
              @endif
            <td><a href="[[ URL::to('user/monthlysales', array('id' => $book->book_id)) ]]">Details</a></td>
        @endforeach
        </tr>
    </table>
    <table width="100%"  class="table table-striped ampl-table" id="royalties_table">
        <tr>
            <th>Total Royalties Earned in <?php echo $selectedYear ?></th>
            <td></td>
            <td></td>
            <th>
              @if($book->royaltiesEarned($selectedYear) != 0)
                <?php $totalRoyalties = 0; ?>
                @foreach(Auth::user()->books as $book)
                  <?php
                    $totalRoyalties += $book->royaltiesEarned($selectedYear);
                  ?>
                @endforeach
              </th>
              <th style="text-align:right;">
                $[[ number_format($totalRoyalties, 2, '.', ',')]]
              </th>
              @else
                <th style="text-align:right;">-</th>
              @endif
            </th>
            <th>
            </th>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    @endif
</div>
@stop

@section('scripts')
<script>
$(document).ready(function()
{
  $('#yearSelect').change(function(e)
  {
    e.preventDefault();
    var year = $("#selectedYear").val();

    $.ajax(
    {
      type: "get",
      data: {selectedYear : year},

      success: function(data)
      {
        $("#sales_table").html($(data).find('#sales_table'));
        $("#royalties_table").html($(data).find('#royalties_table'));
      }

    });
  });
});

</script>
@stop
