<h1>Создать новый платеж</h1>

<form action="{{ route('payments.store') }}" method="POST">
    @csrf

    <!-- Выбор клиента -->
    <div>
        <label for="client_id">Клиент</label>
        <select name="client_id" id="client_id" required>
            <option value="">Выберите клиента</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Выбор заказа -->
    <div>
        <label for="order_id">Заказ</label>
        <select name="order_id" id="order_id" required>
            <option value="">Выберите заказ</option>
            @foreach($orders as $order)
                <option value="{{ $order->id }}">
                    {{ $order->title }} — клиент: {{ $order->client->name ?? 'Не найден' }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Сумма платежа -->
    <div>
        <label for="amount">Сумма</label>
        <input type="number" name="amount" id="amount" step="0.01" placeholder="0.00" required>
    </div>

    <!-- Метод оплаты -->
    <div>
        <label for="method">Метод оплаты</label>
        <select name="method" id="method" required>
            <option value="">Выберите метод</option>
            <option value="card">Картой</option>
            <option value="cash">Наличными</option>
            <option value="bank_transfer">Банковский перевод</option>
        </select>
    </div>

    <button type="submit">Сохранить</button>
</form>
