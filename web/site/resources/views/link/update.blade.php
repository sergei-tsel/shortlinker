@extends('template')

@section('title')
    Shortlinker
@endsection

@section('content')
    <form
        class="m-5"
        action="{{ route('user.link.update', ['id' => $link->id]) }}"
        method="post"
    >
        @csrf
        <div class="row mb-3">
            <label
                for="inputShortUrl1"
                class="col-sm-2 col-form-label"
            >Короткая ссылка (до 16 символов)</label>
            <div class="col-sm-10">
                <input
                    type="text"
                    name="shortUrl"
                    class="form-control"
                    id="inputShortUrl1"
                    value="{{ $link->shortUrl }}"
                >
            </div>
        </div>
        <div class="row mb-3">
            <label
                for="inputLongUrl1"
                class="col-sm-2 col-form-label"
            >Длинная ссылка</label>
            <div class="col-sm-10">
                <input
                    type="text"
                    name="longUrl"
                    class="form-control"
                    id="inputLongUrl1"
                    value="{{ $link->longUrl }}"
                >
            </div>
        </div>
        <br>
        <button
            type="submit"
            class="btn btn-primary"
        >Изменить</button>
    </form>
    <br>
    @includeWhen($folders, 'link.add', ['resources' => $folders])
    <br>
    @includeWhen($groups, 'link.add', ['resources' => $groups])
@endsection
