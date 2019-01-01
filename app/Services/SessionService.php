<?php

namespace App\Services;

use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionService {
	/**
	 * Get id session.
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public static function getSession( $name ) {
		$Session = Session::where( 'name', $name )->first();

		return $Session;
	}

	public static function getSessions() {
		$sessions = self::orderBy( 'id', 'desc' )->get();

		return $sessions;
	}

	/**
	 * @param $input
	 *
	 * @return bool
	 */
	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$Sessions = Session::create( [
				'name'         => $input['name'],
				'user_id'      => Auth::user()->id,
				'is_new'       => '1',
				'count_letter' => '0',
				'student_can_edit' => $input['student_can_edit']
			] );

			DB::commit();

			return $Sessions;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}

	public static function create2( $input ) {
		DB::beginTransaction();
		try {
			$Sessions = Session::create( [
				'name'         => $input['name'],
				'user_id'      => Auth::user()->id,
				'is_new'       => '1',
				'count_letter' => '0',
				'student_can_edit' => $input['student_can_edit'],
				'assignment_id' => $input['assignment_id'],
                'student_id' => $input['student_id']
			] );
			//update session name when we was created a new session
			$sessionID = $Sessions->id;
			$name = "Session ".$sessionID;
			$Sessions = Session::where( 'id', $sessionID )
			                   ->update( [ 'name' => $name ] );
			DB::commit();

			return $Sessions;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}

	public static function update( $session, $input ) {
		DB::beginTransaction();
		try {
			$input['is_new'] = 0;
			$session->update( $input );

			DB::commit();

			return $session;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	public static function updateCount( $input ) {
		DB::beginTransaction();
		try {
			$Sessions = Session::where( 'id', $input['session_id'] )
			                   ->update( [ 'count_letter' => $input['count_letter'], 'is_new' => '0' ] );


			DB::commit();

			return $Sessions;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	public static function getAllCountLetter( $session ) {
		$wordCount = $sentenceCount = $paragraphCount = $essayCount = 0;

		foreach ( $session->words as $word ) {
			$wordCount += $word->total;
		}

		foreach ( $session->sentences as $word ) {
			$sentenceCount += $word->count_letter;
		}

		foreach ( $session->paragraphs as $word ) {
			$paragraphCount += $word->count_letter;
		}

		if ( $session->essay ) {
			$essayCount = $session->essay->count_letter;
		}

		return $wordCount + $sentenceCount + $paragraphCount + $essayCount;
	}

	public static function recount($session) {
		$countLetter = self::getAllCountLetter($session);
		self::update($session, ['count_letter' => $countLetter]);
	}

	public static function updateSessionName($sessionID){
		DB::beginTransaction();
		try {
			$name = "Session ".$sessionID;
			$Sessions = Session::where( 'id', $sessionID )
			                   ->update( [ 'name' => $name ] );
			DB::commit();
			//return $Sessions;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}
}
