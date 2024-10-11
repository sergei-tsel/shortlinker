@extends('template')

@section('title')
    Shortlinker
@endsection

@section('content')
    <div class="column align-items-center">
        <h2 class="text-center mt-3">
        @if($link->resourceType === \App\Enums\LinkResourceType::TO_FOLDER)
            Вложенные ссылки
        @elseif($link->resourceType === \App\Enums\LinkResourceType::TO_URL)
            Добавленные группы
        @endif
        </h2>
        <table class="table m-5">
            <thead>
            <tr>
                <th scope="col">Ссылка</th>
            </tr>
            </thead>
            <tbody>
            @if($link->resources)
                @foreach($link->resources as $resource)
                    @include('link.actions', ['fromLink' => $link])
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    @if($link->resourceType === \App\Enums\LinkResourceType::TO_GROUP)
        <a
            class="btn btn-primary m-5"
            href="{{ route('aways', ['shortUrl' => $link->shortUrl]) }}"
            onclick="away()"
        >Открыть все</a>
        @if(isset($urls))
            <script type="text/javascript">
                function away(urls) {
                    @for($i = 0; $i < count($urls); $i++)
                        url = '{{ $urls[$i] }}'

                    window.open(url, "_blank");
                    @endfor
                }
            </script>
        @endif
    @endif
@endsection
