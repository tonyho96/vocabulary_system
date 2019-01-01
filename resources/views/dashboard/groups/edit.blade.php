@extends('layouts.management')
@section('header')
    <header>
        <div class="row" style="text-align: center">
            <h2 style="margin-top: 10px">Admin Management</h2>
        </div>
    </header>
@endsection
@section('content')
    <div class="box  box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Update Group</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['action' => ['GroupController@update', $group->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group required">
                    {!! Form::label(null, 'Enroll Group Link', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text(null, action('GroupController@enroll', $group->id), ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group required">
                    {!! Form::label(null, 'Enroll Code', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text(null, $group->enroll_code, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group required">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', $group->name, ['class' => 'form-control','required' =>'required']) !!}
                    </div>
                </div>
                <div class="form-group required">
                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('description', $group->description, ['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{action('GroupController@index')}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>
@stop