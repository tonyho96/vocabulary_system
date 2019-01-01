<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
  protected $fillable = [
        'content',
        'count_letter',
        'session_id',
        'user_id'
    ];
    protected $table = 'sentences';

	public function session() {
		return $this->belongsTo('App\Models\Session', 'session_id', 'id');
	}
}
