<?php

namespace App\Services;

use App\Models\Sentence;
use Illuminate\Support\Facades\DB;
use Auth;

class SentenceService {

	public static function getAllsentences() {
		$sentences = Sentence::orderBy( 'id', 'desc' )->get();

		return $sentences;
	}

	public static function getsentences( $input ) {

		$id_sentences = Sentence::where( 'content', $input['content'] )
		                        ->where( 'session_id', $input['session_id'] )
		                        ->select( 'id' )->first();

		return $id_sentences;

	}

	/**
	 * @param $input
	 *
	 * @return bool
	 */
	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$Sentences = Sentence::create( [
				'content'      => $input['content'],
				'count_letter' => $input['count_letter'],
				'session_id'   => $input['session_id'],
                'user_id'      => Auth::user()->id,
			] );
			DB::commit();

			return $Sentences;
		} catch ( \Exception $e ) {
			DB::rollback();
			die( $e->getMessage() );

			return false;
		}
	}

	/**
	 * @param $user
	 * @param null $mes
	 *
	 * @return bool
	 */
	public static function delete( $input ) {
		DB::beginTransaction();
		try {
			if ( Sessions::update( $input ) ) {
				$Sentences = Sentence::find( $input['content'] )->where( 'session_id', '=', $input['session_id'] );
				$Sentences->delete();
			}

			DB::commit();

			return true;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public static function update( $sentence, $input ) {

		DB::beginTransaction();
		try {
			$res = $sentence->update( $input );

			DB::commit();

			return $res;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}

	}
}
