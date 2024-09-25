@extends('admin.base')

@section('title')
    Добро пожаловать!
@endsection

@section('page')
    <div class="column align-items-center">
        <h1 class="text-center mt-5">Добро пожаловать!</h1>

        <form class="m-5" action="{{ route('app.admin.login') }}" method="post">
            <script type="module">
                window.axios.get('/sanctum/csrf-cookie');
            </script>
            @csrf
            <div class="row mb-3">
                <label for="inputLogin1" class="col-sm-2 col-form-label">Логин</label>
                <div class="col-sm-10">
                    <input type="text" name="login" class="form-control" id="inputLogin1">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword1" class="col-sm-2 col-form-label">Пароль</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword1">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
@endsection
