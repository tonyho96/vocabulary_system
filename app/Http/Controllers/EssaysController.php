<?php

namespace App\Http\Controllers;

use App\Models\Essay;
use App\Models\Session;
use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Services\EssayService;
use Illuminate\Support\Facades\Auth;

class EssaysController extends Controller {
	public function index() {

	}

	public function create( Request $request ) {


	}

	public function store( Request $request ) {

	}

	public function show() {
        $essays     = Essay::whereHas('session', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();
        if (Auth::user()->isStudent()) {
            $essays     = Essay::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
        }
        return view( 'dashboard.listings.essays', compact( 'essays'));
	}

	public function edit() {

	}

	public function update(Request $request) {
		$title       = $request->input( 'title' );
		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
		$userId      = Auth::user()->id;
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );
		$countLetter += strlen( preg_replace( '/[^A-Z0-9]/i', "", $title ) );

		$session = Session::find( $sessionId );
		if ( ! $session ) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Session not found'
			] );
		}

		$input = array(
			'title'        => $title,
			'content'      => $content,
			'count_letter' => $countLetter,
			'session_id'   => $sessionId,
            'user_id'      => $userId
		);

		$essay = $session->essay;
		if (!$essay) {
			$essay = EssayService::create($input);
		}
		else {
			EssayService::update($essay, $input);
		}

		SessionService::recount( $session );

		return response()->json( [
			'status' => 1,
		] );
	}

	public function destroy() {

	}


}
