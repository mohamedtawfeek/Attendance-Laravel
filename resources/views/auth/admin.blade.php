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
@if(Auth::User()->role === "admin")
@section('sidebar')
<ul>
    <li class="start"> <a href="home" > <i class="icon-custom-home"></i> <span class="title">Home</span> <span class="selected"></span> </a> 

    </li>
    <li class="active"> <a href="javascript:;"> <i class="fa fa-folder-open"></i> <span class="title">Control</span> <span class="arrow "></span> </a>
        <ul class="sub-menu ">
            <li class="active"> <a href="javascript:;"> Admin </a> </li>
            <li> <a href="single"> Search </a> </li>

            <li > <a href="control"> users </a> </li>

        </ul>
    </li></ul>

@endsection
@section('content')
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
                        <option value="{{ $user->id }}:{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="form-label">Month</label> <select name="month">
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select></div> 
                <div class="form-group col-md-3">
                    <label class="form-label">Year</label>
                    <select name="year">
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
            </form>
        </div>
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