<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Support\Facades\DB;

class WordService {
	public static function getAllwords() {
		$words = Word::orderBy( 'id', 'desc' )->get();

		return $words;
	}

	public static function getword( $input ) {

		$id_word = Word::where( 'content', $input['content'] )
		               ->where( 'session_id', $input['session_id'] )
		               ->select( 'id' )->first();

		return $id_word;

	}

	/**
	 * @param $input
	 *
	 * @return bool
	 */
	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$Words = Word::create( $input );
			DB::commit();

			return $Words;
		} catch ( \Exception $e ) {
			DB::rollback();

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
				$Words = Word::find( $input['content'] )->where( 'session_id', '=', $input['session_id'] );
				$Words->delete();
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
	public static function update( $word, $input ) {
		DB::beginTransaction();
		try {
			$res = $word->update($input);

			DB::commit();

			return $res;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}

	}
}
