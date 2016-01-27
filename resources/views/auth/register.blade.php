@extends('master')
@section('name', Auth::User()->name)

{{ Auth::check() ? $AdminRegister = Auth::User()->role  :  "Please Log in" }}
@if($AdminRegister === 'admin')
@section('title')Attendance | Register @stop
@section('css')
<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>

@stop
@section('content')
<div class="grid simple">
    <div class="grid-title no-border">
        <h4><span class="semi-bold">Register</span></h4>
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
        <form id="form_iconic_validation" action="register"  method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="form-label">Your Name</label>
                <span class="help">e.g. "Jonh Smith"</span>
                <div class="input-with-icon  right">                                       
                    <i class=""></i>
                    <input type="text" name="name" id="form1Name" class="form-control">                                 
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Your email</label>
                <span class="help">e.g. "john@examp.com"</span>
                <div class="input-with-icon  right">                                       
                    <i class=""></i>
                    <input type="text" name="email" id="form1Email" class="form-control">                                 
                </div>
            </div>
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

            <div class="form-group">
                <label class="form-label">Shift</label>
                <span class="help">e.g. "Select one"</span>
                <div class="input-with-icon  right">                                       
                    <i class=""></i>
                    <select name="shift" id="gendericonic" class="select2 form-control"  >
                        <option value="">Select...</option>
                        <option value="1">day</option>
                        <option value="2">night</option>
                    </select>
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
@else
@section('content') 
<h3>you can't register</h3>
@stop
@endif
@section('js')

<script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/boostrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/js/form_validations.js" type="text/javascript"></script>

@stop


