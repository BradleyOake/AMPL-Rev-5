<?php use App\Author; ?>

@extends('layouts.layout_main')
@section('title', 'Edit Printing Services')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-print"></i> Printing Services </h1>
    </div>

    <!-- Pending books -->
    <div class="col-lg-offset-1 col-lg-10 text-center">
        <h1><i class="fa fa-file"></i> Papers</h1>
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Paper Name</th>
                <th class="text-center">Paper Type</th>
                <th class="text-center">Paper Usage</th>
                <th class="text-center">Paper Size</th>
                <th class="text-center">Unit Cost</th>
            </tr>

            @foreach ($papers as $paper)
                <tr>
                    <td>
                        <a style="margin:10px;" href="[[ URL::to('admin/printing/editpaper', $paper->paper_id) ]]">
                            [[ $paper->paper_name ]]
                        </a>
                    </td>

                    <td>
                        [[ $paper->paperType() ]]
                    </td>
                    
                    <td>
                        [[ $paper->paperUsage() ]]
                    </td>

                    <td>
                        [[ $paper->paper_size ]]
                    </td>

                    <td>
                        [[ $paper->unit_cost ]]
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="col-lg-offset-3 col-lg-6 text-center">
        <br>
        <h1><i class="fa fa-eyedropper"></i> Inks</h1>
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Ink</th>
                <th class="text-center">Cost/Side</th>
            </tr>

            @foreach ($inks as $ink)
                <tr>
                    <td>
                        <a style="margin:10px;" href="[[ URL::to('admin/printing/editink', $ink->ink_id) ]]">
                            [[ $ink->ink_name ]]
                        </a>
                    </td>

                    <td>
                        [[ $ink->cost_per_side ]]
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>

@stop

@section('scripts')
@stop
