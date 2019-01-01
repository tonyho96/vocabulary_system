<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\GroupAssignment;
use App\Models\Paragraph;
use App\Models\Sentence;
use App\Models\Word;
use App\Models\Essay;
use App\Models\UserGroup;
use App\Services\GroupService;
use App\Services\SessionService;
use App\Models\Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    public function userAssign() {

        return view('dashboard.assignments.user-assign');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('is_admin', Auth::user()))
            return back();
        $groups = Group::all();
        return view('dashboard.groups.index', compact('groups'));
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

        return view('dashboard.groups.create');
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
	    $input['enroll_code']    = GroupService::generateEnrollCode();
	    $input['date'] = now();

        Group::create($input);
        return redirect()->action('GroupController@index')->with('message', 'Create successfully.');
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

	    $group = Group::find($id);
	    return view('dashboard.groups.show', compact('group'));
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

	    $group = Group::find($id);
	    return view('dashboard.groups.edit', compact('group'));
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

	    $group = Group::find($id);
	    if (!Auth::user()->isAdmin() && Auth::user()->id != $group->author_user_id) // prevent non-author user update group
		    return redirect()->back()->with('error', 'Access is denied');

	    $input = $request->all();
        $input['date'] = now();
	    if (!Auth::user()->isAdmin()) { // allow admin to select author
		    $input['author_user_id'] = Auth::user()->id;
	    }

	    $group->update($input);
	    return redirect()->action('GroupController@index')->with('message', 'Updated successfully.');
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
      //delete all foreign key related to the primary key before delete primary key
      //delete user groups
      //delete group assignments
	    UserGroup::where('group_id', $id)->delete();
      GroupAssignment::where('group_id',$id)->delete();
	    $group = Group::find($id);
        if ($group)
        	$group->delete();

	    return redirect()->action('GroupController@index')->with('message', 'Deleted successfully.');
    }

    public function ajaxAddMember($id, Request $request) {
	    if (Gate::denies('is_admin', Auth::user()))
		    return back();

    	$input = $request->all();
    	$input['group_id'] = $id;

    	$existingData = UserGroup::where('user_id', $request->get('user_id'))->where('group_id', $id)->first();
    	if ($existingData)
    		return 0;

	    $input['is_confirmed'] = 1;
	    $assigns = GroupAssignment::all()->where('group_id', $id);
        UserGroup::create($input);
	    foreach ($assigns as $assign) {
            $name = date('Y-m-d H:i:s');
            $student_can_edit = 0;
            $input2 = array(
                'name' => $name,
                'student_can_edit' => $student_can_edit,
                'assignment_id' => $assign->assignment_id,
                'student_id' => $request->get('user_id')
            );
            SessionService::create2($input2);
        }
        $user = User::find($request->get('user_id'));
        return response()->json([
            'user' => $user
        ]);
    }

    public function ajaxRemoveMember($id, Request $request) {
	    if (Gate::denies('is_admin', Auth::user()))
		    return back();

		$userId = $request->get('user_id');

    	$existingData = UserGroup::where('user_id', $userId)->where('group_id', $id)->first();
    	if ($existingData)
    		$existingData->delete();

        $sessions = Session::all()->where('student_id', $userId);
        foreach($sessions as $session) {
            Essay::where('session_id',$session->id)->delete();
            Paragraph::where('session_id',$session->id)->delete();
            Word::where('session_id',$session->id)->delete();
            Sentence::where('session_id',$session->id)->delete();
        }
        Session::where('student_id', $userId)->delete();
    	return 1;
    }

    public function ajaxUpdateConfirmStatus($id, Request $request) {
	    if (Gate::denies('is_admin', Auth::user()))
		    return back();

		$status = $request->get('status');
	    $userId = $request->get('user_id');

    	$existingData = UserGroup::where('user_id', $userId)->where('group_id', $id)->first();
    	if ($existingData) {
		    $existingData->update(['is_confirmed' => $status]);
	    }

    	return 1;
    }

    public function askToJoinGroup($id, Request $request) {
	    $userId = $request->get('user_id');
		if (!$userId)
			$userId = Auth::user()->id;

	    $existingData = UserGroup::where('user_id', $userId)->where('group_id', $id)->first();
	    if (!$existingData) {
		    $input = [
		    	'user_id' => $userId,
			    'group_id' => $id
		    ];
		    UserGroup::create($input);
	    }
	    return redirect()->action('GroupController@index')->with('message', 'Your request has been sent');
    }

    public function ajaxAddAssignment($id, Request $request) {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $input = $request->all();
        $input['group_id'] = $id;
//		$temp = $request->get('assignment_id');
        $existingData = GroupAssignment::where('assignment_id', $request->get('assignment_id'))->where('group_id', $id)->first();
        if ($existingData)
            return 0;

        $assignment = Assignment::find($request->get('assignment_id'));
        $users = UserGroup::all()->where('group_id', $id);

        if ($assignment->update_status == config("string.status.open")) {
            GroupAssignment::create($input);

            foreach ($users as $user) {

                $name = date('Y-m-d H:i:s');
                $student_can_edit = 0;
                if (Auth::user() && Auth::user()->role == config('user.role.student'))
                    $student_can_edit = 1;

                $input2 = array(
                    'name' => $name,
                    'student_can_edit' => $student_can_edit,
                    'assignment_id' => $request->get('assignment_id'),
                    'student_id' => $user->user_id
                );
                SessionService::create2($input2);
            }
        }

        return response()->json([
            'assignment' => $assignment
        ]);


    }

    public function ajaxRemoveAssignment($id, Request $request) {
        if (Gate::denies('is_admin', Auth::user()))
            return back();

        $assignmentId = $request->get('assignment_id');

        $existingData = GroupAssignment::where('assignment_id', $assignmentId)->where('group_id', $id)->first();
        if ($existingData) {
            $existingData->delete();
        }

        $sessions = Session::all()->where('assignment_id', $assignmentId);
        foreach($sessions as $session) {
            Essay::where('session_id',$session->id)->delete();
            Paragraph::where('session_id',$session->id)->delete();
            Word::where('session_id',$session->id)->delete();
            Sentence::where('session_id',$session->id)->delete();
        }
        Session::where('assignment_id', $assignmentId)->delete();

        return 1;
    }

    public function enroll($id, Request $request) {
		$group = Group::find($id);

		return view('dashboard.groups.enroll', compact('group'));
    }

    public function enrollSubmit($id, Request $request) {
		$code = $request->get('code');

		$group = Group::find($id);

		if (strtoupper($code) == strtoupper($group->enroll_code)) {
			UserGroup::create( [
				'user_id'      => Auth::user()->id,
				'group_id'     => $id,
				'is_confirmed' => 1
			] );
			return redirect()->action('GroupController@enroll', $id);
		}
	    return redirect()->action('GroupController@enroll', $id)->with('error', 'Enroll code does not match');
    }

    public function sendEnrollRequest($id, Request $request) {
	    UserGroup::create( [
		    'user_id'      => Auth::user()->id,
		    'group_id'     => $id,
		    'is_confirmed' => 0
	    ] );
		$group = Group::find($id);

	    $mailData = ['groupName' => $group->name, 'email' => $group->author->email, 'studentName' => Auth::user()->name];
	    Mail::send('emails.enroll-request', $mailData, function($message) use ($mailData) {
		    $message->to($mailData['email'])->subject('Enroll request');
	    });

	    return redirect()->action('GroupController@enroll', $id);
    }
}
