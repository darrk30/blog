<?php

namespace App\Observers;

use App\Models\Post;

use Illuminate\Support\Facades\Storage;

class PostObserver
{
    
    public function creating(Post $post)
    {
        if (! \App::runningInConsole()) { //esta condicion evita que si se hacen regisros desde la consola no falle
            $post->user_id = auth()->user()->id;
        }
    }

    
    public function deleting(Post $post)
    {
        if($post->image){
            Storage::delete($post->image->url);
        }
    }

    
}
