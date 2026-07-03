<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Список Заказов</h1>
                    <a :href="route('orders.create')" class="text-4xl-green mb-6">
                        Создать заказ
                    </a>

                    <!-- Таблица -->
                    <table class="min-w-full border border-grey-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Имя Заказчика</th>
                            <th class="px-4 py-2 border">Название Заказа</th>
                            <th class="px-4 py-2 border">Стоимость</th>
                            <th class="px-4 py-2 border">Статус</th>
                            <th class="px-4 py-2 border">Действия</th>
                            <th class="px-4 py-2 border">Редактировать</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ order.id }}</td>
                            <td class="px-4 py-2 border text-center">{{ order.client.name ?? 'Без клиента' }}</td>
                            <td class="px-4 py-2 border">{{ order.title }}</td>
                            <td class="px-4 py-2 border">{{ order.amount }}</td>
                            <td class="px-4 py-2 border">
    <span :class="{
        'text-green-600': order.status === 1,
        'text-red-600': order.status === 0
    }">
        {{ order.status === 1 ? 'Выполнен' : 'Новый' }}
    </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a :href="route('orders.show', order.id)" class="text-blue-500 hover:underline">
                                    Просмотр
                                </a>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a :href="route('orders.edit', order.id)" class="text-blue-500 hover:underline">
                                    Редактирование
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Пагинация -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            Показано {{ orders.from }}–{{ orders.to }} из {{ orders.total }} записей
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    orders: Object,
});
</script>
