<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Essay;
use App\Models\Group;
use App\Models\Paragraph;
use App\Models\Sentence;
use App\Models\Session;
use App\Models\Word;
use App\User;
use App\Services\SessionService;
use App\Services\TimerService;
use App\Services\WordService;
use App\Services\SentenceService;
use App\Services\ParagraphService;
use App\Services\EssayService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


use Form;
use Html;
use DB;

class SessionController extends Controller {


	public function __construct() {

	}

	public function index() {
		return view( 'dashboard.session.create' );
	}

	public function create( Request $request ) {
        if(Auth::user()->role == config('user.role.parent')){
            return redirect()->action('SessionController@show');
        }

		$name  = date( 'Y-m-d H:i:s' );
		$student_can_edit = 0;
		if (Auth::user() && Auth::user()->role == config('user.role.student'))
			$student_can_edit = 1;

		$input = array(
			'name' => $name,
			'student_can_edit' => $student_can_edit,
		);

		$session = SessionService::create($input);
		SessionService::updateSessionName($session->id);
		TimerService::startCreateSessionTimer($session);
		$students = UserService::getStudents();
		return view( 'dashboard.session.create', [ 'session' => $session,	'students'=>$students ] );
	}

	public function store( Request $request ) {

	}
    public function showLayout() {
        if (Auth::user()->isAdmin()) {
            $sessions = Session::all();
            $words      = Word::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
            $sentences  = Sentence::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
            $essays     = Essay::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();

        }
        else if (Auth::user()->isTeacher()){
            $sessions   = Session::where('user_id', Auth::user()->id)->get();
            $words      = Word::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
            $sentences  = Sentence::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
            $essays     = Essay::whereHas('session', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
        }
        else {
            $id = Auth::user()->id;
            $sessions = DB::select("SELECT DISTINCT sessions.* FROM sessions, user_group, group_assignment, users
                                      WHERE (sessions.assignment_id = group_assignment.assignment_id
                                        AND users.id = $id
                                        AND users.id = user_group.user_id
                                        AND user_group.group_id = group_assignment.group_id
                                        AND sessions.student_id IS NULL) OR sessions.student_id = $id");

            $words      = Word::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
            $sentences  = Sentence::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
            $essays     = Essay::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
        }

        if (Auth::user()->role == config('role.user.admin')) {
						$assignments = Assignment::all();
            $group = Group::all();
            $student = User::all();
        }
        else {
            $assignments = Assignment::all()->where('author_user_id', Auth::user()->id);
            $group = Group::all()->where('author_user_id', Auth::user()->id);
            $student = User::all()->where('role', config('user.role.student'))->where('author_id', Auth::user()->id);
        }

        $totalGlobalLetter = 0;
         foreach ($sessions as $session)
             $totalGlobalLetter += $session->count_letter;

        return view( 'layouts.index', compact( 'words','assignments', 'group', 'student', 'sentences', 'essays', 'sessions','totalGlobalLetter' ) );
    }

    public function showSessions() {

	    if (Auth::user()->isAdmin()) {
            $sessions = Session::all();
            return view('dashboard.listings.sessions', compact('sessions'));
        }

		if (Auth::user()->isTeacher()) {
            $sessions = Session::all()->where('user_id', Auth::user()->id);
            return view( 'dashboard.listings.sessions', compact( 'sessions'));
		}

		if (Auth::user()->isStudent()) {
            $id = Auth::user()->id;
            $sessions = DB::select("SELECT DISTINCT sessions.* FROM sessions, user_group, group_assignment, users
                                      WHERE (sessions.assignment_id = group_assignment.assignment_id
                                        AND users.id = $id
                                        AND users.id = user_group.user_id
                                        AND user_group.group_id = group_assignment.group_id
                                        AND sessions.student_id IS NULL) OR sessions.student_id = $id");
            return view( 'dashboard.listings.sessions', compact( 'sessions'));
        }

    }

	public function show() {
		$words      = Auth::user()->words();
		$sentences  = Auth::user()->sentences();
		$paragraphs = Auth::user()->paragraphs();
		$essays     = Auth::user()->essays();
		$sessions   = Auth::user()->sessions();

		$totalGlobalLetter = 0;
		foreach ( $sessions as $session ) {
			$totalGlobalLetter += $session->count_letter;
		}

		return view( 'dashboard.index', compact( 'words', 'sentences', 'paragraphs', 'essays', 'sessions', 'totalGlobalLetter' ) );
	}


	public function detail() {
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$id = isset($_GET['id']) ? $_GET['id'] : '';

		if( $type == '' || $id == '' )
			return redirect()->route('session_dashboard');
		$datas = null;


        switch ($type) {
            case 'word':
                $datas = Word::where('id', $id)->first();
                break;
            case 'paragraph':
                $datas = Paragraph::where('id', $id)->first();
                break;
            case 'essay':
                $datas = Essay::where('id', $id)->first();
                break;
            case 'session':
                $datas = Session::find($id);
                $assignment = Assignment::where('id',$datas->assignment_id)->first();
                break;
            default:
                break;
        }

		if( ! $datas )
			return redirect()->route('session_dashboard');

		return view( 'dashboard.details.' . $type, compact( 'type', 'datas','assignment') );
	}


	public function edit() {

	}

	public function update( Request $request ) {

		$slug_id      = $request->input( 'id_session' );
		$count_letter = $request->input( 'count_letter' );
		$input        = array(

			'session_id'   => $slug_id,
			'count_letter' => $count_letter,

		);

		if ( $Session = SessionService::updateCount( $input ) ) {
			return $Session;
		}


	}

	public function destroy() {

	}

	public function showCreate() {

	}

	public function SessionDashboard() {

	}

	public function addSession() {


	}

	public function updateAssign( $id, Request $request ) {
		$assignmentId     = $request->input( 'assignment_id' );
		$studentId        = $request->input( 'student_id' );

		$session     = Session::find($id);
		if (empty($session) || empty($assignmentId)) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Invalid input'
			] );
		}

		$input = array(
			'assignment_id'     => $assignmentId,
            'student_id'        => $studentId
		);

		if ( SessionService::update($session,$input) ) {

			return response()->json( [
				'status' => 1,
			] );
		}

		return response()->json( [
			'status'  => 0,
			'message' => 'Unknown Error'
		]);
	}

	public function ajaxUpdate($id, Request $request) {
		$inputs = $request->all();
		$session = Session::find($id);
		$session->update($inputs);
		return 1;
	}

	public function studentAssign($id)
	{
			$assignment = Assignment::find($id);
			return view('dashboard.details.studentassign', compact('assignment'));
	}
}
