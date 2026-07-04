<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Платёж  #{{ payment.id }}</h1>
                        <a :href="route('payments.index')" class="text-blue-500 hover:underline">
                            ← Назад к списку
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p><strong>Имя Заказчика:</strong> {{ payment.client.name }}</p>
                            <p><strong>Название Заказа:</strong> {{ payment.order.title }}</p>
                            <p><strong>Сумма платежа:</strong>{{ payment.amount }} ₴</p>
                            <p><strong>Метод оплаты:</strong>{{ payment.method }}</p>
                        </div>
                        <div>
                            <p><strong>Создан:</strong> {{ new Date(payment.created_at).toLocaleDateString() }}</p>
                            <p><strong>Обновлён:</strong> {{ new Date(payment.updated_at).toLocaleDateString() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    payment: Object, // ← один объект заказа
});
</script>
