@extends('layouts.management')
@section('content')
    <!-- content -->
    <div class="box  box-primary">
                    @if ($errors->has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {{$errors->first('error')}}
              </div>
            @endif
               @if (Session::has('message'))
               <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <p><i class="icon fa fa-check"></i>{{Session::get('message')}}</p>
              </div>
             @endif
        <div class="row">
            <div class="col-xs-12">


                    <div class="box-header">
                        <h3 class="box-title">User list</h3> <a href="{{ action('UserController@create') }}" class="btn btn-success">Create</a>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users-table" class="table table-bordered ">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>                              
                                <th>Action</th>
                            </tr>
                            </thead>
                            
                            @foreach($users as $index => $user)
                                @if (Auth::user()->role == config('user.role.admin') && $user->role == config('user.role.unknown'))
                                    <tr bgcolor="red">
                                @else
                                    <tr>
                                @endif
                                    @if (Auth::user()->role == config('user.role.admin') || Auth::user()->id == $user->author_id)
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if (Auth::user()->role == config('user.role.admin'))
                                            @if ($user->role === config('user.role.student'))
                                            <td>Student</td>
                                            @elseif ($user->role === config('user.role.teacher'))
                                            <td>Teacher</td>
                                            @elseif ($user->role === config('user.role.admin'))
                                            <td>Admin</td>
                                            @elseif ($user->role === config('user.role.parent'))
                                            <td>Parent</td>
                                            @else
                                            <td>Unknown</td>
                                            @endif
                                        @else
                                            <td>Student</td>
                                        @endif
                                        <td>
                                            @if ($user->status == 'not_verified')
                                                <a href="{{ action('UserController@verify', $user->id) }}" class="btn btn-warning" title="Verify"><i class="glyphicon glyphicon-check"></i></a>
                                            @endif
                                            <a href="{{ action('UserController@edit', $user->id) }}" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                            @if ($user->email !== Auth::user()->email)
                                            {!! Form::open(['action' => ['UserController@destroy', $user->id],
                                                'method' => 'DELETE',
                                                'data-confirm-message' => trans('labels.confirm_delete'),
                                                'class' => 'inline',
                                                ]) !!}

                                            {{ Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onClick' => 'return window.confirm("Are you sure?")']) }}
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </table>
                    </div>
                    <!-- /.box-body -->

            </div>
        </div>
    </div>


@push('body_js')
    <script type="text/javascript">
        $(document).ready( function () {
            var table = $('#users-table').DataTable();
        } );
    </script>   
@endpush

@stop