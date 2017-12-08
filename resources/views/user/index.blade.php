@extends('layouts.app')

@section("styles")

@endsection

@section('content')
<div id="user-list-container">
    <user_list current_data="{{$user_data}}" current_columns="{{$user_columns}}" current_page_count="{{$page_count}}"></user_list>
</div>
@endsection

@section('scripts')
    <script src="/js/user-list.js"></script>
@endsection