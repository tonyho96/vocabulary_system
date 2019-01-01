<?php

namespace App\Services;

use App\Models\Essay;
use Illuminate\Support\Facades\DB;

class EssayService {
	/**
	 * Get id session.
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public static function getIdSession( $input ) {
		return Sessions::where( 'name', $input['name'] )->select( 'id' )->get();
	}

	public static function getAllessays() {
		$essays = Essay::orderBy( 'id', 'desc' )->get();

		return $essays;
	}

	public static function getEssays( $input ) {
		$essays = Essay::where( 'title', $input['title'] )
		               ->where( 'session_id', $input['session_id'] )
		               ->select( 'id' )->first();

		return $essays;
	}

	/**
	 * @param $input
	 *
	 * @return bool
	 */
	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$essays = Essay::create( $input );
			DB::commit();

			return $essays;
		} catch ( \Exception $e ) {
			DB::rollback();
			die( $e->getMessage() );

			return false;
		}
	}

	public static function update( $essay, $input ) {
		DB::beginTransaction();
		try {
			$res = $essay->update($input);
			DB::commit();

			return $res;
		} catch ( \Exception $e ) {
			DB::rollback();
			die( $e->getMessage() );

			return false;
		}
	}

	public static function updateTitle( $input ) {
		DB::beginTransaction();
		try {
			$id_essays = Essay::where( 'session_id', $input['session_id'] )
			                  ->where( 'id', $input['id_text'] )
			                  ->update( [ 'title' => $input['title'], 'count_letter' => $input['count_letter'] ] );

			DB::commit();

			return $id_essays;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}

	}

	public static function updateContent( $input ) {
		DB::beginTransaction();
		try {
			$id_essays = Essay::where( 'session_id', $input['session_id'] )
			                  ->where( 'id', $input['id_text'] )
			                  ->update( [ 'content' => $input['content'] ] );

			DB::commit();

			return $id_essays;
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
			$Essays = Essay::find( $input['content'] );
			$Essays->delete();
			DB::commit();

			return true;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	
}
