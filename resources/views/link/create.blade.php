@extends('template')

@section('title')
    Shortlinker
@endsection

@section('content')
    <form
        class="m-5"
        action="{{ route('app.user.link.create') }}"
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
                >
            </div>
        </div>
        <div class="mb-3">
            <label
                for="select"
                class="form-label"
            >Тип ссылки</label>
            <select
                id="select"
                class="form-select"
                name="resourceType"
            >
                <option value="{{ \App\Enums\LinkResourceType::TO_URL->value }}">Обычная ссылка</option>
                <option value="{{ \App\Enums\LinkResourceType::TO_FOLDER->value }}">Ссылка-папка</option>
                <option value="{{ \App\Enums\LinkResourceType::TO_GROUP->value }}">Ссылка-группа</option>
            </select>
        </div>
        <br>
        <button
            type="submit"
            class="btn btn-primary"
        >Создать ссылку</button>
    </form>
@endsection
