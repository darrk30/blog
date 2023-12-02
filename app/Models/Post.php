<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'create_at', 'update_at'];
    //relacion uno a muchos inversa
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //relacion uno a muchos inversa
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    //relacion muchos a muchos 
    public function tags(){
        return  $this->belongsToMany('App\Models\Tag');
    }

    //relacion uno a uno polimorfica 
    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}