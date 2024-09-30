@extends('admin.welcome')

@section('title')
    Admin
@endsection

@section('content')
    <form class="d-flex" role="search" action="{{ route('admin.user.search') }}" method="post">
        @csrf
        <input class="form-control me-2" type="search" name="query" placeholder="Поиск по ID или никнейму" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Поиск</button>
    </form>
    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Никнейм</th>
            <th>Создан</th>
            <th>Изменён</th>
        </tr>
        @foreach($models as $model)
            <tr>
                <td>{{ $model->id }}</td>
                <td>{{ $model->name }}</td>
                <td>{{ $model->nickname }}</td>
                <td>{{ $model->created_at }}</td>
                <td>{{ $model->updated_at }}</td>
                @if($model->deleted_at === null)
                    <td>
                        <form action="{{ route('app.admin.user.block', [$model->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg">Заблокировать</button>
                        </form>
                    </td>
                @else
                    <td>
                        <form action="{{ route('app.admin.user.unblock', [$model->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg">Разблокировать</button>
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
