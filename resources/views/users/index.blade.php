@extends('adminlte::page')

@section('title', 'InterNations Test')

@section('content_header')
    <h1>Users</h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
@stop

@section('content')
<section class="content">
    @if(session()->get('success'))
        <div class="alert alert-success fade in">
          {{ session()->get('success') }}  
        </div><br />
    @endif
    @if(session()->get('failure'))
    <div class="alert alert-danger fade in">
      {{ session()->get('failure') }}  
    </div><br />
@endif
    <div class="row">

       
        <div class="col-xs-12">
            <form action="{{ route('users.create')}}" style="display: inline-block" method="get">
                <button class="btn btn-primary float-right">Create User</button>
            </form>

            <div class="box">
                <table id="pageTable" class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Groups</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @foreach($user->groups as $group)
                                    <span class="label label-default" style="font-size: 12px">{{$group->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                <a  href="{{ route('users.edit',$user->id)}}"  class="btn btn-info btn-sm" style="display:inline-block">Edit</a>
                                
                                <form action="{{ route('users.destroy', $user->id)}}" style="display: inline-block" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" style="display:inline-block" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    jQuery(function($) {
   //initiate dataTables plugin
   var myTable = 
   $('#pageTable')
   .wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
   .DataTable( {
       bAutoWidth: false,
       "aoColumns": [
           null,
           null,
           null
       ],
       "aaSorting": [],
      
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000);
   });
</script>

@stop