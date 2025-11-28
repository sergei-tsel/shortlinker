<tr>
    <th>
        <a
                class="btn btn-success"
                href="{{ route('away', ['shortUrl' => $resource->shortUrl]) }}"
                target="__blank"
        >{{ $resource->shortUrl }}</a>
    </th>
    <td>
        @if($resource->resources !== null)
            <a
                    class="btn btn-primary"
                    href="{{ route('link.resources', ['id' => $resource->id]) }}"
            >Ссылки </a>
        @endif
    </td>
    <td>
        <a
                class="btn btn-primary"
                @if(isset($fromLink))
                    href="{{ route('link.update', ['id' => $resource->id, 'fromId' => $fromLink->id]) }}"
                @else
                    href="{{ route('link.update', ['id' => $resource->id]) }}"
                @endif
        >Изменить</a>
    </td>
    <td>
        @if(isset($fromLink))
            <form
                    action="{{ route('user.link.removeResource', ['id' => $resource->id, 'fromId' => $fromLink->id]) }}"
                    method="post"
            >
                @csrf
                <button
                        type="submit"
                        class="btn btn-danger"
                >
                    @if($fromLink->resourceType === \App\Enums\LinkResourceType::TO_FOLDER)
                        Вынести на приветственную страницу
                    @else
                        Удалить из ссылки
                    @endif
                </button>
            </form>
        @endif
    </td>
    <td>
        <form
                action="{{ route('user.link.delete', ['id' => $resource->id]) }}"
                method="post"
        >
            @csrf
            <button
                    type="submit"
                    class="btn btn-danger"
            >Удалить
            </button>
        </form>
    </td>
</tr>
