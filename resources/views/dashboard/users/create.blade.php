@extends('layouts.management')
@section('content')
<!-- content -->
@if(Session::has('message'))
  <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">{{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  </div>
@endif
    <section class="content" style="padding: 40px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="box  box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create User</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['action' => ['UserController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
                        {!! Form::token() !!}
                        <div class="box-body">
                            <div class="form-group required">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('name', null, ['class' => 'form-control','required' =>'required']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('username', 'User name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('username', null, ['class' => 'form-control','required' =>'required']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::email('email', null, ['class' => 'form-control','required' =>'required']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('role', 'Role', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    @if (Auth::user()->role == config('user.role.admin'))
                                    {!! Form::select('role',array(config('user.role.unknown') => 'Unknown', config('user.role.teacher') => 'Teacher', config('user.role.student') => 'Student', config('user.role.parent') => 'Parent'), null, ['class' => 'form-control','id' => 'role']) !!}
                                    @else
                                    {!! Form::select('role',array(config('user.role.unknown') => 'Unknown', config('user.role.student') => 'Student'), null, ['class' => 'form-control','id' => 'role']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::password('password', ['class' => 'form-control','required' =>'required','minlength'=>6]) !!}
                                </div>
                            </div>
                            <div class="form-group" id="student_section" style="display:none">
                                {!! Form::label('student_id', 'Available Students', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                               
                                <select id="student_id" name="student_id" class="form-control" >
                                    <option value="" selected>Select a student</option>
                                    <?php foreach ($users as $user){  ?> 
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    <?php } ?>
                                </select>

                                </div>
                            </div>
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
    @push('body_js')
    <script>
    $(document).ready(function() {     
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
