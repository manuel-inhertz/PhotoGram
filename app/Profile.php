<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $guarded = [];

	public function profileImage()
	{
		$imgPath = ($this->image) ? $this->image : "profile/xfUCcavbSfRMvKAEKjbbkfHaO3yiAAhWjrCECt0q.jpeg" ;
		return (string) '/storage/' . $imgPath; 
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function followers()
	{
		return $this->belongsToMany(User::class);
	}

}
