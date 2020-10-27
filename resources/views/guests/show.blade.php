
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sn-6 p5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$post['title']}}</h5>
                    <p>{{$post->body}}</p>
                    <br>
                    <small>Autore : {{$post->user->name}}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
