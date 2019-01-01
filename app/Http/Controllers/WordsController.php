<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Word;
use App\Services\SessionService;
use App\Services\WordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class WordsController extends Controller {

	//words
	public function index() {

	}

	public function create( Request $request ) {
		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
        $userId      = Auth::user()->id;
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );

		$session     = Session::find($sessionId);
		if (!$session) {
			return response()->json( [
				'status'  => 0,
				'message' => 'Session not found'
			] );
		}

		$input = array(
			'content'     => $content,
			'session_id'  => $sessionId,
			'count_letter' => $countLetter,
            'total'        => $countLetter,
            'user_id'      => $userId
		);
		if ( $word = WordService::create( $input ) ) {
			SessionService::recount($session);

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
        $words      = Word::whereHas('session', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();
        if (Auth::user()->isStudent()) {
            $words      = Word::whereHas('session', function ($query) {
                $query->where('student_id', Auth::user()->id);
            })->get();
        }
        return view( 'dashboard.listings.words', compact( 'words'));
	}

	public function edit() {

	}

	public function update( $id, Request $request ) {
		$word = Word::find( $id );

		$content     = $request->input( 'content' );
		$sessionId   = $request->input( 'session_id' );
        $userId      = Auth::user()->id;
		$countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );

		$total       = $word->countAll() - $word->count_letter;
		$total      += $countLetter;

		$input       = array(
			'content'      => $content,
			'session_id'   => $sessionId,
			'count_letter' => $countLetter,
            'total'        => $total,
            'user_id'      => $userId
		);

		if ( ! $word ) {
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

		if ( WordService::update( $word, $input ) ) {
			SessionService::recount($session);

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

	public function update_detail() {
        $id = $_POST['id'];
        $word = Word::find( $id );
	    $content = $_POST['word'];
        $countLetter = strlen( preg_replace( '/[^A-Z0-9]/i', "", $content ) );
        $synonym = $_POST['synonym'];
        $countSynonym = strlen( preg_replace( '/[^A-Z0-9]/i', "", $synonym ) );
        $antonym = $_POST['antonym'];
        $countAntonym = strlen( preg_replace( '/[^A-Z0-9]/i', "", $antonym ) );
        $suffix = $_POST['suffix'];
        $countSuffix = strlen( preg_replace( '/[^A-Z0-9]/i', "", $suffix ) );
        $prefix = $_POST['prefix'];
        $countPrefix = strlen( preg_replace( '/[^A-Z0-9]/i', "", $prefix ) );
        $wordtype = $_POST['wordtype'];
        $countWordType = strlen( preg_replace( '/[^A-Z0-9]/i', "", $wordtype ) );
        $def = $_POST['def'];
        $countDef = strlen( preg_replace( '/[^A-Z0-9]/i', "", $def ) );

        $total = $countLetter + $countSynonym + $countAntonym + $countSuffix + $countPrefix + $countWordType + $countDef;
        $input = array(
            'content'      => $content,
            'count_letter' => $countLetter,
            'synonym' => $synonym,
            'count_synonym' => $countSynonym,
            'antonym' => $antonym,
            'count_antonym' => $countAntonym,
            'suffix' => $suffix,
            'count_suffix' => $countSuffix,
            'prefix' => $prefix,
            'count_prefix' => $countPrefix,
            'word_type' => $wordtype,
            'count_word_type' => $countWordType,
            'definition' => $def,
            'count_definition' => $countDef,
            'total' => $total
        );

        DB::beginTransaction();
        try {
            $word->update($input);
	        SessionService::recount($word->session);
	        DB::commit();

            return redirect()->back();
        } catch ( \Exception $e ) {
            DB::rollback();
            return false;
        }
    }

	public function destroy( Request $request ) {
//		$content = $request->input( 'content' );
//		$slug_id = $request->input( 'id_session' );
//		$input   = array(
//			'content'    => $content,
//			'session_id' => $slug_id
//		);
//
//		if ( $Words = WordService::delete( $input ) ) {
//			return $Words;
//		}

	}

}
