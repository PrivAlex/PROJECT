<h1>Редактировать клиента</h1>

<form action="{{ route('clients.update', $client->id)}}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{$client->name}}" required>
    <input type="email" name="email" value="{{$client->email}}" required>
    <input type="text" name="phone" value="{{$client->phone}}" >
    <input type="text" name="notes" value="{{$client->notes}}" >
    <button type="submit">Сохранить</button>
</form>
