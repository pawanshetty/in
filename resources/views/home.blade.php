@extends('adminlte::page')

@section('title', 'InterNations Test')

@section('content_header')
    <h1>Home </h1>
@stop

@section('content')
<div class="row">
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Users</span>
        <span class="info-box-number">{{count(\App\Models\User::all()) }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-twitter"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Groups</span>
        <span class="info-box-number">{{count(\App\Models\Group::all()) }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
</div>
<div class="row">
<div class="col-md-6">
    <!-- USERS LIST -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Members</h3>

        <div class="box-tools pull-right">
          
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
    
      <div class="box-body no-padding">
        <ul class="users-list clearfix">
          @foreach(\App\Models\User::orderBy('id', 'desc')->take(5)->get() as $user)
          <li>
            <img src="{{$user->getProfileImage()}}" class="img-responsive" alt="User Image" style="width: 100px;height:100px;">
            <a class="users-list-name" href="#">{{$user->name}}</a>
            <span class="users-list-date">Today</span>
          </li>
          @endforeach
          
        </ul>
        <!-- /.users-list -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="/users" class="uppercase">View All Users</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!--/.box -->
  </div>
</div>
@stop