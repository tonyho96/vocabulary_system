<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
  protected $fillable = [
        'content',
        'count_letter',
        'synonym',
        'count_synonym',
        'antonym',
        'count_antonym',
        'suffix',
        'count_suffix',
        'prefix',
        'count_prefix',
        'word_type',
        'count_word_type',
        'definition',
        'count_definition',
        'session_id',
        'total',
        'user_id'
    ];
    protected $table = "words";

	public function session() {
		return $this->belongsTo('App\Models\Session', 'session_id', 'id');
	}

	public function countAll() {
		$countFields = ['count_letter', 'count_synonym', 'count_antonym', 'count_suffix', 'count_prefix', 'count_word_type', 'count_definition', ''];
		$total = 0;
		foreach ($countFields as $countField) {
			$total += $this->{$countField} | 0;
		}

		return $total;
	}
}
