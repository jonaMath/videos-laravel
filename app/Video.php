<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    
    //Relacion one to Many 

    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //Relacion de muchos a 1
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    

}
