<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['name', 'author_user_id', 'date', 'status', 'update_status', 'grade', 'instructions'];
    protected $table = "assignment";

    public function allGroups() {
        return $this->belongsToMany('App\Models\Group', 'group_assignment', 'assignment_id', 'group_id', 'id', 'id');
    }
}
