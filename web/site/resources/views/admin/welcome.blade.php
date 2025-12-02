@extends('admin.base')

@section('title')
    Admin
@endsection

@section('page')
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="btn btn-primary btn-lg" href="{{ route('admin.welcome') }}">SHORTLINKER</a>
            <a class="btn btn-success btn-lg" href="{{ route('admin.user.all') }}">Пользователи</a>
            <a class="btn btn-success btn-lg" href="{{ route('admin.link.all') }}">Ссылки</a>
            <form action="{{ route('api.admin.logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">Выйти</button>
            </form>
        </div>
    </nav>
    <div class="column align-items-center">
        <h1 class="text-center mt-5">Добро пожаловать!</h1>
        <div class="m-5">@yield('content')</div>
    </div>
@endsection
