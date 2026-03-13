<h1>Список заказов</h1>

<ul>
    @foreach($orders as $order)
        <li>
            {{ $order->title }} — {{ $order->amount }}

            <!-- Показать заказ -->
            <a href="{{ route('orders.show', $order) }}">Показать</a>

            <!-- Редактировать заказ -->
            <a href="{{ route('orders.edit', $order) }}">Редактировать</a>

            <!-- Удалить заказ -->
            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Удалить</button>
            </form>
        </li>
    @endforeach
    {{$orders->links()}}
</ul>
