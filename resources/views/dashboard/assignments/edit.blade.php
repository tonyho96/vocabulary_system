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
            <h3 class="box-title">Update Assignment</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['action' => ['AssignmentController@update', $assignment->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group required">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', $assignment->name, ['class' => 'form-control','required' =>'required']) !!}
                    </div>
                </div>

                <div class="form-group required">
                    {!! Form::label('instructions', 'Instructions', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('instructions', $assignment->instructions, ['class' => 'form-control','required' =>'required','size'=>'1x5']) !!}
                    </div>
                </div>

                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <div class="form-group required">
                    {!! Form::label('update_status', 'Status', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('update_status', array(config('string.status.open') => 'Open', config('string.status.close') => 'Close'), $assignment->status, ['class' => 'form-control','id' => 'update_status']) !!}
                    </div>
                </div>
                @endif
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