<?php

namespace Database\Seeders;


use App\Models\Post;
use Illuminate\Database\Seeder;
use App\Models\Image;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //todo esto crea 100 post y por cada pos llama al modelo Images y crea una imagen por cada post y al crear la imagen tambien le pasas el id del post y la ruta del modelo por ejemo si es de un post seria App\Models\Post 
       $posts =  Post::factory(100)->create();
       foreach ($posts as $post) {            
            Image::factory(1)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class
            ]);
            $post->tags()->attach([
                rand(1,4),
                rand(5,8)
            ]);
       }
    }
}
