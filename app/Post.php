<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\CanBeLiked;

class Post extends Model
{
    use CanBeLiked;
    
	protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
