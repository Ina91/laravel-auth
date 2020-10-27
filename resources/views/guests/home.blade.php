@extends('layouts.app')
@section('content')
    <div class="display-4 p-5 text-center">
        Benvenuto nel mio blog
    </div>

    @guest
        <p clss="lead text-center">Guest</p>
    @else
        <p clss="lead text-center">Utente :{{Auth::user()->name}}</p>
    @endguest
@endsection
