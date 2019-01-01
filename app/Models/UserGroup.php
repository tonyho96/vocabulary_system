<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'is_confirmed',
    ];
    protected $table = "user_group";

    public function group() {
        return $this->belongsTo('App\Models\Group', 'group_id', 'id');
    }
}
