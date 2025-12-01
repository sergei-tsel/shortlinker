<form
        class="m-5"
        @if(empty($fromId))
            action="{{ route('api.user.link.addResource', ['id' => $link->id]) }}"
        @else
            action="{{ route('api.user.link.moveResource', ['id' => $link->id, 'fromId' => $fromId]) }}"
        @endif
        method="post"
>
    @csrf
    <div class="mb-3">
        <select
                class="form-select"
                name="toId"
        >
            @foreach($resources as $resource)
                <option value="{{ $resource->id }}">{{ $resource->shortUrl }}</option>
            @endforeach
        </select>
    </div>
    <br>
    <button
            type="submit"
            class="btn btn-primary"
    >
        @if($resources->first()->resourceType === \App\Enums\LinkResourceType::TO_GROUP)
            Добавить группу
        @else
            @if(empty($fromId))
                Переместить в папку
            @else
                Переместить в другую папку
            @endif
        @endif
    </button>
</form>
