<?php

namespace App\Services;

use App\Models\Timer;
use App\Models\UserGroup;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use DB;

class UserService
{
    public static function getRoles() {
        $result = [];
        foreach (config('user.roles') as $key => $value) {
            $result[$value] = 'users.roles.' . $key;
        }

        return $result;
    }

    public static function getStudents() {
		$students = User::where( 'role', config('user.role.student') )->get();

		return $students;
	}

    public static function listUser($conditions, $paginate = 10)
    {
        $users = User::orderBy('id', 'asc');
        foreach ($conditions as $key => $value) {
            
            $users->where($key, $value);
        }

        //if ($paginate)
        //    return $users->paginate(10);
        return $users->get();
    }


    public static function validate($input, $user= null) {
        $ruleValdates = [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required',
            
//            'role' => 'in:' . implode(',', config('user.roles')),
        ];

        if ($user) {
            $ruleValdates['email'] .= ',id,' . $user->id;
        } else {
//            $ruleValdates['password'] = 'required|confirmed';
        }

        return Validator::make($input, $ruleValdates);
    }

    public static function create($input) {
        DB::beginTransaction();
        
        try {
            $confirmation_code = str_random(30);
            $user = User::create( [
                'name' => $input['name'],
                'username' => $input['username'],
                'email'  => $input['email'],
                'password'  => bcrypt( $input['password'] ),
                'role'   => $input['role'],
                'remember_token' => null,
                'status' => 'not_verified',
                'confirmation_code' => $confirmation_code,
                'author_id' => Auth::user()->id
            ] );
            $student = User::where('id',$input['student_id']);
            $student->update(['parent_id' => $user->id]);

            $mail_data = ['confirmation_code' => $confirmation_code, 'email' => $input['email'], 'name' => $input['name']];
            Mail::send('emails.verify', $mail_data, function($message) use ($mail_data) {
                $message->to($mail_data['email'],$mail_data['name'])
                    ->subject('Verify your email address');
            });

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return false;
        }
    }

    public static function update( $input, $user ) {
        DB::beginTransaction();
        try {
            $userData = [
                'name' => $input['name'],
                'email'  => $input['email'],
               'role'   => $input['role'],
               'username' => $input['username'],
            ];

            if (Auth::user()->role == config('user.role.admin') && $input['role'] == config('user.role.parent')){
                $student = User::where('parent_id',$user->id);
                $student->update(['parent_id' => null]);
                $new_student = User::where('id',$input['student_id']);
                $new_student->update(['parent_id' => $user->id]);
            }

            if ( strlen( $input['password'] ) ) {
                $userData['password'] = bcrypt( $input['password'] );
            }

            $user->update( $userData );
            
            DB::commit();

            return $user;
        } catch ( \Exception $e ) {
            DB::rollback();

            return false;
        }
    }

    public static function delete($user, $mes = null)
    {
        DB::beginTransaction();
        try {
            Timer::where('user_id', $user->id)->delete();
            UserGroup::where('user_id', $user->id)->delete();
            $user->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}

 ?>
