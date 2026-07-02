<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Заголовок и кнопка "Назад" -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Клиент: {{ client.name }}</h1>
                        <a :href="route('clients.index')" class="text-blue-500 hover:underline">
                            ← Назад к списку
                        </a>
                    </div>

                    <!-- Карточка клиента -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p><strong>Email:</strong> {{ client.email }}</p>
                            <p><strong>Телефон:</strong> {{ client.phone || 'Не указан' }}</p>
                            <p><strong>Заметки:</strong> {{ client.notes || 'Нет заметок' }}</p>
                        </div>
                        <div>
                            <p><strong>Создан:</strong> {{ new Date(client.created_at).toLocaleDateString() }}</p>
                            <p><strong>Обновлён:</strong> {{ new Date(client.updated_at).toLocaleDateString() }}</p>
                            <p v-if="client.avatar">
                                <img :src="'/storage/' + client.avatar" alt="Avatar" class="w-16 h-16 rounded-full mt-2">
                            </p>
                            <p v-else>Аватар отсутствует</p>
                        </div>
                    </div>

                    <!-- Заказы клиента -->
                    <h2 class="text-xl font-semibold mb-4">Заказы клиента</h2>
                    <div v-if="client.orders && client.orders.length">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Название</th>
                                <th class="px-4 py-2 border">Сумма</th>
                                <th class="px-4 py-2 border">Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order in client.orders" :key="order.id" class="hover:bg-gray-50">
                                <td class="px-4 py-2 border text-center">{{ order.id }}</td>
                                <td class="px-4 py-2 border">{{ order.title }}</td>
                                <td class="px-4 py-2 border">{{ order.amount }} ₴</td>
                                <td class="px-4 py-2 border">
                                        <span :class="{
                                            'text-green-600': order.status === 1,
                                            'text-red-600': order.status === 0
                                        }">
                                            {{ order.status === 1 ? 'Выполнен' : 'Новый' }}
                                        </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="text-gray-500">У клиента пока нет заказов.</p>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

// Получаем данные клиента из Laravel
const props = defineProps({
    client: {
        type: Object,
        required: true,
    },
});

// Чтобы удобно было обращаться к client без props.client
const { client } = props;
</script>
