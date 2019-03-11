@extends('adminlte::page')

@section('title', 'Edit Group')

@section('content_header')
    <h1> Edit group</h1>

    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Group</li>
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
            <form method="post" action="{{ route('groups.update',$group->id) }}">
                @method('PATCH')
                @csrf
                <div class="box-body ">
                    <div class="form-group">
                        @csrf
                        <label for="name">Group Name:</label>
                        <input type="text" class="form-control" name="name" value="{{$group->name}}" />
                    </div>

                    <div class="form-group">
                        <select id="users[]" name="users[]" class="form-control select_multiple state-tags-multiple" multiple="multiple">
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{$group->containsUser($user) ? "selected" : "fff"}} >
                                    {{ $user->name }} 
                                </option>
                            @endforeach
                        </select>                        
                    </div>
           
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" type="clear" class="btn btn-warning">Cancel</a>
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
        placeholder: "Add users here",
    });
});
</script>

@stop