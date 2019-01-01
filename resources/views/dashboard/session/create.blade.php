@extends('layouts.dashboard')

@section('header')
    <header>
        <div class="row">
            <div class="col-md-1">
                <div class="pull-right">
                    <label>ID</label>&nbsp;
                    <input type="text" id="session_id" readonly="" value="{{ $session->id }}" class="form-control" style="width: 70%; display: inline">
                </div>
            </div>
            <div class="col-md-3">
                {{--<input type="text" readonly="" value="{{ Auth::user()->name }}" class="form-control">--}}
            </div>

            <div class="form-group col-md-5">
                <a href="{{ route('session_dashboard') }}" class="btn btn-primary">Dashboard</a>
                <a href="{{ route('create_session') }}" class="btn btn-primary">New Session</a>
            </div>
            <div class="form-group col-md-2">
                <input type="text" readonly="" value="{{ date('Y-m-d') }}" class="form-control">
            </div>
            <div class="form-group col-md-1 text-right">
                Total&nbsp;<input type="text" id="totalSession" readonly="readonly" name="totalSession" value="0" class="form-control" style="width: 60%; display: inline;"/>
            </div>
        </div>
    </header>
@stop

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-group {
            float: left;
            margin-bottom: 0px !important;
        }

        .word-row,
        .sentence-row {
            min-height: 41px;
        }

        .paragraph-row {
            min-height: 72px;
        }

        .sentence-row .table-div {
            height: 23px;
        }

        .paragraph-content-row.table-div {
            min-height: 95px;
        }

        .paragraph-row {
            min-height: 144px;
        }

        .hover {
            border: 2px transparent solid;
        }

        .hover:hover {
            border: 2px solid #94c6e1;
        }

        input.hover {
            padding-right: 0px;
        }

        .table-cell-div {
            padding-left: 0px;
            padding-right: 0px;

        }

        header {
            padding: 15px;
        }

        .checkbox-special {
            padding-right: 5px;
        }

        div.total {
            text-align: right;
        }
        .table-cell-div .checkbox-special,
        .table-cell-div.total {
            padding: 0px 15px;
        }
        .inline-edit-value,
        .inline-edit-value:focus,
        .inline-edit-value:hover {
            background-color: transparent !important;
            border: 0px !important;
            box-shadow: none !important;
            border-radius: 0px !important;
            padding: 3px 0px !important;
        }

        pre {
            background-color: inherit;
            border: none;
        }

        .paragraph-content-row textarea {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <input type="hidden" id=id_session value="{{$session->id}}">
    <div class="row" style="position: relative;">
        <div class="col-md-12">
            <div class="inline-edit-group">
                <div class="table-div">
                    <div class="table-cell-div" style="width: 10%"></div>
                    <div class="table-cell-div" style="width: 20%; font-weight: bold;">Session Name</div>
                    <div class="table-cell-div" style="width: 20%; font-weight: bold;">Assignment List</div>
                    <div class="table-cell-div" style="width: 50%; font-weight: bold;">Instruction</div>
                    <div class="table-cell-div" style="width: 50%; font-weight: bold;">Student ID</div>
                </div>
                <div class="col word-row stripped-row inline-row">
                    <div class="table-div">
                        <div class="table-cell-div" style="width: 5%">
                            <div class="checkbox-special">
                                <div class="checkbox-special">
                                    <a href="#"></a>
                                </div>
                            </div>
                        </div>
                        <div class="hover table-cell-div inline-edit" style="width: 20%; background-color: white;">
                            @if(Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))
                                <input type="text" id="session-name" placeholder="Name/Task Instruction" value="Session {{$session->id}}" >
                            @else
                                <input type="text" placeholder="Name/Task Instruction" readonly value="{{ $session->name }}">
                            @endif
                        </div>
                        <div class="table-cell-div" style="width: 20%">
                            <select id="assignList" class="form-control" {{ (Auth::user()->isAdmin() || Auth::user()->isTeacher()) ? '' : 'disabled' }}>
                                <option value="" disabled selected>Assign</option>
                                @foreach (\App\Models\Assignment::all() as $assignment)
                                    @if ($assignment->update_status == config("string.status.open"))
                                    <option tagName="{{$assignment->name}}" tagInstruction="{{$assignment->instructions}}" value="{{$assignment->id}}" {{ $assignment->id == $session->assignment_id ? 'selected' : '' }} >{{$assignment->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!--values assignment and instruction name-->
                        <div class="hover table-cell-div" style="width: 50%; background-color: white;">
                            <input type="text" placeholder="Assignment Instructions" value="" id="assignmentInstruction" readonly="true">
                        </div>
                        <div class="table-cell-div " style="width: 20%;">
                            @if(Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))
                                <select id="studentList" class="form-control">
                                    @foreach (\App\Models\Session::all() as $session)
                                        @if ($session->student_id != null)
                                        <option value="{{$session->student_id}}">{{$session->student_id}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="position: relative;">
        <div class="col-md-2">
            <h5 class="text-center">Word Bank (<span id="total-word">0</span>)</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col word-row stripped-row inline-row">
                                <div class="table-div">
                                    <div class="table-cell-div" style="width: 10%">
                                        <div class="checkbox-special hidden-for-next">
                                            <input type="checkbox" name="" id="checkbox1">
                                            <label for="checkbox1"></label>
                                        </div>
                                    </div>
                                    <div class="hover table-cell-div inline-edit value1" style="width: 70%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 20%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col word-row stripped-row inline-row"></div>
                        </div>
                    </div>
                    <div class="col word-row stripped-row inline-row">
                        <div class="table-div">
                            <div class="table-cell-div" style="width: 10%">
                                <div class="checkbox-special hidden-for-next">
                                    <input type="checkbox" name="" id="checkbox1">
                                    <label for="checkbox1"></label>
                                </div>
                            </div>
                            <div class="hover table-cell-div inline-edit value1" style="width: 70%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 20%">
                            </div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col word-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalword" readonly="readonly" name="totalword" value="0" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Sentence Bank (<span id="total-sentence">0</span>)</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col sentence-row stripped-row inline-row" data-value="">
                                <div class="table-div">
                                    <div class="hover table-cell-div inline-edit value1" style="width: 94%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 6%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col sentence-row stripped-row inline-row"></div>
                        </div>
                    </div>
                    <div class="col sentence-row stripped-row inline-row" data-value="">
                        <div class="table-div">
                            <div class="hover table-cell-div inline-edit value1" style="width: 94%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 6%">
                            </div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col sentence-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalsentence" readonly="readonly" name="totalsentence" value="0" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Paragraph Bank (<span id="total-paragraph">0</span>)</h5>
            <div class="static-height-400">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col paragraph-row stripped-row inline-row">
                                <div class="table-div">
                                    <div class="table-cell-div" style="width: 5%">
                                        <div class="checkbox-special hidden-for-next">
                                            <input type="checkbox" name="" id="checkbox1">
                                            <label for="checkbox1"></label>
                                        </div>
                                    </div>
                                    <div class="hover table-cell-div inline-edit value1 text-center" style="width: 90%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 5%">
                                    </div>
                                </div>
                                <div class="paragraph-content-row table-div">
                                    <div class="hover table-cell-div inline-edit value2 text-area" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col paragraph-row stripped-row inline-row"></div>
                        </div>
                    </div>
                    <div class="col paragraph-row stripped-row inline-row">
                        <div class="table-div">
                            <div class="table-cell-div" style="width: 5%">
                                <div class="checkbox-special hidden-for-next">
                                    <input type="checkbox" name="" id="checkbox1">
                                    <label for="checkbox1"></label>
                                </div>
                            </div>
                            <div class="hover table-cell-div inline-edit value1 text-center" style="width: 90%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 5%">
                            </div>
                        </div>
                        <div class="paragraph-content-row table-div">
                            <div class="hover table-cell-div inline-edit value2 text-area" style="width: 100%"></div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col paragraph-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalparagraphs" readonly="readonly" name="totalparagraphs" value="0" class="form-control col-total"/>
            </div>
        </div>
        <div class="form-group col-sm-10">
            <input id="essay-title" class="form-control" type="text" name="essays"/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <br/>
            <div class="static-height-300">
                <textarea id="essay-content" class="full-textarea" data-id='' name='essays-content'></textarea>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalessays" readonly="readonly" name="totalessays" value="0" class="form-control col-total"/>
            </div>
        </div>
    </div>

    <div class="row">
        <br/>
        <div class="col-md-offset-1 col-md-3 text-center">
            <a href="{{ route('create_session') }}" class="btn btn-primary">Create a session</a>
        </div>
    </div>
@stop

@push('body_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('js/vocabulary_functions.js')}}"></script>
    <script>
        var session_id = '{{$session->id}}';
        var xcsrf = '{{ csrf_token() }}';

        function updateTotalEssayLetterForOneObject() {
            var title = $('#essay-title').val();
            var content = $('#essay-content').val();
            var countLetter = title.replace(/[^A-Z0-9]/gi, "").length;
            countLetter += content.replace(/[^A-Z0-9]/gi, "").length;

            $('#totalessays').val(countLetter);
            $('#totalessays').trigger('change');
        }

        // update number count
        $('body').on('blur', '.inline-edit-value', function () {
            var value1 = $(this).closest('.inline-row').data('value') || '';
            var value2 = $(this).closest('.inline-row').data('value2') || '';

            if ($(this).closest('.inline-edit').hasClass('value1')) {
                value1 = $(this).val();
            }
            else if ($(this).closest('.inline-edit').hasClass('value2')) {
                value2 = $(this).val();
            }

            var countLetter = value1.replace(/[^A-Z0-9]/gi, "").length;
            countLetter += value2.replace(/[^A-Z0-9]/gi, "").length;

            $(this).closest('.inline-row').find('.total').html(countLetter);
        })

        // update data to db
        $('body').on('blur', '.word-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');

            if (id) {
                updateWord(id, value, session_id, xcsrf);
            }
            else {
                createWord(value, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalWord();
                });
            }
            updateTotalWordLetter();
        });

        // update data to db
        $('body').on('blur', '.sentence-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');

            if (id) {
                updateSentence(id, value, session_id, xcsrf);
            }
            else {
                createSentence(value, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalSentence();
                });
            }
            updateTotalSentenceLetter();
        });

        $('body').ready(function () {
           $('#studentList').hide();
        });

        $('body').on('change', '#assignList', '#studentList', function () {
             var assignment_id = $('#assignList').val();
             var student_id = $('#studentList').val();
             var url = '{{ action('SessionController@updateAssign', $session->id) }}';

            $.post(url, {assignment_id: assignment_id, student_id: student_id,_token: xcsrf}, function() {

            }, 'json');
        });

        $("#assignList").change(function(){
            var element = $(this).find('option:selected');
            var tagName = element.attr("tagName");
            var tagInstruction = element.attr("tagInstruction");
            $('#assignmentName').val(tagName);
            $('#assignmentInstruction').val(tagInstruction);
            $('#studentList').show();
        });


        // update data to db
        $('body').on('blur', '.paragraph-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var inlineEdit = $(this).closest('.inline-edit');
            var title = content = $(this).val();

            if (inlineEdit.hasClass('value1')) {
                content = inlineRow.data('value2');
            }
            else {
                title = inlineRow.data('value');
            }

            var id = inlineRow.data('id');

            if (id) {
                updateParagraph(id, title, content, session_id, xcsrf);
            }
            else {
                createParagraph(title, content, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalParagraph();
                });
            }
            updateTotalParagraphLetter();
        });

        // update data to db
        $('body').on('blur', '#essay-title, #essay-content', function () {
            var title = $('#essay-title').val();
            var content = $('#essay-content').val();
            // because 1 session has only one essay, so we don't need to determine it
            updateEssay(title, content, session_id, xcsrf);
            updateTotalEssayLetterForOneObject();
        });

        $('#totalword, #totalsentence, #totalparagraphs, #totalessays').change(function () {
            var totalWorld = parseInt($('#totalword').val()) || 0;
            var totalSentence = parseInt($('#totalsentence').val()) || 0;
            var totalParagraph = parseInt($('#totalparagraphs').val()) || 0;
            var totalEssay = parseInt($('#totalessays').val()) || 0;

            var total = totalWorld + totalSentence + totalParagraph + totalEssay;
            $('#totalSession').val(total);
        });

        // TIMER
        var interval = 1000 * 60 * 1; // where X is your every X minutes
        setInterval(function () {
            $.ajax({
                url: "/timer/create-session",
                type: "GET",
                data: {session_id: session_id},
                success: function (data) {
                }
            });
        }, interval);

        $('#session-name').on('change', function() {
	        var name = $(this).val();
	        var url = '{{ action('SessionController@ajaxUpdate', $session->id) }}';
	        $.post(
		        url,
		        {
			        name: name,
			        _token: xcsrf
		        },
		        function() {

		        }
	        )
        });
    </script>
    <script type="text/javascript" src="{{asset('js/inline_edit.js')}}"></script>
@endpush
