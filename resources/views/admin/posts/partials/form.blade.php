<div class="form-group">
    {!! Form::label('name','Nombre') !!}
    {!! Form::text('name',null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del post']) !!}
    @error('name')
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('slug','Slug') !!}
    {!! Form::text('slug',null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del slug', 'readonly']) !!}
    @error('slug')
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('category_id', 'Categoría') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
    @error('category_id')
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>
<div class="form-group">
    <p class="font-weight-bold">Etiquetas</p>
    @foreach ($tags as $tag)
        <label class="mr-2">
            {!! Form::checkbox('tags[]',$tag->id, null) !!}
            {{$tag->name}}
        </label>
    @endforeach
    
    @error('tags')
        <br>
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>

<div class="form-group">
    <p class="font-weight-bold">Estado del Post</p>
    <label>
        {!! Form::radio('status', 1, true) !!}
        Borrador
    </label>
    <label>
        {!! Form::radio('status', 2) !!}
        Publicado
    </label>                    
    @error('status')
        <br>
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="row mb-3">
    <div class="col">
        <div class="image-wrapepr">
            @isset ($post->image)
                <img id="picture" src="{{Storage::url($post->image->url)}}" alt="imagen predeterminada">
            @else
                <img id="picture" src="https://cdn.pixabay.com/photo/2023/10/27/15/51/italy-8345688_1280.jpg" alt="imagen predeterminada">
            @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('file', 'Imagen del Post') !!}
            {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}@error('file')                            
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum, magnam. Consequuntur eius delectus dolor magni officia possimus necessitatibus eum aut minima rem. Beatae, recusandae! Adipisci, iure ullam! Tempore, dicta error.
        </p>
    </div>
</div>
<div class="form-group">
    {!! Form::label('extract', 'Extracto') !!}
    {!! Form::textarea('extract',null, ['class' => 'form-control']) !!}

    @error('extract')
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('body', 'Cuerpo del Post') !!}
    {!! Form::textarea('body',null, ['class' => 'form-control']) !!}   
    
    @error('body')
        <samp class="text-danger">{{$message}}</samp>
    @enderror
</div>