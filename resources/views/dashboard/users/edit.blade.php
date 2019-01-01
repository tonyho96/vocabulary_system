@extends('layouts.management')
@section('content')
  @if(Session::has('message'))
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">{{ Session::get('message') }}
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
  </div>
  @endif
    <!-- content -->
    <section class="content" style="padding: 40px;">
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
                <div class="box  box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit user</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
                        {!! Form::token() !!}
                        <div class="box-body">
                            <div class="form-group required">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('username', 'User Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Role', 'Role', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    @if (Auth::user()->role == config('user.role.admin'))
                                    {!! Form::select('role',array(config('user.role.unknown') => 'Unknown', config('user.role.teacher') => 'Teacher', config('user.role.parent') => 'Parent', config('user.role.student') => 'Student'), $user->role, ['class' => 'form-control','id' => 'role']) !!}
                                    @else
                                    {!! Form::select('role',array(config('user.role.unknown') => 'Unknown', config('user.role.student') => 'Student'), $user->role, ['class' => 'form-control','id' => 'role']) !!}
                                    @endif
                                </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            @if ( Auth::user()->role == config('user.role.admin') )
                            <div class="form-group" id="student_section" style="display:none">
                                {!! Form::label('student_id', 'Available Students', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                               
                                <select id="student_id" name="student_id" class="form-control" >
                                    <option value="" selected>None</option>
                                    <?php foreach ($students as $student){  ?> 
                                        <option value="{{$student->id}}" <?php echo $student->parent_id == $user->id ? 'selected' : '' ?> >{{$student->name}}</option>
                                    <?php } ?>
                                </select>

                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{action('UserController@index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Submit</button>
                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>
    @push('body_js')
    <script>
    var role = {{ $user->role }};
    
    $(document).ready(function() {  
        if ({{config('user.role.parent')}} == role){
            $('#student_section').show();
        }   
            $('#role').change(function(){
            console.log($(this).val());
            if ($(this).val() == {{config('user.role.parent')}}){
                $('#student_section').show();
            }else{
                $('#student_section').hide();
            }
        });
        
    });
    </script>
@endpush
@stop

