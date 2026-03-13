<h1>Добавить клиента</h1>

<form action="{{ route('clients.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Имя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Телефон">
    <input type="text" name="notes" placeholder="Заметки">
    <button type="submit">Сохранить</button>
</form>
