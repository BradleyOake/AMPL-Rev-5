@extends('layouts.layout_main')
@section('title', 'AMPL Homepage')

@section('content')
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




      $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      $year = 2016;
      $monthTable = "";
      $index = 0;
      foreach ($months as $month)
      {
        $monthTable .= "<tr>" .
                       "<td>" . $month . "</td>" .
                       "<td align='center'>" . $book->electronicSalesMonth($index)->count() . "</td>" .
                       "<td align='center'>" . $book->audioSalesMonth($index)->count() . "</td>" .
                       "<td align='center'>" . $book->softSalesMonth($index)->count() . "</td>" .
                       "<td align='center'>" . $book->hardSalesMonth($index)->count() . "</td>";

        if($book->royaltiesEarnedMonth(Auth::user()->email, $index) != 0)
        {
          $monthTable .= "<td align='center'>$" . number_format($book->royaltiesEarnedMonth(Auth::user()->email, $index), 2, '.', ',') . "</td>";
        }
        else
        {
          $monthTable .= "<td align='center'>-</td>";
        }

        $monthTable .= "</tr>";
                       $index++;
      }

?>
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-download"></i> Monthly sales for "[[ $book->title ]]"</h1>
    </div>
      <form class="form-horizontal" id="yearSelect">
          <div class="control-group text-center">
              <label class="control-label" for="selectbasic">Select Year</label>
              <div class="controls">
                  <?php echo $select; ?>
                  <br />
              </div>
          </div>
      </form>
    <table width="100%"  class="table table-striped ampl-table" id="sales_table">
        <tr>
          <th>Month</th>
          <th>Ebook Sales</th>
          <th>Audio Sales</th>
          <th>Soft Cover Sales</th>
          <th>Hard Cover Sales</th>
          <th>Royalties</th>
        </tr>
        <?php echo $monthTable; ?>
    </table>
    <table width="100%"  class="table table-striped ampl-table">
        <tr>
            <th>Total Royalties Earned in <?php echo '2016' ?></th>
            <td></td>
            <td></td>
            <th>
              @if($book->royaltiesEarned($year) != 0)

                <?php $totalRoyalties = 0; ?>
                @foreach($months as $month)
                  <?php
                    $totalRoyalties += $book->royaltiesEarnedMonth(Auth::user()->email, $month);
                  ?>
                @endforeach
              $[[ number_format($totalRoyalties, 2, '.', ',')]]
              @else
              -
              @endif
            </th>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
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
        //alert(data);
        $("#sales_table").html($(data).find('#sales_table'));
      }

    });
  });
});

</script>
@stop
