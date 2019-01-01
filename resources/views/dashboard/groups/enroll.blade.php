@extends('layouts.index')
@section('top-center')
@stop

@push('css')
    <style>
        #code {
            text-align: center;
            font-weight: bold;
            width: 16%;
        }
    </style>
@endpush

@section('content')
    <div class="text-center">
        @if (!Auth::user()->isStudent())
            <h2>This page is only available for student</h2>
        @elseif($assignedGroup = @Auth::user()->allGroups->where('id', $group->id)->first())
            @if ($assignedGroup->pivot->is_confirmed)
                <h2>You has been enrolled this course successfully</h2>
            @else
                <h2>Your request has been sent</h2>
            @endif
        @else
            <h2>Do you want to enroll to a specific course?</h2>
            <h3>Enter code</h3>
            {!! Form::open(['action' => ['GroupController@enrollSubmit', $group->id], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            {!! Form::text('code', null, ['class' => 'form-control col-sm-offset-5','required' =>'required', 'id' => 'code']) !!}
            <br>
            <button class="btn btn-success">Submit</button>
            {!! Form::close() !!}

            <div class="clearfix"></div>
            <h3>or</h3>
            <a href="{{ action('GroupController@sendEnrollRequest', $group->id) }}" class="btn btn-info"> Send request email to teacher </a>
        @endif
    </div>
@stop