<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentLivewire extends Component
{
    public Post $post;
    public $content;
    public $comments;

    public function post(Post $post, Comment $comments)
    {
        $c = new Comment;
        $c->content = $this->content;
        $c->author = Auth::user()->name;
        $c->author_id = Auth::user()->id; 
        $c->post_id = $post->id;
        $c->save();
        
        session()->flash('message', 'Comment posted.');
    }

    public function render()
    {
        return view('livewire.comment-livewire');
    }
}
