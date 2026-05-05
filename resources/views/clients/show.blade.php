<h1>Клиент: {{ $client->name }}</h1>
<p>Email: {{ $client->email }}</p>

<h2>Заказы клиента</h2>

@if($client->orders->isEmpty())
    <p>У клиента пока нет заказов</p>
@else
    <ul>
        @foreach($client->orders as $order)
            <li>
                {{ $order->title }} —
                {{ $order->amount }} —
                {{ $order->status ? 'Выполнен' : 'Новый' }}
            </li>
        @endforeach
    </ul>
@endif

<div>
    @if($client->avatar)
        <img src="{{ Storage::url($client->avatar) }}" width="1000">
    @else
        <p>Нет аватара</p>
    @endif
</div>


