<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'body',
        'creator_id',
    ];

    public function creator(){
        return $this->belongsTo('App\Models\User','creator_id');
    }

  
}
