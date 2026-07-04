<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Изменить Платеж</h1>

                    <form @submit.prevent="submit">
                        <!-- Поле: Клиент (выпадающий список) -->
                        <div class="mb-4">
                            <label for="client_id" class="block text-sm font-medium text-gray-700">Клиент</label>
                            <select
                                id="client_id"
                                v-model="form.client_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">Выберите клиента</option>
                                <option v-for="client in clients" :key="client.id" :value="client.id">
                                    {{ client.name }}
                                </option>
                            </select>
                            <div v-if="errors.client_id" class="text-red-500 text-sm mt-1">{{ errors.client_id }}</div>
                        </div>

                        <!-- Поле: Название заказа -->
                        <div class="mb-4">
                            <label for="order_id" class="block text-sm font-medium text-gray-700">Название заказа</label>
                            <select
                                id="order_id"
                                v-model="form.order_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">Выберите заказ</option>
                                <option v-for="order in orders" :key="order.id" :value="order.id">
                                    {{ order.title }}
                                </option>
                            </select>
                            <div v-if="errors.order_id" class="text-red-500 text-sm mt-1">{{ errors.order_id }}</div>
                        </div>

                        <!-- Поле: Стоимость -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Стоимость</label>
                            <input
                                id="amount"
                                type="number"
                                step="0.01"
                                v-model="form.amount"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            />
                            <div v-if="errors.amount" class="text-red-500 text-sm mt-1">{{ errors.amount }}</div>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Метод оплаты</label>
                            <select id="method" v-model="form.method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Выберите метод</option>
                                <option value="cash">Наличные</option>
                                <option value="card">Карта</option>
                                <option value="bank_transfer">Банковский перевод</option>
                            </select>
                            <div v-if="errors.method" class="text-red-500 text-sm mt-1">{{ errors.method }}</div>
                        </div>


                        <!-- Кнопки -->
                        <div class="flex items-center justify-end mt-4">
                            <a :href="route('payments.index')" class="text-gray-600 hover:text-gray-900 mr-4">
                                Отмена
                            </a>
                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 disabled:opacity-50"
                                :disabled="form.processing"
                            >
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    payment:{
        type: Object,
        required: true,
    },
    orders: {
        type: Array,
        required: true,
    },
    clients: {
        type: Array,
        required: true,
    },
});

const { errors } = usePage().props;

const form = useForm({
    client_id: props.payment.client_id, // ID выбранного клиента
    order_id: props.payment.order_id, // ID выбранного клиента
    amount: props.payment.amount,    // Стоимость
    method: props.payment.method,

});

const submit = () => {
    form.put(route('payments.update', props.payment.id), {
        onSuccess: () => {
            window.location.href = route('payments.index');
        },
        onError: (err) => {
            console.log('Ошибка:', err);
        },
    });
};
</script>
