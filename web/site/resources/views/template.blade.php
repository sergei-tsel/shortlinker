@extends('base')

@section('title')
    Shortlinker
@endsection

@section('page')
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a
                class="btn btn-primary btn-lg"
                href="{{ route('welcome') }}"
            >SHORTLINKER</a>
            <form
                action="{{ route('auth.logout') }}"
                method="post"
            >
                @csrf
                <button
                    type="submit"
                    class="btn btn-danger btn-lg"
                >Выйти</button>
            </form>
        </div>
    </nav>
    @yield('content')
@endsection
