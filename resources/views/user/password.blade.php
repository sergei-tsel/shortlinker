@extends('template')

@section('title')
    Добро пожаловать!
@endsection

@section('content')
    <div class="column align-items-center">
        <h1 class="text-center mt-5">Добро пожаловать!</h1>

        <form
            class="m-5"
            action="{{ route('app.user.changePassword', ['id' => $user->id]) }}"
            method="post"
        >
            @csrf
            <div class="row mb-3">
                <label
                    for="inputPassword1"
                    class="col-sm-2 col-form-label"
                >Пароль</label>
                <div class="col-sm-10">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="inputPassword1"
                    >
                </div>
            </div>
            <div class="row mb-3">
                <label
                    for="inputNewpassword1"
                    class="col-sm-2 col-form-label"
                >Новый пароль (от 6 символов)</label>
                <div class="col-sm-10">
                    <input
                        type="password"
                        name="newpassword"
                        class="form-control"
                        id="inputNewpassword1"
                    >
                </div>
            </div>
            <div class="row mb-3">
                <label
                    for="inputNewpassword2"
                    class="col-sm-2 col-form-label"
                >Повтори новый пароль</label>
                <div class="col-sm-10">
                    <input
                        type="password"
                        name="newpassword2"
                        class="form-control"
                        id="inputNewpassword2"
                    >
                </div>
            </div>
            <br>
            <button
                type="submit"
                class="btn btn-primary"
            >Изменить пароль</button>
        </form>
    </div>
@endsection
