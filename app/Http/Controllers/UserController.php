<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
      $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd(config('user.role.teacher'));
        if (Gate::denies('is_admin', Auth::user()))
	    	return back();
        if (Auth::user()->role == config('user.role.teacher')){
            $users = UserService::listUser([
                'role' => config('user.role.student')
                ]);
        }else{
            $users = UserService::listUser([

                ]);
        }
        

        return view('dashboard.users.index', ['users' => $users]);
        
        // if (Auth::user() && (Auth::user()->role == 1 || Auth::user()->role == 2)){
        //     
        //     return view('dashboard.users.index', ['users' => $users]);
        // }else{
        //     return view( 'home' );
        // }
       

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('is_admin',Auth::user()))
            return back();
        $users = UserService::listUser([
            'role' => config('user.role.student'),
            'parent_id' => null
            ]);
        return view('dashboard.users.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return back();
      $input = $request->all();
    //dd($input);
    //$app->end();

    $validate = UserService::validate($input);

    if ($validate->fails()) {
        return redirect()->action('UserController@create')
            ->withErrors($validate)->withInput($input)->with('message', $validate->errors()->first())->with('alert-class','alert-danger');

    }

    if (UserService::create($input)) {
        return redirect()->action('UserController@index')
            ->with('message', trans('User created successfully!'));
    }

    return redirect()->action('UserController@index')
        ->with('error', trans('Failed to created user!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return back();
      $roles = UserService::getRoles();
      $user = User::find($id);
      return view('dashboard.users.edit', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return back();
      $user = User::find($id);
      $students = UserService::listUser([
        'role' => config('user.role.student')
        ]);
      return view('dashboard.users.edit', ['user' => $user,'students' => $students]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return back();
      $user = User::find($id);
        if (!$user) {
            return redirect()->action('UserController@index')
                ->with('error', trans('Failed to update user!'));
        }

        $input = $request->all();
        $validate = UserService::validate($input, $user);
        // dd($validate->fails());
        if ($validate->fails()) {
            return redirect()->action('UserController@edit', $user->id)
                ->withErrors($validate)->withInput($input);
        }

        if (UserService::update($input, $user)) {
            return redirect()->action('UserController@index')
                ->with('message', trans('User updated successfully!'));
        }

        return back()
            ->with('error', trans('Failed to update user!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      if (UserService::delete($user)) {
          return back()->with('message', trans('User deleted successfully!'));
      }

      return back()->with('error', trans('Failed to delete user!'));
    }

    public function verify($id) {
    	$user = User::find($id);
	    $user->status = 'verified';
	    $user->save();

	    return redirect()->action('UserController@index')
	                     ->with('message', trans('User verified successfully!'));
    }
}
