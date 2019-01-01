<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use App\Services\TimerService;
use Illuminate\Http\Request;

class TimersController extends Controller {


	public function online() {
		if ( ! $user = Auth::user() ) {
			return response()->json(['status' => 0]);
		}

		TimerService::updateOnlineTimer();
		return response()->json(['status' => 1]);
	}

	public function createSession( Request $request ) {
		$sessionId = $request->input( 'session_id' );
		$session = Session::find($sessionId);
		TimerService::updateCreateSessionTimer($session);
	}
}
