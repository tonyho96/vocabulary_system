<?php

namespace App;

use App\Models\Essay;
use App\Models\Paragraph;
use App\Models\Sentence;
use App\Models\Session;
use App\Models\UserGroup;
use App\Models\Word;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'parent_id', 'status', 'confirmation_code', 'author_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isTeacher()
    {
        return $this->role == config('user.role.teacher');
    }

    public function isAdmin(){
        return $this->role == config('user.role.admin');
    }

	public function isStudent(){
		return $this->role == config('user.role.student');
	}

	public function isParent(){
		return $this->role == config('user.role.parent');
	}

    public function canEditWord($id) {
    	if ($this->isTeacher())
    		return true;

    	$word = Word::find($id);
    	$session = $word->session;

    	if ($session->student_id == $this->id)
    		return true;

    	return false;
    }

	public function canEditSentence($id) {
		if ($this->isTeacher())
			return true;

		$sentence = Sentence::find($id);
		$session = $sentence->session;

		if ($session->student_id == $this->id)
			return true;

		return false;
	}

	public function canEditParagraph($id) {
		if ($this->isTeacher())
			return true;

		$paragraph = Paragraph::find($id);
		$session = $paragraph->session;

		if ($session->student_id == $this->id)
			return true;

		return false;
	}

	public function canEditEssay($id) {
		if ($this->isTeacher())
			return true;

		$essay = Essay::find($id);
		$session = $essay->session;

		if ($session->student_id == $this->id)
			return true;

		return false;
	}

	public function allGroups() {
		return $this->belongsToMany('App\Models\Group', 'user_group', 'user_id', 'group_id', 'id', 'id')->withPivot('is_confirmed');
	}

	public function isInGroup($groupId) {
		$existingData = UserGroup::where('user_id', $this->id)->where('group_id', $groupId)->first();
		return $existingData;
	}

	public function assignments() {
		return $this->hasMany('App\Models\Assignment', 'author_user_id', 'id');
	}

	public function words() {
		if ($this->isAdmin())
			return Word::all();
		if ($this->isTeacher()) {
			return $this->hasManyThrough('App\Models\Word', 'App\Models\Session', 'user_id', 'session_id', 'id', 'id')->get();
		}

		return $this->hasManyThrough('App\Models\Word', 'App\Models\Session', 'student_id', 'session_id', 'id', 'id')->get();
	}

	public function sentences() {
		if ($this->isAdmin())
			return Sentence::all();
		if ($this->isTeacher()) {
			return $this->hasManyThrough('App\Models\Sentence', 'App\Models\Session', 'user_id', 'session_id', 'id', 'id')->get();
		}

		return $this->hasManyThrough('App\Models\Sentence', 'App\Models\Session', 'student_id', 'session_id', 'id', 'id')->get();
	}

	public function paragraphs() {
		if ($this->isAdmin())
			return Paragraph::all();
		if ($this->isTeacher()) {
			return $this->hasManyThrough('App\Models\Paragraph', 'App\Models\Session', 'user_id', 'session_id', 'id', 'id')->get();
		}

		return $this->hasManyThrough('App\Models\Paragraph', 'App\Models\Session', 'student_id', 'session_id', 'id', 'id')->get();
	}

	public function essays() {
		if ($this->isAdmin())
			return Essay::all();
		if ($this->isTeacher()) {
			return $this->hasManyThrough('App\Models\Essay', 'App\Models\Session', 'user_id', 'session_id', 'id', 'id')->get();
		}

		return $this->hasManyThrough('App\Models\Essay', 'App\Models\Session', 'student_id', 'session_id', 'id', 'id')->get();
	}

	public function sessions() {
		if ($this->isAdmin())
			return Session::all();
		if ($this->isTeacher()) {
			return $this->hasMany('App\Models\Session', 'user_id', 'id')->get();
		}

		return $this->hasMany('App\Models\Session', 'student_id', 'id')->get();
	}

	public function timers() {
		return $this->hasMany('App\Models\Timer', 'user_id', 'id');
	}
}
