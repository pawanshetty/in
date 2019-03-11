@extends('adminlte::page')

@section('title', 'Create Users')

@section('content_header')
    <h1> Edit User</h1>

    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User</li>
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
            <form method="post" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="box-body ">
                    <div class="form-group">
                        @csrf
                        <label for="name">User Name:</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password"/>
                    </div>
                  
                    <div class="form-group">
                            <label>Select Role</label>
                            <select name="role" class="form-control" >
                            <option value="2" {{($user->role_id==2) ? "selected" :""}}>User</option>
                            <option value="1" {{($user->role_id==1) ? "selected" :""}}>Admin</option>
                            </select>
                    </div>

                    <div class="form-group row">
                        <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar (optional)') }}</label>
                        <img src="{{ $user->getProfileImage() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control" name="avatar">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                            <label>Add Groups</label>
                            <select id="groups[]" name="groups[]" class="form-control select_multiple state-tags-multiple" multiple="multiple">
                                @foreach(\App\Models\Group::all() as $group)
                                    <option value="{{ $group->id }}"  {{$user->containsGroup($group) ? "selected" : ""}} >
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