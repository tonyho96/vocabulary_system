<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Services\SessionService;
use App\Models\Assignment;
use App\Models\Group;
use App\Models\GroupAssignment;
use App\Models\Essay;
use App\Models\Paragraph;
use App\Models\Word;
use App\Models\Sentence;
use App\Models\Timer;
use App\Services\EssayService;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;



class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Gate::denies('is_admin', Auth::user()))
            return back();
        $assignments = Assignment::all();
        return view('dashboard.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        return view('dashboard.assignments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $input = $request->all();
        $input['author_user_id'] = Auth::user()->id;
        $input['date'] = now();
        $input['status'] = config('string.status.open');
        $input['update_status'] = config('string.status.open');

        Assignment::create($input);
        return redirect()->action('AssignmentController@index')->with('message', 'Create successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $assignment = Assignment::find($id);
        return view('dashboard.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $assignment = Assignment::find($id);
        return view('dashboard.assignments.edit', compact('assignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $assignment = Assignment::find($id);
        if ((!Auth::user()->isAdmin()) && (Auth::user()->id != $assignment->author_user_id)) { // prevent non-author user update group
            return redirect()->back()->with('error', 'Access is denied');
        }
        $input = $request->all();
        $input['date'] = now();

        $assignment->update($input);

        if($assignment->update_status == config("string.status.close")) {
            $assignmentID = $id;
            $sessions = Session::where('assignment_id', $assignmentID)->get();
            foreach($sessions as $session) {
                Essay::where('session_id',$session->id)->delete();
                Paragraph::where('session_id',$session->id)->delete();
                Word::where('session_id',$session->id)->delete();
                Sentence::where('session_id',$session->id)->delete();
                Timer::where('session_id',$session->id)->delete();
            }

            Session::where('assignment_id',$assignmentID)->delete();
            GroupAssignment::where('assignment_id',$assignmentID)->delete();
            Assignment::find($assignmentID)->delete();
        }
        return redirect()->action('AssignmentController@index')->with('message', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $assignmentID = $id;
        $sessions = Session::where('assignment_id', $assignmentID)->get();
        foreach($sessions as $session) {
            Essay::where('session_id',$session->id)->delete();
            Paragraph::where('session_id',$session->id)->delete();
            Word::where('session_id',$session->id)->delete();
            Sentence::where('session_id',$session->id)->delete();
            Timer::where('session_id',$session->id)->delete();
        }

        Session::where('assignment_id',$assignmentID)->delete();
     	GroupAssignment::where('assignment_id',$assignmentID)->delete();
     	Assignment::find($assignmentID)->delete();

      return redirect()->action('AssignmentController@index')->with('message', 'Deleted successfully.');
    }

//    public function ajaxAddGroup($id, Request $request) {
//        if (Gate::denies('is_admin', Auth::user()))
//            return back();
//
//        $input = $request->all();
//        $input['assignment_id'] = $id;
//
//        $existingData = GroupAssignment::where('group_id', $request->get('group_id'))->where('assignment_id', $id)->first();
//        if ($existingData)
//            return 0;
//
//        GroupAssignment::create($input);
//
//        $group = Group::find($request->get('group_id'));
//
//        $name  = date( 'Y-m-d H:i:s' );
//		$student_can_edit = 0;
//		if (Auth::user() && Auth::user()->role == config('user.role.student'))
//			$student_can_edit = 1;
//
//		$input2 = array(
//			'name' => $name,
//			'student_can_edit' => $student_can_edit,
//			'assignment_id' => $input['assignment_id']
//		);
//		SessionService::create2( $input2 );
//        return response()->json([
//            'group' => $group
//        ]);
//    }
//
//    public function ajaxRemoveGroup($id, Request $request) {
//        if (Gate::denies('is_admin', Auth::user()))
//            return back();
//
//        $groupId = $request->get('group_id');
//
//        $existingData = GroupAssignment::where('group_id', $groupId)->where('assignment_id', $id)->first();
//        if ($existingData) {
//            $existingData->delete();
//        }
//
//        $existingSession = Session::where('assignment_id', $id)->first();
//        $word = Word::where('session_id', $existingData->id);
//        $paragraph = Paragraph::where('session_id', $existingData->id);
//        $sentence = Sentence::where('session_id', $existingData->id);
//        $essay = Essay::where('session_id', $existingData->id);
//        if ($existingSession) {
//            $existingSession->delete();
//            $word->delete();
//            $paragraph->delete();
//            $sentence->delete();
//            $essay->delete();
//        }
//
//        return 1;
//    }

  
}
