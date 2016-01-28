@extends('master')
@section('title','Attendance | Admin Panel')
@section('css')
<!-- BEGIN PLUGIN CSS -->
<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="assets/plugins/magnific-popup/magnific-popup.css" />

<!-- END PLUGIN CSS -->
@endsection
@section('name', Auth::User()->name)
@section('sidebar')
<ul>
    <li class="start"> <a href="home" target="_blank"> <i class="icon-custom-home"></i> <span class="title">Home</span> <span class="selected"></span> </a> 

    </li>
    <li class="active"> <a href="javascript:;"> <i class="fa fa-folder-open"></i> <span class="title">Control</span> <span class="arrow "></span> </a>
        <ul class="sub-menu">
            <li> <a href="admin"> Admin </a> </li>
            <li class="active"> <a href="javascript:;"> Single </a> </li>
            <li> <a href="control"> users </a> </li>

        </ul>
    </li></ul>
@endsection

@section('content')
@if(Auth::User()->role === "admin")
<div class="row-fluid">
    <div class="grid simple ">
        <div class="grid-title">
            <h4><span class="semi-bold">Archive Attendance</span></h4>
            <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
        </div>
        <div class="grid-body ">
            <form method="POST" action="showSingle">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group col-md-3">

                    <label class="form-label">User</label>
                    <select name="id">
                        @foreach ($users as $user)
                        @if($user->name === $name)
                        <option value="{{ $user->id }}:{{ $user->name }}" selected="">{{ $user->name }}</option>
                        @else
                        <option value="{{ $user->id }}:{{ $user->name }}" >{{ $user->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
               
                <div class="form-group col-md-3">
                    <label class="form-label">Month</label> <select name="month">
                        @for($m = 1; $m <= 12; $m++)

                        @if("0".$m === $month)
                        <option value="0{{ $m }}" selected>{{ $m }}</option>
                        @elseif($m < 10)
                        <option value="0{{ $m }}" >{{ $m }}</option>
                        @else
                        <option value="{{ $m }}">{{ $m }}</option>
                        @endif
                        @endfor
                    </select></div> 
                <div class="form-group col-md-3">
                    <label class="form-label">Year</label>
                    <select name="year">
                        @if($year === "2016")
                        <option value="2016" selected="">2016</option>
                        <option value="2017">2017</option>
                        @elseif($year === "2017")
                        <option value="2016">2016</option>
                        <option value="2017" selected="">2017</option>
                        @else
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        @endif
                    </select></div>
                <div class="form-group col-md-3">
                    <label class="form-label">Choose</label>
                    <select name="check">
                        @if($attends === "attend")
                        <option value="attend" selected="">attend</option>
                        <option value="extra">extra</option>

                        @elseif($attends === "extra")
                        <option value="attend">attend</option>

                        <option value="extra" selected="">extra</option>
                        @else
                        <option value="attend">attend</option>
                        <option value="extra">extra</option>
                        @endif
                    </select></div><br>
                <button style="margin-top: 8px" type="submit" value="archive" name="archive" class="btn btn-primary btn-cons"><span class="bold">Select</span></button>
            </form>
        </div>
    </div>
    @if( $single === "attend"  )
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Attendance - {{ $name }}</span></h4>
                    <h4><span class="semi-bold">Hours: </span>{{ $calcHourArc }} <span class="semi-bold">: </span>{{ $calcMinArc }}</h4>
                    <h4><span class="semi-bold">Late Hours: </span>{{ $calcLateH }} <span class="semi-bold">: </span>{{ $calcLateM }}</h4>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body">
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


                            @foreach($attend as $attendance)

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
    @elseif($single === "extra")
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Extra - {{ $name }}</span></h4>
                    <h4><span class="semi-bold">Hours: </span>{{ $calcExH }} <span class="semi-bold">: </span>{{ $calcExM }}</h4>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body">
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
                            @foreach($extras as $extra)

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
    @else
    there's no data
    @endif
</div>
<div id="dialog" class="modal-block mfp-hide">
    <section class="panel panel-info panel-color">
        <header class="panel-heading">
            <h2 class="panel-title">Are you sure?</h2>
        </header>
        <div class="panel-body">
            <div class="modal-wrapper">
                <div class="modal-text">
                    <p>Are you sure that you want to delete this row?</p>
                </div>
            </div>

            <div class="row m-t-20">
                <div class="col-md-12 text-right">
                    <button id="dialogConfirm" class="btn btn-primary">Confirm</button>
                    <button id="dialogCancel" class="btn btn-default">Cancel</button>
                </div>
            </div>
        </div>

    </section>
</div>
@endif
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