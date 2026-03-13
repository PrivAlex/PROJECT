<h1>Изменить заказ</h1>

<form action="{{ route('orders.update', $order->id) }}" method="POST">

    @csrf
    @method('PUT')
    <div>
        <label for="title">Название заказа</label>
        <input type="text" name="title" id="title" placeholder="Название" required>
    </div>

    <div>
        <label for="amount">Сумма</label>
        <input type="number" name="amount" id="amount" step="0.01" placeholder="0.00" required>
    </div>

    <div>
        <label for="client_id">Клиент</label>
        <select name="client_id" id="client_id" required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>
            <input type="checkbox" name="status" value="1">
            Выполнен
        </label>
    </div>

    <button type="submit">Сохранить</button>
</form>
