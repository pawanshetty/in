@extends('adminlte::page')

@section('title', 'InterNations Test')

@section('content_header')
    <h1>Groups</h1>

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
    <div class="row">

       
        <div class="col-xs-12">
            <form action="{{ route('groups.create')}}" style="display: inline-block" method="get">
                <button class="btn btn-primary float-right">Create group</button>
            </form>

            <div class="box">
                <table id="pageTable" class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($groups as $group)
                        <tr>
                            <td>
                                {{ $group->id }}
                            </td>
                            <td>
                                {{ $group->name }}
                            </td>
                            <td>
                                @foreach($group->users as $user)
                                    <span class="label label-default" style="font-size: 12px">{{$user->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                <a  href="{{ route('groups.edit',$group->id)}}"  class="btn btn-info btn-sm" style="display:inline-block">Edit</a>
                                <form action="{{ route('groups.destroy', $group->id)}}" style="display: inline-block" method="post">
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
@section('scripts')
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