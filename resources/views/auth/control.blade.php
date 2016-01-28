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
@if(Auth::User()->role === "admin")
<ul>
    <li class="start"> <a href="home" target="_blank"> <i class="icon-custom-home"></i> <span class="title">Home</span> <span class="selected"></span> </a> 

    </li>
    <li class="active"> <a href="javascript:;"> <i class="fa fa-folder-open"></i> <span class="title">Control</span> <span class="arrow "></span> </a>
        <ul class="sub-menu">
            <li> <a href="admin"> Admin </a> </li>
            <li> <a href="single"> Single </a> </li>

            <li class="active"> <a href="javascript:;"> users </a> </li>

        </ul>
    </li></ul>
@endsection
@section('content')
<div class="row-fluid">



    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="alert {{ $alert }}" role="alert">
                <h4> {{ $msg }} </h4>
            </div>
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Users</span></h4>
                    <button class="btn btn-lg" data-toggle="modal" data-target="#userModal"> Add new user </button>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body ">
                    <table class="table table-hover table-condensed nameit3" >
                        <thead>
                            <tr class="gradeX"> 
                                <th style="display: none">crf</th>
                                <th style="display: none">id</th>
                                <th>name</th>
                                <th>shift id</th>
                                <th>role</th>
                                <th>email</th>
                                <th>new password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                        <td style="display: none">{{ csrf_token() }}</td>

                        <td style="display: none">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->shift_id }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->email }}</td>
                        <td id="pass"></td>
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
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4><span class="semi-bold">Shifts</span></h4>
                    <button class="btn btn-lg" data-toggle="modal" data-target="#shiftModal"> Add new shift </button>

                    <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove"></a> </div>
                </div>

                <div class="grid-body ">
                    <table class="table table-hover table-condensed nameit4" >
                        <thead>
                            <tr class="gradeX"> 
                                <th style="display: none">crf</th>

                                <th>Shift Number</th>
                                <th>First part</th>
                                <th>End First</th>
                                <th>Second part</th>
                                <th>End Second</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $shift)
                        <td style="display: none">{{ csrf_token() }}</td>
                        <td class="actions">{{ $shift->id }}</td>
                        <td>{{ $shift->first_start }}</td>
                        <td>{{ $shift->first_end }}</td>
                        <td>{{ $shift->second_start }}</td>
                        <td>{{ $shift->second_end }}</td>

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
                </div></div></div>
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
        <div class="col-md-4">

            <!-- Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <br>
                            <i class="fa fa-users fa-7x"></i>
                            <p class="no-margin">Add new user</p>
                            <br>
                        </div>
                        <form id="form_iconic_validation" method="POST" action="addUser">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="modal-body">

                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <input type="text" name="name" id="form1Name" class="form-control" placeholder="name">                                 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="email" id="form1Email" class="form-control" placeholder="email">                                 
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="password">                                 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">                                 
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="input-with-icon right">                                       
                                            <i class=""></i>
                                            <select name="shift" id="gendericonic" class="select2 form-control"  >
                                                <option value="">Shift</option>
                                                <option value="1">day</option>
                                                <option value="2">night</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>

        <div class="col-md-4">

            <!-- Modal -->
            <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <br>
                            <i class="fa fa-users fa-7x"></i>
                            <p class="no-margin">Add new Shift</p>
                            <br>
                        </div>
                        <form id="form_iconic_validation" method="POST" action="addShift">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="modal-body">

                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <input type="text" name="firstStart" id="firstStart" class="form-control" placeholder="first Start">                                 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="firstEnd" id="firstEnd" class="form-control" placeholder="first end">                                 
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <input type="text" name="secondStart" id="secondStart" class="form-control" placeholder="secondStart">                                 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="secondEnd" id="secondEnd" class="form-control" placeholder="second End">                                 
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
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
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/js/form_validations.js" type="text/javascript"></script>

<!-- BEGIN CORE TEMPLATE JS -->
@endsection