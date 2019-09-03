<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Overtrue\LaravelLike\Traits\CanBeLiked;
use App\Comment;

class Post extends Model
{
    use CanBeLiked;
    
	protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * The has Many Relationship
     *
     * @var array
     */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    

}
