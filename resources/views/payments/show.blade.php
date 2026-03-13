<p>
    Платеж:
    <a href="{{ route('payments.show', $payment->id) }}">
        {{ $payment->client->name }} — {{ $payment->order->title }}
    </a>
</p>
