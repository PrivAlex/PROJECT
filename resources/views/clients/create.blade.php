<h1>Добавить клиента</h1>

<form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Имя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Телефон">
    <input type="text" name="notes" placeholder="Заметки">

    <div class="mb-3">
        <label for="avatar" class="form-label">Аватар</label>
        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
        @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Сохранить</button>
</form>
