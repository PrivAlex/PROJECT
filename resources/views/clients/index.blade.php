    <h1>Список клиентов</h1>

<a href="{{ route('clients.create') }}">Добавить клиента</a>

<ul>
    @foreach($clients as $client)
        <li>
            {{ $client->name }} — {{ $client->email }}
            <a href="{{ route('clients.edit', $client->id) }}">Редактировать</a>
            <a href="{{ route('clients.show', $client->id) }}">Открыть</a>
            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </form>
        </li>
    @endforeach
        {{ $clients->links() }}
</ul>
