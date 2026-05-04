<h1>Список заказов</h1>

<form method="GET" action="{{ route('orders.index') }}">

    <input type="text"
           name="search"
           value="{{ request()->get('search') }}"
           placeholder="Поиск">

    <button type="submit">Найти</button>

</form>


<ul>
    @foreach($orders as $order)
        <li>
            {{ $order->title }} — {{ $order->amount }}

            <!-- Показать заказ -->
            <a href="{{ route('orders.show', $order) }}">Показать</a>

            <!-- Редактировать заказ -->
            <a href="{{ route('orders.edit', $order) }}">Редактировать</a>

            <!-- Удалить заказ -->
            <form action="{{ route('orders.destroy', $order) }}?admin=1" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Удалить</button>
            </form>
        </li>
    @endforeach
        {{ $orders->withQueryString()->links() }}

        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit">Logout</button>
        </form>
</ul>
