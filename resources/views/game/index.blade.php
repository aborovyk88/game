@extends('layouts.app')

@section("styles")
    <link href="/css/game.css" rel="stylesheet">
@endsection

@section('content')
    <div id="game-container" class="container">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" class="menu-item active">
                        <router-link to="/">Game Run</router-link>
                    </li>
                    @role("admin")
                        <li role="presentation" class="menu-item">
                            <router-link to="/game-manage">Game Manage</router-link>
                        </li>
                    @endrole
                </ul>
            </div>
            <div class="col-md-10">
                <router-view :user_id="{{$user_id}}"></router-view>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/game.js"></script>

    <script>
        $('li.menu-item').click(function () {
            $('ul.nav>li').removeClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection