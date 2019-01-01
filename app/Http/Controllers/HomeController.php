<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\TimerService;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'auth' );

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if ( $user = Auth::user() ) {
			return view( 'home' );
		}
	}
}
