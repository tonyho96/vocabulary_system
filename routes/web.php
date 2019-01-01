<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('register/verify/{confirmationCode}', 'Auth\RegisterController@confirm')->name('verify_email');

Route::group( [ 'middleware' => [ 'auth', 'timer' ] ], function () {
	Route::get( '/', 'SessionController@showLayout')->name('home');

    Route::get('home', function () {
        return redirect('/');
    });

    Route::get('logout', 'Auth\LoginController@logout');


	Route::group(['prefix' => 'timer'], function() {
		Route::get( 'online', 'TimersController@online' )->name( 'timer_update' );
		Route::get( 'create-session', 'TimersController@createSession' )->name( 'time_update' );
	});

	Route::group( [ 'prefix' => 'dashboard' ], function () {
		Route::get( '/', 'SessionController@show' )->name( 'session_dashboard' );
		Route::get( '/detail', 'SessionController@detail' )->name( 'session_detail' );
		Route::get('/student-assign/{id}', 'SessionController@studentAssign')->name('student-assign');
	});


  Route::post('word_detail', 'WordsController@update_detail')->name( 'word_detail' );

	Route::group( [ 'prefix' => 'session' ], function () {
		Route::get( 'create', 'SessionController@create' )->name( 'create_session' );
		Route::post( '/{id}/ajax-update', 'SessionController@ajaxUpdate' );

		Route::group( [ 'prefix' => 'words' ], function () {
			Route::post( 'create', 'WordsController@create' )->name( 'addWords_session' );
			Route::post( '/{id}', 'WordsController@update' )->name( 'updateWords_session' );
		});

		Route::group( [ 'prefix' => 'sentences' ], function () {
			Route::post( 'create', 'SentencesController@create' )->name( 'addSentences_session' );
			Route::post( '/{id}', 'SentencesController@update' )->name( 'updateSentences_session' );
		} );

		Route::group( [ 'prefix' => 'paragraphs' ], function () {
			Route::post( 'create', 'ParagraphsController@create' )->name( 'addParagraphs_session' );
			Route::post( '/{id}', 'ParagraphsController@update' )->name( 'updateParagraphs_session' );
		} );

		Route::group( [ 'prefix' => 'assign' ], function () {
			Route::post( '/update/{id}', 'SessionController@updateAssign' )->name( 'updateAssign_session' );
		} );


		Route::post( 'essays', 'EssaysController@update' )->name( 'updateEssay_session' );
	} );

	Route::group( [ 'prefix' => 'listings' ], function() {
	    Route::get('/words', 'WordsController@show', function() {
            return view('dashboard.listings.words');
        });
        Route::get('/essays', 'EssaysController@show', function() {
            return view('dashboard.listings.essays');
        });
        Route::get('/sentences', 'SentencesController@show', function() {
            return view('dashboard.listings.sentences');
        });
        Route::get('/sessions', 'SessionController@showSessions', function() {
            return view('dashboard.listings.sessions');
        })->name('listings_sessions');
    });


	Route::get( '/form-words', function () {
		return view( 'dashboard.session.partials.words' );
	} );
	Route::get( '/form-sentences', function () {
		return view( 'dashboard.session.partials.sentences' );
	} );
	Route::get( '/form-paragraphs', function () {
		return view( 'dashboard.session.partials.paragraphs' );
	} );

	Route::resource('users', 'UserController');
    Route::resource('groups', 'GroupController');
    Route::resource('assignments', 'AssignmentController');

    Route::get('/user-assign', 'GroupController@userAssign');
    Route::get('/users/{id}/verify', 'UserController@verify');

    Route::group( [ 'prefix' => 'assignments', 'middleware' => ['auth']], function () {
        Route::post( '/ajax-add-group/{id}', 'AssignmentController@ajaxAddGroup' );
        Route::post( '/ajax-remove-group/{id}', 'AssignmentController@ajaxRemoveGroup' );
    });

	Route::group( [ 'prefix' => 'groups', 'middleware' => ['auth']], function () {
        Route::post( '/ajax-add-assignment/{id}', 'GroupController@ajaxAddAssignment' );
        Route::post( '/ajax-remove-assignment/{id}', 'GroupController@ajaxRemoveAssignment' );
		Route::post( '/ajax-add-member/{id}', 'GroupController@ajaxAddMember' );
		Route::post( '/ajax-remove-member/{id}', 'GroupController@ajaxRemoveMember' );
		Route::post( '/ajax-update-member-status/{id}', 'GroupController@ajaxUpdateConfirmStatus' );
		Route::post( '/ask-to-join/{id}', 'GroupController@askToJoinGroup' );
		Route::get('/enroll/{id}', 'GroupController@enroll');
		Route::post('/enroll/{id}', 'GroupController@enrollSubmit');
		Route::get('/send-enroll-request/{id}', 'GroupController@sendEnrollRequest');
	});
});
