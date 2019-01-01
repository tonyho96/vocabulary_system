<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAssignment extends Model
{
    protected $fillable = [
        'assignment_id',
        'group_id',
    ];
    protected $table = "group_assignment";

    public function group() {
        return $this->belongsTo('App\Models\Group', 'group_id', 'id');
    }
}
