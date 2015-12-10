@extends('master')
@section('title','Attendance | Home')
@section('css')
<!-- BEGIN PLUGIN CSS -->
<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
<!-- END PLUGIN CSS -->
@endsection
@section('name', Auth::User()->name)
@section('content')

<form method="POST" action="http://localhost:8000/">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" value="start" name="start" class="btn btn-primary btn-cons"><span class="bold">Start Shift</span></button>
</form>
<form method="POST" action="http://localhost:8000/end">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" value="end" name="end" class="btn btn-danger btn-cons"><span class="bold">End Shift</span></button>
</form>


<div class="row-fluid">
    <div class="span12">
        <div class="alert {{ $Class }}" role="alert">
            <h4> {{ $message }} </h4>
        </div>
        <div class="grid simple ">
            <div class="grid-title">
                <h4><span class="semi-bold">Attendance</span></h4>
                <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
            </div>

            <div class="grid-body ">
                <table class="table table-hover table-condensed" id="example">
                    <thead>
                        <tr>
                            <th style="width:10%">day</th>
                            <th style="width:7%" data-hide="phone,tablet">Attend</th>
                            <th style="width:6%">Work Time</th>
                            <th style="width:6%">Break Time</th>
                            <th style="width:10%" data-hide="phone,tablet">leave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attend as $attendance)
                        <tr>
                            <td>{{ $attendance->day }}:{{ $attendance->attend_date  }}</td>
                            <td>{{ $attendance->attend_h }}</td>
                            <td>{{ $attendance->calc_hour }}:{{ $attendance->calc_min }}</td>
                            <td>{{ $attendance->break_h }}</td>
                            <td>{{ $attendance->leave_h }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="assets/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
<script type="text/javascript" src="assets/plugins/datatables-responsive/js/lodash.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/js/datatables.js" type="text/javascript"></script>
<script src="assets/js/demo.js" type="text/javascript"></script>

<!-- BEGIN CORE TEMPLATE JS -->
@endsection