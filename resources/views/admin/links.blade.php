@extends('admin.welcome')

@section('title')
    Admin
@endsection

@section('content')
    <form class="d-flex" role="search" action="{{ route('admin.link.search') }}" method="post">
        @csrf
        <input class="form-control me-2" type="search" name="query" placeholder="Поиск по ID или короткой ссылке" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Поиск</button>
    </form>
    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>Короткая ссылка</th>
            <th>Длинная ссылка</th>
            <th>Создана</th>
            <th>Изменена</th>
        </tr>
        @foreach($models as $model)
            <tr>
                <td>{{ $model->id }}</td>
                <td>{{ $model->shortUrl }}</td>
                <td>{{ $model->longUrl }}</td>
                <td>{{ $model->created_at }}</td>
                <td>{{ $model->updated_at }}</td>
                @if($model->deleted_at === null)
                    <td>
                        <form action="{{ route('app.admin.link.delete', [$model->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg">Удалить</button>
                        </form>
                    </td>
                @else
                    <td>
                        <form action="{{ route('app.admin.link.restore', [$model->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg">Восстановить</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $models->links() }}
    @if(count($models) === 0)
        <h3>Ничего не найдено</h3>
    @endif
@endsection
