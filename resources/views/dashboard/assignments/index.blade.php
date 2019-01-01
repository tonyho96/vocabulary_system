@extends('layouts.management')
{{--@section('header')--}}
{{--<header>--}}
{{--<div class="row" style="text-align: center">--}}
{{--<h2 style="margin-top: 10px">Management</h2>--}}
{{--</div>--}}
{{--</header>--}}
{{--@endsection--}}
@section('content')
    <div class="box  box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Assignments
                @can('is_admin')
                    <a href="{{ route('assignments.create') }}"><input value="{{ trans('forms.create') }}" type="button" class="btn btn-success"></a>
                @endcan
            </h3>
        </div>
        <div class="box-body">
            @include('layouts.notice_message')
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>{{ trans('forms.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    @if (Auth::user()->role == config('user.role.admin') || Auth::user()->id == $assignment->author_user_id)
                    <tr>
                        <td>{{$assignment->name}}</td>
                        <td>
                            @can('is_admin')
                                <a href="{{ action('AssignmentController@show', $assignment->id) }}"><input value="{{ trans('forms.view') }}" type="button" class="btn btn-default"></a>
                                @if(Auth::user()->isAdmin() || (Auth::user()->isTeacher()))
                                    <a href="{{route('assignments.edit', $assignment->id)}}"><input value="Edit" type="button" class="btn btn-primary"></a>
                                    {!! Form::open(['action' => ['AssignmentController@destroy', $assignment->id],
                                                                 'style' => 'display: inline',
                                                                 'method' => 'DELETE',
                                                                 'data-confirm-message' => trans('labels.confirm_delete'),
                                                                 'class' => 'inline',
                                                                 ]) !!}
                                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger', 'onClick' => 'return window.confirm("Are you sure?")']) !!}
                                    {!! Form::close() !!}
                                @endif
                            @endcan
                        </td>
                    </tr>
                    @endif
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop
