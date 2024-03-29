<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::paginate(10);
        return view('users.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|max:500',
            'title' => 'required|max:150',
            'content' => 'required|max:2000',
        ]);



        $file = $request->hasFile('image');
        if($file){
            $newFile = $request->file('image');
            $file_path = $newFile->store('images');
            
            $p = new Post;
            $p->image = $validatedData['image'];
            $p->image_name = $file_path; 
            $p->title = $validatedData['title'];
            $p->content = $validatedData['content'];
            $p->user_id = Auth::user()->id; #this is for testing purposes will have to get the id of the user when making a post later
            $p->save();
        } else {
            $p = new Post;
            $p->image = null;
            $p->image_name = null; 
            $p->title = $validatedData['title'];
            $p->content = $validatedData['content'];
            $p->user_id = Auth::user()->id; #this is for testing purposes will have to get the id of the user when making a post later
            $p->save();
        }        

        //dd($request->file());

        //$name = $request->file('image')->getClientOriginalName();
        //return $name;

        session()->flash('message', 'The post was created.');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        $comments = Comment::get(); 
        $id_user = Auth::user()->id;
        $user_role = Auth::user()->role;
        return view('users.show', ['post' => $post, 'comments' => $comments, 'id_user' => $id_user, 'user_role' => $user_role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        //$post = Post::find($post);
        //return "Not yet";
        return view('users.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $file = $request->hasFile('image');
        if($file){
            $newFile = $request->file('image');
            $file_path = $newFile->store('images');
            
            $post->image_name = $file_path; 
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->update();
        } else {
            $post->image_name = null;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->update();
        }

        

        session()->flash('message', 'The post was updated successfully.');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();

        return redirect()->route('users.index')->with('message', 'Post was deleted.');
    }

    public function search()
    {
        $search_text = $_GET['search'];
        //$posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->paginate(5);
        $posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->get();

        return view('users.search', ['posts' => $posts]);
    }
}
