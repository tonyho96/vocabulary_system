<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
  protected $fillable = [
        'user_id',
        'type',
        'start',
        'end',
        'duration',
        'session_id',

    ];
    protected $table = "timers";

}
