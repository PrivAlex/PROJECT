<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Редактировать заказ #{{ order.id }}</h1>

                    <form @submit.prevent="submit">
                        <!-- Поле: Клиент (выпадающий список) -->
                        <div class="mb-4">
                            <label for="client_id" class="block text-sm font-medium text-gray-700">Клиент</label>
                            <select
                                id="client_id"
                                v-model="form.client_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Выберите клиента</option>
                                <option v-for="client in clients" :key="client.id" :value="client.id">
                                    {{ client.name }}
                                </option>
                            </select>
                            <div v-if="errors.client_id" class="text-red-500 text-sm mt-1">{{ errors.client_id }}</div>
                        </div>

                        <!-- Поле: Название заказа -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Название заказа</label>
                            <input
                                id="title"
                                type="text"
                                v-model="form.title"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            />
                            <div v-if="errors.title" class="text-red-500 text-sm mt-1">{{ errors.title }}</div>
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

                        <!-- Поле: Статус (чекбокс) -->
                        <div class="mb-4 flex items-center">
                            <input
                                id="status"
                                type="checkbox"
                                v-model="form.status"
                                class="mr-2"
                            />
                            <label for="status" class="text-sm text-gray-700">Заказ выполнен</label>
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end mt-4">
                            <a :href="route('orders.index')" class="text-gray-600 hover:text-gray-900 mr-4">
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

// Данные от контроллера: заказ и список клиентов
const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    clients: {
        type: Array,
        required: true,
    },
});

const { errors } = usePage().props;

// Заполняем форму данными заказа
const form = useForm({
    client_id: props.order.client_id,
    title: props.order.title,
    amount: props.order.amount,
    status: props.order.status === 1, // преобразуем 1/0 в true/false для чекбокса
});

const submit = () => {
    form.put(route('orders.update', props.order.id), {
        onSuccess: () => {
            window.location.href = route('orders.index');
        },
        onError: (err) => {
            console.log('Ошибка:', err);
        },
    });
};
</script>
