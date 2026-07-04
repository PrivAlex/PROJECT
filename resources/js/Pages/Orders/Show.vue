<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Заказ #{{ order.id }}</h1>
                        <a :href="route('orders.index')" class="text-blue-500 hover:underline">
                            ← Назад к списку
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p><strong>Название:</strong> {{ order.title }}</p>
                            <p><strong>Стоимость:</strong> {{ order.amount }} ₴</p>
                            <p><strong>Статус:</strong>
                                <span :class="order.status === 1 ? 'text-green-600' : 'text-red-600'">
                                    {{ order.status === 1 ? 'Выполнен' : 'Новый' }}
                                </span>
                            </p>
                            <p><strong>Клиент:</strong> {{ order.client?.name ?? 'Не указан' }}</p>
                        </div>
                        <div>
                            <p><strong>Создан:</strong> {{ new Date(order.created_at).toLocaleDateString() }}</p>
                            <p><strong>Обновлён:</strong> {{ new Date(order.updated_at).toLocaleDateString() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    order: Object, // ← один объект заказа
});
</script>
