@extends('master')
@section('name', Auth::User()->name)
@section('title')Attendance | Register @stop
@section('css')
<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>

@stop
@section('sidebar')
<ul>
    <li> <a href="home"> <i class="fa fa-home"></i><span class="title">home</span></a></li></ul>
    @stop
@section('content')
<div class="grid simple">
    <div class="grid-title no-border">
        <h4><span class="semi-bold">Change Password</span></h4>
        @if($errors->any())
        <div class="alert alert-danger">
            <h4>there's Some errors</h4>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
    </div>
    <div class="grid-body no-border"> <br>
        <form id="form_iconic_validation" action="changePass"  method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="form-label">password</label>
                <div class="input-with-icon  right">                                       
                    <i class=""></i>
                    <input type="password" name="password" id="password" class="form-control">                                 
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm password</label>
                <div class="input-with-icon  right">                                       
                    <i class=""></i>
                    <input type="password" name="password_confirmation"  class="form-control">                                 
                </div>
            </div>
            
            <div class="form-actions">  
                <div class="pull-right">
                    <input type="submit" class="btn btn-danger btn-cons">
                    <button type="button" class="btn btn-white btn-cons">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('js')

<script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/boostrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/js/form_validations.js" type="text/javascript"></script>

@stop


