@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">

        <form action ="{{route('posts.update',$post->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <img src="{{asset('storage/'.$post->img)}}" alt="{{$post->slug}}" width="300px">
            <div class="form-group">
                <label for="img">Modifica Immagine</label>
                <input type="file" name="img" accept="iage/*">
            </div>
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" name="title" value="{{$post->title}}">
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea  class="form-control" name="body" rows="3">{{$post->body}}</textarea>
            </div>
            <div class="form-group">
                @foreach ($tags as $tag)
                    <label for="tag">{{ $tag->name }}</label>
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"{{ ($post->tags->contains($tag->id) ? 'checked' : '') }}>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Modifica</button>
        </form>
    </div>


@endsection
