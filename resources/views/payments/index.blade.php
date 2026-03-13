<h1>Список платежей</h1>

<ul>
    @foreach($payments as $payment)
        <li>
            Платеж #{{ $payment->id }}:
            Сумма — {{ $payment->amount }}₴,
            Метод — {{ $payment->method }},
            Клиент — {{ $payment->client->name ?? 'Не найден' }},
            Заказ — {{ $payment->order->title ?? 'Не найден' }},
            Дата — {{ $payment->created_at->format('d.m.Y') }}
        </li>
    @endforeach
    {{$payments->links()}}
</ul>
