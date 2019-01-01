<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
  protected $fillable = [
        'title',
        'content',
        'count_letter',
        'session_id',
        'user_id'
    ];
    protected $table = "essays";

	public function session() {
		return $this->belongsTo('App\Models\Session', 'session_id', 'id');
	}
}
