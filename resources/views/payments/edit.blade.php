<h1>Редактировать платеж</h1>

<form action="{{ route('payments.update', $payment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Клиент (фиксированный) -->
    <div>
        <label>Клиент</label>

        <p>
            {{ $client->name }}
        </p>

        <input type="hidden"
               name="client_id"
               value="{{ $client->id }}">
    </div>


    <!-- Заказ (только этого клиента) -->
    <div>
        <label>Заказ</label>

        <select name="order_id" required>

            @foreach($orders as $order)

                <option value="{{ $order->id }}"
                    @selected($order->id == $payment->order_id)>

                    {{ $order->title }}

                </option>

            @endforeach

        </select>

    </div>


    <!-- Сумма -->
    <div>
        <label>Сумма</label>

        <input
            type="number"
            name="amount"
            value="{{ $payment->amount }}"
            step="0.01"
            required
        >

    </div>


    <!-- Метод -->
    <div>
        <label>Метод оплаты</label>

        <select name="method" required>

            <option value="card"
                @selected($payment->method === 'card')>
                Картой
            </option>

            <option value="cash"
                @selected($payment->method === 'cash')>
                Наличными
            </option>

            <option value="bank_transfer"
                @selected($payment->method === 'bank_transfer')>
                Банк
            </option>

        </select>

    </div>


    <button>Сохранить</button>

</form>
