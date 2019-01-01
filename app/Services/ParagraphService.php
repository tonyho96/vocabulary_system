<?php

namespace App\Services;

use App\Models\Paragraph;
use Illuminate\Support\Facades\DB;

class ParagraphService {

	public static function getAllparagraphs() {
		$Paragraphs = Paragraph::orderBy( 'id', 'desc' )->get();

		return $Paragraphs;
	}

	public static function getparagraphs( $input ) {
		$Paragraphs = Paragraph::where( 'title', $input['content'] )
		                       ->where( 'session_id', $input['session_id'] )
		                       ->select( 'id' )->first();

		return $Paragraphs;
	}

	/**
	 * @param $input
	 *
	 * @return bool
	 */
	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$Paragraphs = Paragraph::create( $input );
			DB::commit();

			return $Paragraphs;
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
				$Paragraphs = Paragraph::find( $input['content'] )->where( 'session_id', '=', $input['session_id'] );
				$Paragraphs->delete();
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
	public static function update( $paragraph, $input ) {
		DB::beginTransaction();
		try {
			$res = $paragraph->update($input);

			DB::commit();

			return $res;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}

	}

	public static function updateTitle( $input ) {
		DB::beginTransaction();
		try {
			$id_Paragraphs = Paragraph::where( 'session_id', $input['session_id'] )
			                          ->where( 'id', $input['id_text'] )
			                          ->update( [ 'title' => $input['title'] ] );

			DB::commit();

			return $id_Paragraphs;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}

	}


}
