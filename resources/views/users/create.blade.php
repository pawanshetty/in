@extends('adminlte::page')

@section('title', 'Create Users')

@section('content_header')
    <h1> Create User</h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create User</li>
    </ol>
@stop

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
       
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data" >
                <div class="box-body ">
                    <div class="form-group">
                        @csrf
                        <label for="name">User Name:</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password"/>
                    </div>
                  
                    <div class="form-group">
                            <label>Select Role</label>
                            <select class="form-control">
                            <option value="2">User</option>
                            <option value="1">Admin</option>
                            </select>
                    </div>

                    <div class="form-group row">
                        <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar (optional)') }}</label>
                    
                        <div class="col-md-6">
                            <input id="avatar" type="file" class="form-control" name="avatar">
                        </div>
                    </div>

                    <div class="form-group">
                            <label>Add Groups</label>
                            <select id="groups[]" name="groups[]" class="form-control select_multiple state-tags-multiple" multiple="multiple">
                                @foreach(\App\Models\Group::all() as $group)
                                    <option value="{{ $group->id }}" >
                                        {{ $group->name }} 
                                    </option>
                                @endforeach
                            </select>                        
                    </div>
                    
                    <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="clear" class="btn btn-warning">Clear</button>
                    </div>
                </div>
            </form>
        
    </div>
</div>
@endsection
@section('js')

<script>
jQuery(function($) {
   var myTable =  $(".state-tags-multiple").select2({
        placeholder: "Add Groups here",
    });
});
</script>

@stop