<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Список клиентов</h1>
                    <a :href="route('clients.create')" class="text-blue-500 hover:underline">
                        Создать клиента
                    </a>

                    <!-- Таблица -->
                    <table class="min-w-full border border-grey-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Имя</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Телефон</th>
                            <th class="px-4 py-2 border">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="client in clients.data" :key="client.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ client.id }}</td>
                            <td class="px-4 py-2 border">{{ client.name }}</td>
                            <td class="px-4 py-2 border">{{ client.email }}</td>
                            <td class="px-4 py-2 border">{{ client.phone }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a :href="route('clients.show', client.id)" class="text-blue-500 hover:underline">
                                    Просмотр
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Пагинация -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            Показано {{ clients.from }}–{{ clients.to }} из {{ clients.total }} записей
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    clients: Object,
});
</script>
