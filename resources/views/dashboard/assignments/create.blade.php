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
            <h3 class="box-title">Create Assignment</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['action' => ['AssignmentController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
            {!! Form::token() !!}
            <div class="box-body">
                <div class="form-group required">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', null, ['class' => 'form-control','required' =>'required']) !!}
                    </div>
                </div>
                
                <div class="form-group required">
                     {!! Form::label('instructions', 'Instructions', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('instructions', null, ['class' => 'form-control','required' =>'required','size' => '1x5']) !!}
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{action('AssignmentController@index')}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>
@stop