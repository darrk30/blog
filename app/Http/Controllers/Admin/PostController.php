<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage; // se usa para guardar imagenes 

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:admin.posts.index')->only('index');
        $this->middleware('can:admin.posts.create')->only('create', 'store');
        $this->middleware('can:admin.posts.edit')->only('edit', 'update');
        $this->middleware('can:admin.posts.destroy')->only('destroy');
    }

    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'))->with('info', 'El post se creo con exito');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {    
        //return Storage::put('public/posts', $request->file('file'));

        $post = Post::create($request->all());     
        
        if ($request->file('file')) {
            $url = Storage::put('public/posts', $request->file('file'));
            $post->image()->create([
                'url' => $url
            ]);
        }

        Cache::flush();

        if($request->tags){
            $post->tags()->attach($request->tags); //lo que esta haciendo es llamar a la relacion tags() y al meto attach para hacer registros de muchos a muchos ocea toma el id del $post y el id de los tags que de paso han sigo guardados en un array en el formulario que lo esta recuperando en $request->tags
        }

        return redirect()->route('admin.posts.edit', $post);

    }

    public function edit(Post $post)
    {

        $this->authorize('author', $post);// este metodo sirve para tema de seguridad ocea para que un usuario no puedo ingresar a editar modificar o eliminar un post de otro autor y esta en el archivo app/Policies/PostPolicy

        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('author', $post);

        $post->update($request->all());

        if($request->file('file')){
            $url = Storage::put('public/posts', $request->file('file')); // el metodo put guarda la imagen en la carpeta public storage posts

            if ($post->image) {
                Storage::delete($post->image->url);
                $post->image->update([
                    'url' => $url
                ]);
            }else{
                $post->image()->create([
                    'url' => $url
                ]);
            }
        }

        if($request->tags){
            $post->tags()->sync($request->tags); //lo que esta haciendo es llamar a la relacion tags() y al meto sync para sincronizar registros de muchos a muchos ocea toma el id del $post y el id de los tags que de paso han sigo guardados en un array en el formulario que lo esta recuperando en $request->tags
        }

        Cache::flush();

        return redirect()->route('admin.posts.edit', $post)->with('info', 'El post se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('author', $post);
        $post->delete();
        Cache::flush();//para eliminar todos las variables de cache
        return redirect()->route('admin.posts.index')->with('info', 'La etiqueta se elimino con exito');
    }
}
