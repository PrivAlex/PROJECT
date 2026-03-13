<h1>{{ $order->title }}</h1>

<p>{{ $order->description }}</p>

<p>
    Клиент:
    <a href="{{ route('clients.show', $order->client) }}">
        {{ $order->client->name }}
    </a>
</p>
