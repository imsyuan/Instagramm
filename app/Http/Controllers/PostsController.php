<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all users who you are following
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // Get all posts and order, and only show 5 posts
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption'   =>  'required',
            'image'     =>  ['required', 'image'],
        ]);

        //  Store image of the post
        $imagePath = request('image')->store('uploads', 'public');  // store image to public/uploads
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
        $image->save();

        auth()->user()->posts()->create([
                'caption'   =>  $data['caption'],
                'image'     =>  $imagePath,
        ]);

        return redirect('/profile/'. auth()->user()->id);
    }

    public function show(\App\Post $post)
    {
        return view('posts.show',  compact('post'));
    }
}

