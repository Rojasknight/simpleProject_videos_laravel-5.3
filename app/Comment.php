<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    //mucho a uno, para los usuarios del video
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    //mucho a uno, para el video usuario
    public function video()
    {
        return $this->belongsTo('App\Video', 'video_id');
    }
}
