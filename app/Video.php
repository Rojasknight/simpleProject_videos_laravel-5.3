<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    //Relacion uno a muchos, para los comentarios.
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //mucho a uno, para los usuarios del video
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
