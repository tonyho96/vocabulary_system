<?php

namespace App\Http\Controllers;

use App\Services\SentenceService;
use App\Services\SessionService;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Essay;
use App\Models\Paragraph;
use App\Models\Sentence;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Form;
use Html;

class SentencesController extends Controller {
	//Sentences
	public function index() {

	}

	public function create( Request $request ) {
		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );

		$session = Session::find( $sessionId );
		if ( ! $session ) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Session not found'
			] );
		}

		$input = array(
			'content'      => $content,
			'session_id'   => $sessionId,
			'count_letter' => $countLetter,
		);
		if ( $word = SentenceService::create( $input ) ) {
			SessionService::recount( $session );

			return response()->json( [
				'status' => 1,
				'data'   => [ 'id' => $word->id ]
			] );
		}

		return response()->json( [
			'status'  => 0,
			'message' => 'Unknown Error'
		] );
	}

	public function store( Request $request ) {

	}

	public function show() {
        $sentences  = Sentence::whereHas('session', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();
        if (Auth::user()->isStudent()) {
            $sentences  = Sentence::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
        }
        return view( 'dashboard.listings.sentences', compact( 'sentences'));
	}

	public function edit() {

	}

	public function update( $id, Request $request ) {
		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );

		$input       = array(
			'content'      => $content,
			'session_id'   => $sessionId,
			'count_letter' => $countLetter,
		);

		$sentence = Sentence::find( $id );
		if ( ! $sentence ) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Word not found'
			] );
		}

		$session     = Session::find($sessionId);
		if (!$session) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Session not found'
			] );
		}

		if ( SentenceService::update( $sentence, $input ) ) {
			SessionService::recount($session);

			return response()->json( [
				'status' => 1,
				'data'   => [ 'id' => $sentence->id ]
			] );
		}

		return response()->json( [
			'status'  => 0,
			'message' => 'Unknown Error'
		] );
	}

	public function destroy( Request $request ) {
//		$content = $request->input( 'content' );
//		$slug_id = $request->input( 'id_session' );
//		$input   = array(
//			'content'    => $content,
//			'session_id' => $slug_id
//		);
//
//		if ( $Sentences = SentencesService::delete( $input ) ) {
//			return $Sentences;
//		}
//
//		return $Sentences;
	}

	public function addSessionSentences() {
	}

	public function checkSessionSentences( Request $request ) {
	}
}
