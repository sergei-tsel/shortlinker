@extends('template')

@section('title')
    Добро пожаловать!
@endsection

@section('content')
    <div class="column align-items-center">
        <h1 class="text-center mt-5">Добро пожаловать!</h1>

        <form
            class="m-5"
            action="{{ route('app.user.update', ['id' => $user->id]) }}"
            method="post"
        >
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
            <br>
            <button
                type="submit"
                class="btn btn-primary"
            >Изменить имя</button>
        </form>
    </div>
@endsection
