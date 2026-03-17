    <h1>Список клиентов</h1>
    <form method="GET" action="{{ route('clients.index') }}">

        <input type="text"
               name="search"
               value="{{ request()->get('search') }}"
               placeholder="Поиск">

        <button type="submit">Найти</button>

    </form>

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
                <button type="submit">Удалить</button>
            </form>
        </li>
    @endforeach
        {{ $clients->withQueryString()->links() }}
</ul>
