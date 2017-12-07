@extends('layouts.app')

@section("styles")
    <link href="/css/game.css" rel="stylesheet">
@endsection

@section('content')
<div id="game-container">
    <monster_game user_id="{{Auth::user()->id}}"></monster_game>
</div>
@endsection

@section('scripts')
    <script src="/js/game.js"></script>
@endsection