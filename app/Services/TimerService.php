<?php

namespace App\Services;

use App\Models\Timer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Session;

class TimerService {

	public static function create( $input ) {
		DB::beginTransaction();
		try {
			$Timers = Timer::create( $input );
			DB::commit();

			return $Timers;
		} catch ( \Exception $e ) {
			DB::rollback();
			die( $e->getMessage() );

			return false;
		}
	}

	public static function startCreateSessionTimer( $session ) {
		DB::beginTransaction();
		try {
			$currentTime = date( 'Y-m-d H:i:s' );
			$timers      = Timer::create( [
				'user_id'    => $session->user_id,
				'type'       => config( 'timer.types.create_session' ),
				'start'      => $currentTime,
				'end'        => $currentTime,
				'duration'   => 0,
				'session_id' => $session->id,
			] );
			DB::commit();

			return $timers;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	public static function updateCreateSessionTimer( $session ) {
		DB::beginTransaction();
		try {
			$timer = Timer::where( 'user_id', '=', $session->user_id )
			              ->where( 'type', '=', config( 'timer.types.create_session' ) )
			              ->where( 'session_id', '=', $session->id )
			              ->first();

			$end      = new DateTime();
			$start    = new DateTime( $timer->start );
			$duration = $end->diff( $start )->format( '%H:%i:%s' );

			$timer->update( [
				'end'      => $end,
				'duration' => $duration
			] );
			DB::commit();

			return true;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	public static function update( $timer, $input ) {
		DB::beginTransaction();
		try {
			$res = $timer->update( $input );

			DB::commit();

			return $res;
		} catch ( \Exception $e ) {
			DB::rollback();

			return false;
		}
	}

	public static function startOnlineTimer() {
		if ( ! Auth::check() ) {
			return;
		}

		$user_id      = Auth::user()->id;
		$interval     = config( 'timer.interval' );
		$paddingTime  = config( 'timer.padding_time' );
		$previousTime = date( 'Y-m-d H:i:s', strtotime( "- $interval MINUTE - $paddingTime SECOND" ) );
		$runningTimer = Timer::where( 'user_id', '=', $user_id )
		                     ->where( 'type', '=', config( 'timer.types.online' ) )
		                     ->where( 'end', '>', $previousTime )
		                     ->first();

		// if have a timer which is updated about 1 minute ago => don't need to create the new one, we can reuse it
		if ( $runningTimer ) {
			return;
		}

		$currentDate = date( 'Y-m-d H:i:s' );
		Session::put( 'online_timer_start', $currentDate );
		$input = [
			'user_id'  => $user_id,
			'type'     => config( 'timer.types.online' ),
			'start'    => $currentDate,
			'end'      => $currentDate,
			'duration' => 0
		];

		self::create( $input );
	}

	public static function updateOnlineTimer() {
		$userId = Auth::user()->id;

		$timer    = Timer::where( 'user_id', '=', $userId )
		                 ->where( 'type', '=', config( 'timer.types.online' ) )
		                 ->orderBy( 'start', 'desc' )
		                 ->first();
		$end      = new DateTime();
		$start    = new DateTime( $timer->start );
		$duration = $end->diff( $start )->format( '%H:%i:%s' );

		$input = [
			'end'      => $end,
			'duration' => $duration
		];

		self::update( $timer, $input );
	}
}
