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
@section('sidebar')
<ul>
       @if(Auth::User()->role === "admin")
    <li> <a href="javascript:;"> <i class="fa fa-folder-open"></i> <span class="title">Control</span> <span class="arrow "></span> </a>
      
        <ul class="sub-menu">
            <li> <a href="admin"> Admin </a> </li>
            <li> <a href="single"> Single </a> </li>
            <li> <a href="control"> users </a> </li>
        </ul>
       
    </li>@endif</ul>

@endsection
@section('content')
<div class="row-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="grid simple">

                <div class="grid-body no-border">
                    <div class="col-md-3">
                        <h4>Start <span class="semi-bold">Here</span></h4>

                        <form method="POST" action="http://localhost:8000/">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" value="start" name="start" class="btn btn-primary btn-cons"><span class="bold">Start Shift</span></button>
                        </form>


                        <form method="POST" action="http://localhost:8000/end">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" value="end" name="end" class="btn btn-danger btn-cons"><span class="bold">End Shift</span></button>
                        </form>
                    </div>
                    <div class="col-md-6">

                        <div class="row">
                            <form method="POST" action="http://localhost:8000/break">

                                <div class="col-md-4">
                                    <h4>Break <span class="semi-bold">Hour</span></h4>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="" style="width:300px" id="e12" tabindex="-1" class="select2-offscreen">
                                    <select name="breakH" style="width:100%">
                                        <option value="0">1</option>
                                        <option value="1">2</option>
                                        <option value="2">3</option>
                                    </select></div>
                                <div class="col-md-4">
                                    <h4>Break <span class="semi-bold">Minute</span></h4>

                                    <input type="hidden" value="" style="width:300px" id="e12" tabindex="-1" class="select2-offscreen">
                                    <select name="breakM" id="remote" style="width:100%">
                                        <option value="00">00</option>
                                        <option value="30">30</option>

                                    </select>
                                </div>
                                <div class="col-md-4" style="padding-top: -3px;">
                                    <br><br>
                                    <button type="submit" value="break" name="break" class="btn btn-success btn-cons"><span class="bold">Done</span></button>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4>Extra <span class="semi-bold">Here</span></h4>

                        <form method="POST" action="http://localhost:8000/extra">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" value="extra" name="extra" class="btn btn-primary btn-cons"><span class="bold">Start Extra</span></button>
                        </form>


                        <form method="POST" action="http://localhost:8000/extraEnd">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" value="extraEnd" name="extraEnd" class="btn btn-danger btn-cons"><span class="bold">End Extra</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  </div>

<div class="row-fluid">
    <div class="span12">
        <div class="alert {{ $Class }}" role="alert">
            <h4> {{ $message }} </h4>
        </div>
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4><span class="semi-bold">Archive</span></h4>
                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>
                <form method="POST" action="showArchive">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="grid-body ">
                        <div class="form-group col-md-3">
                            <label class="form-label">Month</label> <select name='month'>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select></div>
                        <div class="form-group col-md-3">
                            <label class="form-label">Year</label>
                            <select name='year'>
                                <option value="2016" selected="">2016</option>
                                <option value="2017">2017</option>
                            </select></div>
                        <div class="form-group col-md-3">
                            <label class="form-label">Choose</label>
                            <select name="check">
                                <option value="attend" selected="">attend</option>
                                <option value="extra">extra</option>
                            </select></div><br>
                        <button style="margin-top: 8px" type="submit" value="archive" name="archive" class="btn btn-primary btn-cons"><span class="bold">Select</span></button>

                    </div>
                </form>
            </div>
            <div class="grid simple ">
                <div class="grid-title">
                    <h4><span class="semi-bold">Attendance This month</span></h4>
                    <h4><span class="semi-bold">Hours: </span>{{ $workHours }} <span class="semi-bold">: </span>{{ $minsCalc }}</h4>
                    <h4><span class="semi-bold">Late Hours: </span>{{ $lateHour }} <span class="semi-bold">: </span>{{ $lateMins }}</h4>
                    <h4></h4>
                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>


                <div class="grid-body ">
                    <table class="table table-hover table-condensed" id="example">
                        <thead>
                            <tr>
                                <th style="width:10%">day</th>
                                <th style="width:7%" >Attend</th>
                                <th style="width:6%">Work Time</th>
                                <th style="width:6%">Break Time</th>
                                <th style="width:10%">leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attend as $attendance)
                            <tr>
                                <td>{{ $attendance->day }} - {{ $attendance->attend_date  }}</td>
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
        <div class="span12">

            <div class="grid simple ">
                <div class="grid-title">
                    <h4><span class="semi-bold">Extra</span></h4>
                    <h4><span class="semi-bold">Hours: </span>{{ $extraHours }} <span class="semi-bold">: </span>{{ $minsExtra }}</h4>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body ">
                    <table class="table table-hover table-condensed" id="example2">
                        <thead>
                            <tr>
                                <th style="width:10%">day</th>
                                <th style="width:7%">Extra Start</th>
                                <th style="width:9%">Status</th>
                                <th style="width:6%">Work Time</th>
                                <th style="width:10%">leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extra as $extraTime)
                            <tr>
                                <td>{{ $extraTime->day }} : {{ $extraTime->extra_date }}</td>
                                <td>{{ $extraTime->extra_h }}</td>
                                <td>{{ $extraTime->status }}</td>
                                <td>{{ $extraTime->calc_hour }}:{{ $extraTime->calc_min }}</td>
                                <td>{{ $extraTime->leave_h }}</td>
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