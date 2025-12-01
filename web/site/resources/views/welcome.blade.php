@extends('template')

@section('title')
    Shortlinker
@endsection

@section('content')
    <div class="column align-items-center">
        <h1 class="text-center mt-3">Добро пожаловать!</h1>
        <h2 class="text-center mt-3">Пользователь: {{ $user->name }}</h2>
        <h3 class="text-center mt-3">Никнейм: {{ $user->nickname }}</h3>
        <div class="d-flex justify-content-center">
            <a
                class="btn btn-primary btn-lg m-1"
                href="{{ route('link.create') }}"
            >Создать ссылку</a>
            <a
                class="btn btn-primary btn-lg m-1"
                href="{{ route('user.update', ['id' => $user->id]) }}"
            >Изменить имя</a>
            <a
                class="btn btn-primary btn-lg m-1"
                href="{{ route('user.changePassword', ['id' => $user->id]) }}"
            >Изменить пароль</a>
        </div>
    </div>
    <div class="column align-items-center">
        <h2 class="text-center mt-3">Ссылки</h2>
        <table class="table m-5">
            <tbody>
            @foreach($urls as $url)
                @include('link.actions', ['resource' => $url])
            @endforeach
            </tbody>
        </table>

        <h2 class="text-center mt-3">Папки</h2>
        <table class="table m-5">
            <tbody>
            @foreach($folders as $folder)
                @include('link.actions', ['resource' => $folder])
            @endforeach
            </tbody>
        </table>

        <h2 class="text-center mt-3">Группы</h2>
        <table class="table m-5">
            <tbody>
            @foreach($groups as $group)
                @include('link.actions', ['resource' => $group])
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
