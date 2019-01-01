<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use App\Models\Session;
use App\Services\SentenceService;
use App\Services\ParagraphService;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ParagraphsController extends Controller {
	//Paragraphs
	public function index() {

	}

	public function create( Request $request ) {
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
		if ( $word = ParagraphService::create( $input ) ) {
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

	}

	public function edit() {

	}

	public function update( $id, Request $request ) {
		$title       = $request->input( 'title' );
		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
        $userId      = Auth::user()->id;
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );
		$countLetter += strlen( preg_replace( '/[^A-Z0-9]/i', "", $title ) );
		$input       = array(
			'title'        => $title,
			'content'      => $content,
			'session_id'   => $sessionId,
			'count_letter' => $countLetter,
            'user_id'      => $userId
		);

		$paragraph = Paragraph::find( $id );
		if ( ! $paragraph ) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Paragraph not found'
			] );
		}

		$session = Session::find( $sessionId );
		if ( ! $session ) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Session not found'
			] );
		}

		if ( ParagraphService::update( $paragraph, $input ) ) {
			SessionService::recount( $session );

			return response()->json( [
				'status' => 1,
				'data'   => [ 'id' => $paragraph->id ]
			] );
		}

		return response()->json( [
			'status'  => 0,
			'message' => 'Unknown Error'
		] );
	}

	public function destroy() {

	}


}
