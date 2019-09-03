<?php
namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
class PostsController extends Controller
{
    public function __construct()
    {
        // Require the user to be logged in
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all the following users
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // Getting all the latest posts of the following users
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        // Check if a user is following a profile for each post
        foreach($posts as $post) {
            $isLiked = $post->isLikedBy(auth()->user());
            // Get post likes count
            $likesCount = $post->likers()->count();
            $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;
        }

        return view('posts.index', compact('posts', 'follows', 'isLiked', 'likesCount'));
    }
    
    public function create()
    {
        // Returning the form view
        return view('posts.create');
    }
    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);
        // Resize the image from the post request
        $imagePath = request('image')->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        // Pushing data to the databese
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);
        // Redirect to the profile of the post
        return redirect('/profile/' . auth()->user()->username);
    }
    public function show(Post $post)
    {
        // Get auth user
        $user = auth()->user();

        // Check if post is liked by the authenticated user
        $isLiked = $user->hasLiked($post);

        // Get post likes count
        $likesCount = $post->likers()->count();

        // Check if a user is following the profile of a post
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;
        
        return view('posts.show', compact('post', 'follows', 'isLiked', 'likesCount'));
    }

    // Handles like on the post from the auth user
    public function like(Post $post)
    {
        // Get auth user
        $user = auth()->user();
        // Toggle like to post from auth user
        return $user->toggleLike($post); 

    }

    // Handles comment on the post from the auth user
    public function comment(Post $post, Request $request)
    {
        
        $request->validate([
            'comment'=>'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $post->id;

        return Comment::create($input);
    }

    // Get all comments
    public function getComments(Post $post)
    {
        // Retrieve all comments
        $comments = $post->comments;
        
        // Return results as json
        return response()->json($comments);
    }
}