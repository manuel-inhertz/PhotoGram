<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
        'username'
    ];

    /*
     * The belongs to Relationship
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     
}
