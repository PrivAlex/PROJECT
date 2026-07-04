<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Список Платежей</h1>
                    <a :href="route('payments.create')" class="text-4xl-green mb-6">
                        Создать Платеж
                    </a>

                    <!-- Таблица -->
                    <table class="min-w-full border border-grey-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Имя Заказчика</th>
                            <th class="px-4 py-2 border">Название Заказа</th>
                            <th class="px-4 py-2 border">Сумма платежа</th>
                            <th class="px-4 py-2 border">Метод оплаты</th>
                            <th class="px-4 py-2 border">Дата платежа</th>
                            <th class="px-4 py-2 border">Действия</th>
                            <th class="px-4 py-2 border">Редактировать</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ payment.id }}</td>
                            <td class="px-4 py-2 border text-center">{{ payment.client.name }}</td>
                            <td class="px-4 py-2 border">{{ payment.order.title }}</td>
                            <td class="px-4 py-2 border">{{ payment.amount }}</td>
                            <td class="px-4 py-2 border">{{ payment.method }}</td>
                            <td class="px-4 py-2 border">{{ new Date(payment.created_at).toLocaleDateString() }}</td>
                            <td class="px-4 py-2 border"></td>
                            <td class="px-4 py-2 border text-center">
                                <a :href="route('payments.show', payment.id)" class="text-blue-500 hover:underline">
                                    Просмотр
                                </a>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a :href="route('payments.edit', payment.id)" class="text-blue-500 hover:underline">
                                    Редактирование
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Пагинация -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            Показано {{ payments.from }}–{{ payments.to }} из {{ payments.total }} записей
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    payments: Object,
});
</script>
