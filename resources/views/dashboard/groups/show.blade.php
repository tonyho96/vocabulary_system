@extends('layouts.management')
@section('header')
    <header>
        <div class="row" style="text-align: center">
            <h2 style="margin-top: 10px">Management</h2>
        </div>
    </header>
@endsection
@section('content')
    <div class="box  box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Group detail</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
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
                        {!! Form::text('name', $group->name, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group required">
                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('description', $group->description, ['class'=>'form-control', 'rows' => 2, 'cols' => 40, 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group required">
                    {!! Form::label('members', 'Members', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        @if (Auth::user()->isAdmin() || Auth::user()->id == $group->author_user_id)
                            <div class=" row col-sm-11">
                                <select id="user-id-list" class="form-control">
                                    @foreach(App\User::where('role', '=', config('user.role.student'))->get() as $user)
                                        @if (Auth::user()->isAdmin() || Auth::user()->id == $user->author_id)
                                            <option data-user-id="{{ $user->id }}" value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="add-member-btn" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        @endif
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Confirmed</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="member-list">
                            @foreach($group->allMembers as $member)
                                <tr data-user-id="{{ $member->id }}">
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    @if (Auth::user()->isAdmin() || Auth::user()->id == $group->author_user_id)
                                        <td>
                                            <select class="confirmed-status form-control">
                                                <option value="0" {{ $member->pivot->is_confirmed == 0 ? 'selected' : '' }}>Pending</option>
                                                <option value="1" {{ $member->pivot->is_confirmed == 1 ? 'selected' : '' }}>Confirmed</option>
                                            </select>
                                        </td>
                                        <td><button type="button" class="remove-member-btn btn btn-danger"><i class="fa fa-remove"></i></button></td>
                                    @else
                                        <td>{{ $member->pivot->is_confirmed == 0 ? 'Pending' : 'Confirmed' }}</td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group required">
                    {!! Form::label('assignment', 'Assignments', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        @if (Auth::user()->isAdmin() || Auth::user()->id == $group->author_user_id)
                            <div class=" row col-sm-11">
                                <select id="assignment-id-list" class="form-control">
                                    @foreach(App\Models\Assignment::all() as $assignment)
                                        @if (Auth::user()->isAdmin() || Auth::user()->id == $assignment->author_user_id)
                                            @if ($assignment->update_status == config("string.status.open"))
                                                <option data-assignment-id="{{ $assignment->id }}" value="{{ $assignment->id }}" {{ $assignment->allGroups->where('id', $group->id)->first() ? 'disabled' : '' }}>{{ $assignment->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="add-assignment-btn" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        @endif
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="assignment-list">
                            @foreach($group->allAssignments as $assignment)
                                <tr data-assignment-id="{{ $assignment->id }}">
                                    <td>{{ $assignment->name }}</td>
                                    @if (Auth::user()->isAdmin() || Auth::user()->id == $group->author_user_id)
                                        <td>
                                            <a class="btn btn-info" href="{{ action('AssignmentController@show', $assignment->id) }}"><i class="fa fa-eye"></i></a>
                                            <button type="button" class="remove-assignment-btn btn btn-danger"><i class="fa fa-remove"></i></button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{action('GroupController@index')}}" class="btn btn-default">Back</a>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>
@stop

@push('body_js')
    <script>
        var xcrfs = '{{ csrf_token() }}';

        function getMemberIds() {
            var res = [];
            $('#member-list tr').each(function () {
                 res.push($(this).data('user-id'));
            });

            return res;
        }
        
        function updateMemberSelectList() {
            var memberIds = getMemberIds();

            $('#user-id-list option').each(function () {
                var userId = $(this).data('user-id');
                if (memberIds.includes(userId)) {
                    $(this).attr('disabled', 'disabled');
                }
                else {
                    $(this).removeAttr('disabled');
                }
            });
        }

        function renderMemberRow(userObj) {
            var html = '<tr data-user-id="'+ userObj.id +'">' +
                '<td>'+ userObj.name +'</td>' +
                '<td>'+ userObj.email +'</td>' +
                '<td>' +
                '   <select class="confirmed-status form-control">' +
                '       <option value="0">Pending</option>' +
                '       <option value="1" selected>Confirmed</option>' +
                '   </select>' +
                '</td>' +
                '<td><button type="button" class="remove-member-btn btn btn-danger"><i class="fa fa-remove"></i></button></td>' +
                '</tr>';

            return html;
        }

        $('#add-member-btn').click(function() {
            var url = '{{ action('GroupController@ajaxAddMember', $group->id) }}';
            var userId = $('#user-id-list').val();

            var memberIds = getMemberIds();
            if (!userId || memberIds.includes(userId)) {
                return;
            }

            $.post(url, {user_id: userId, _token: xcrfs}, function(response) {
                var html = renderMemberRow(response.user);
                $('#member-list').append(html);
                updateMemberSelectList();
            }, 'json');
        });

        $('body').on('click', '.remove-member-btn', function() {
            var thisObj = $(this);

            thisObj.attr('disabled', 'disabled');
            var userId = thisObj.closest('tr').data('user-id');

            var url = '{{ action('GroupController@ajaxRemoveMember', $group->id) }}';

            $.post(url, {user_id: userId, _token: xcrfs}, function() {
                thisObj.fadeOut(function() {
                    thisObj.closest('tr').remove();
                    updateMemberSelectList();
                });
            });
        });

        $('body').on('change', '.confirmed-status', function() {
            var thisObj = $(this);
            thisObj.attr('disabled', 'disabled');

            var userId = thisObj.closest('tr').data('user-id');
            var status = thisObj.val();
            var url = '{{ action('GroupController@ajaxUpdateConfirmStatus', $group->id) }}';
            $.post(url, {user_id: userId, status: status, _token: xcrfs}, function() {
                thisObj.removeAttr('disabled');
            });
        });

        $(document).ready(function() {
            updateMemberSelectList();
        })
    </script>
@endpush

@push('body_js')
    <script>
        var xcrfs = '{{ csrf_token() }}';

        function getAssignmentIds() {
            var res = [];
            $('#assignment-list tr').each(function () {
                res.push($(this).data('assignment-id'));
            });

            return res;
        }

        function updateAssignmentSelectList() {
            var assignmentIds = getAssignmentIds();

            $('#assignment-id-list option').each(function () {
                var assignmentId = $(this).data('assignment-id');
                if (assignmentIds.includes(assignmentId)) {
                    $(this).attr('disabled', 'disabled');
                }
                else {
                    $(this).removeAttr('disabled');
                }
            });
        }

        function renderAssignmentRow(assignmentObj) {
            var html = '<tr data-assignment-id="'+ assignmentObj.id +'">' +
                '<td>'+ assignmentObj.name +'</td>' +
                '<td>' +
	            '   <a class="btn btn-info" href="/assignments/'+ assignmentObj.id +'"><i class="fa fa-eye"></i></a>' +
	            '   <button type="button" class="remove-assignment-btn btn btn-danger"><i class="fa fa-remove"></i></button>' +
                '</td>' +
                '</tr>';
            return html;
        }

        $('#add-assignment-btn').click(function() {
            var url = '{{ action('GroupController@ajaxAddAssignment', $group->id) }}';
            var assignmentId = $('#assignment-id-list').val();

            var assignmentIds = getAssignmentIds();
            if (!assignmentId || assignmentIds.includes(assignmentId)) {
                return;
            }

            $.post(url, {assignment_id: assignmentId, _token: xcrfs}, function(response) {
                var html = renderAssignmentRow(response.assignment);
                $('#assignment-list').append(html);
                updateAssignmentSelectList();
            }, 'json');
        });

        $('body').on('click', '.remove-assignment-btn', function() {
            var thisObj = $(this);

            thisObj.attr('disabled', 'disabled');
            var assignmentId = thisObj.closest('tr').data('assignment-id');

            var url = '{{ action('GroupController@ajaxRemoveAssignment', $group->id) }}';

            $.post(url, {assignment_id: assignmentId, _token: xcrfs}, function() {
                thisObj.fadeOut(function() {
                    thisObj.closest('tr').remove();
                    updateAssignmentSelectList();
                });
            });
        });

        $(document).ready(function() {
            updateAssignmentSelectList();
        })
    </script>
@endpush