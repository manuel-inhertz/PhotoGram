<?php

namespace App\Http\Controllers;

use App\User;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{

	use SEOTools;

	private function getUserByUsername($username) {
		return  User::where('username', $username)->firstOrFail();
	}

    public function index($username) 
    {
		
		// The SEO Stuff
		$this->seo()->setTitle( $username );
		$this->seo()->setDescription('The profile page with all the posts from a user');
		
		// Get the user by its username
		$user = $this->getUserByUsername($username);
		
		// Check if a user is following a profile
		$follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
		
		$postCount = Cache::remember('count.posts.'. $user->id, now()->addSeconds(30), function () use ($user) {
			return $user->posts->count();
		}); 
		$followersCount = Cache::remember('count.followers.'. $user->id, now()->addSeconds(30), function () use ($user) {
			return $user->profile->followers->count();
		});
		$followingCount = Cache::remember('count.following.'. $user->id, now()->addSeconds(30), function () use ($user) {
			return $user->following->count();
		});

    	return view('profiles.index', compact('user', 'follows', '', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit($username)
    {
		
		// The SEO Stuff
		$this->seo()->setTitle( 'Edit user ' . $username );
		$this->seo()->setDescription('This page shows a form to edit the user details');
		
		// Get the user by its username
		$user = $this->getUserByUsername($username);
			
    	//Authorize user to only edit own profile
    	$this->authorize('update', $user->profile);

    	return view('profiles.edit', compact('user'));
    }

    public function update($username)
    {

		// Get the user by its username
		$user = $this->getUserByUsername($username);
		

    	$data = request()->validate([
    		"title" => 'required',
    		"description" => 'required',
    		"url" => 'url',
    		"image" => '',
    	]);

    	if(request('image')) {
    		$imagePath = request('image')->store('profile', 'public');

	        // Handle image resizing
	        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
			$image->save();
			
			// Setting the image array
			$imgArray = ['image' => $imagePath];
    	}

    	auth()->user()->profile->update(array_merge($data, $imgArray ?? []));


    	return redirect("/profile/{$user->username}");
    }
}
