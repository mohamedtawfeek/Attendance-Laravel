@extends('master')
@section('title','Attendance | Admin Panel')
@section('css')
<!-- BEGIN PLUGIN CSS -->
<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
<link rel="stylesheet" href="assets/plugins/magnific-popup/magnific-popup.css" />

<!-- END PLUGIN CSS -->
@endsection
@section('name', Auth::User()->name)
@section('sidebar')
<ul>
    <li class="start"> <a href="home" target="_blank"> <i class="icon-custom-home"></i> <span class="title">Home</span> <span class="selected"></span> </a> 

    </li></ul>

@endsection
@section('content')
<div class="row-fluid">
    @foreach ($attend as $name => $user)

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Attendance - {{ $name }}</span></h4>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body ">
                    <table class="table table-hover table-condensed nameit" >
                        <thead>
                            <tr class="gradeX"> 
                                <th style="display: none">crf</th>

                                <th style="display: none">id</th>

                                <th>day</th>
                                <th>Attend</th>
                                <th>Work Time</th>
                                <th>Break Time</th>
                                <th>leave</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>


                            @foreach($user as $attendance)

                            <tr class="gradeX">
                                <td style="display: none">{{ csrf_token() }}</td>

                                <td style="display: none">{{ $attendance->id }}</td>

                                <td class="actions">{{ $attendance->day }} - {{ $attendance->attend_date  }}</td>
                                <td class="attend{{ $attendance->id }}">{{ $attendance->attend_h }}</td>
                                <td class="actions calc{{ $attendance->id }}">{{ $attendance->calc_hour }}:{{ $attendance->calc_min }}</td>
                                <td class="break{{ $attendance->id }}">{{ $attendance->break_h }}</td>
                                <td class="leave{{ $attendance->id }}">{{ $attendance->leave_h }}</td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div></div></div></div>
    @endforeach
    @foreach ($extra as $name => $user)

    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Extra - {{ $name }}</span></h4>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body ">
                    <table class="table table-hover table-condensed nameit2" >
                        <thead>
                            <tr class="gradeX"> 
                                <th style="display: none">crf</th>

                                <th style="display: none">id</th>

                                <th>day</th>
                                <th>Extra</th>
                                <th>status</th>
                                <th>Work Time</th>
                                <th>leave</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>


                            @foreach($user as $extra)

                            <tr class="gradeX">
                                <td style="display: none">@if($extra){{ csrf_token() }}@endif</td>

                                <td style="display: none">{{ $extra->id }}</td>

                                <td class="actions">{{ $extra->day }} - {{ $extra->extra_date  }}</td>
                                <td class="attend{{ $extra->id }}">{{ $extra->extra_h }}</td>
                                <td class="status status{{ $extra->id }}">{{ $extra->status }}</td>
                                <td class="actions calc{{ $extra->id }}">{{ $extra->calc_hour }}:{{ $extra->calc_min }}</td>

                                <td class="leave{{ $extra->id }}">{{ $extra->leave_h }}</td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                  
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>

                                    <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div></div></div></div>
    @endforeach


</div>
@endsection
@section('js')
<script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<script src="assets/plugins/magnific-popup/magnific-popup.js"></script>
<script src="assets/js/demo.js" type="text/javascript"></script>

<script src="assets/plugins/jquery-datatables-editable/jquery.dataTables.js"></script> 
<script src="assets/plugins/jquery-datatables-editable/datatables.editable.init.js"></script>


<!-- BEGIN CORE TEMPLATE JS -->
@endsection