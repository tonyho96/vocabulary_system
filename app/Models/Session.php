<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Essay;
use App\Models\Paragraph;
use App\Models\Sentence;
use App\Models\Word;

class Session extends Model {
	protected $fillable = [ 'id', 'name', 'user_id', 'is_new', 'count_letter','student_can_edit', 'assignment_id', 'student_id'];
	protected $table    = "sessions";

	public function words() {
		return $this->hasMany( 'App\Models\Word', 'session_id', 'id' );
	}

	public function sentences() {
		return $this->hasMany( 'App\Models\Sentence', 'session_id', 'id' );
	}

	public function paragraphs() {
		return $this->hasMany( 'App\Models\Paragraph', 'session_id', 'id' );
	}

	public function essay() {
		return $this->hasOne( 'App\Models\Essay', 'session_id', 'id' );
	}

	public function assignment() {
		return $this->belongsTo('App\Models\Assignment', 'assignment_id', 'id');
	}
}
