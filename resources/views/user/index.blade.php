@extends('layouts.app')

@section("styles")
    <link href="/css/user-list.css" rel="stylesheet">
@endsection

@section('content')
<div id="user-manage-container" class="container">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="menu-item active">
                    <router-link to="/">User Manage</router-link>
                </li>
                <li role="presentation" class="menu-item">
                    <router-link to="/create-manage">Create User</router-link>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <router-view></router-view>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/user-manage.js"></script>

    <script>
        $('li.menu-item').click(function () {
            $('ul.nav>li').removeClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection