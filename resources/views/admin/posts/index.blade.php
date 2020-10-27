@extends('layouts.app')
@section('content')
    @if (session('update'))
        <div class="alert alert-success">
            {{session('update')}}
        </div>

    @elseif (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">id</th>
          <th scope="col">Title</th>
          <th scope="col">Edit</th>
          <th scope="col">delete</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($posts as $post)
              <tr>
                  <th scope="row">{{$post->id}}</th>
                  <td>{{$post->title}}</td>
                  <td> <a href="{{route('posts.edit',$post->id)}}">Edit</a> </td>  {{--con pulsantino usare metodo get --}}
                  <td>
                      <form  action="{{route('posts.destroy',$post->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                            <button type="submit" class="btn btn-primary">Cancella</button>
                      </form>
                  </td>
              </tr>
          @endforeach
      </tbody>
    </table>
    <div class=" mt-5 justify-content-center">
        {{$posts->links()}}
    </div>
@endsection
