<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
  protected $fillable = [
        'title',
        'content',
        'count_letter',
        'session_id',
        'user_id'
    ];
    protected $table = "paragraphs";


    public function CDescriParagraphs($params) {
      $id_sessions_Paragraphs = self::where('session_id', $params['session_id'])
                                  ->where('description',$params['description'])
                                  ->update(['description' => 'NULL']);
        return $id_sessions_Paragraphs;
    }

	public function session() {
		return $this->belongsTo('App\Models\Session', 'session_id', 'id');
	}
}
