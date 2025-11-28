@extends('base')

@section('title')
    Добро пожаловать!
@endsection

@section('page')
    <div class="column align-items-center">
        <h1 class="text-center mt-5">Добро пожаловать!</h1>

        <form
            class="m-5"
            action="{{ route('auth.register') }}"
            method="post"
        >
            <script type="module">
                window.axios.get('/sanctum/csrf-cookie');
            </script>
            @csrf
            <div class="row mb-3">
                <label
                    for="inputName1"
                    class="col-sm-2 col-form-label"
                >Имя</label>
                <div class="col-sm-10">
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        id="inputName1"
                    >
                </div>
            </div>
            <div class="row mb-3">
                <label
                    for="inputNickname1"
                    class="col-sm-2 col-form-label"
                >Никнейм</label>
                <div class="col-sm-10">
                    <input
                        type="text"
                        name="nickname"
                        class="form-control"
                        id="inputNickname1"
                    >
                </div>
            </div>
            <div class="row mb-3">
                <label
                    for="inputPassword1"
                    class="col-sm-2 col-form-label"
                >Пароль (не менее 6 символов)</label>
                <div class="col-sm-10">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="inputPassword1"
                    >
                </div>
            </div>
            <div class="form-check form-switch">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    role="switch"
                    id="inputRemember1"
                >
                <label
                    class="form-check-label"
                    for="inputRemember1"
                >Запомнить меня</label>
            </div>
            <br>
            <button
                type="submit"
                class="btn btn-primary"
            >Зарегистрироваться и войти</button>
        </form>
    </div>
@endsection
