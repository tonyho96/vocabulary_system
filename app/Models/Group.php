<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
    	'id',
        'name',
        'description',
	    'author_user_id',
	    'enroll_code',
        'date',
        'grade'
    ];
    protected $table = "groups";

    public function session() {
        return $this->belongsTo('App\Models\Session', 'session_id', 'id');
    }

    public function author() {
	    return $this->belongsTo('App\User', 'author_user_id', 'id');
    }

	public function allMembers() {
		return $this->belongsToMany('App\User', 'user_group', 'group_id', 'user_id', 'id', 'id')->withPivot('is_confirmed');
	}

    public function allAssignments() {
        return $this->belongsToMany('App\Models\Assignment', 'group_assignment', 'group_id', 'assignment_id', 'id', 'id');
    }
}
