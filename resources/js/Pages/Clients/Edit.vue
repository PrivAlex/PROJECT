<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Редактировать клиента</h1>

                    <form @submit.prevent="submit">
                        <!-- Поле "Имя" -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                            <input
                                id="name"
                                type="text"
                                v-model="form.name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            />
                            <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
                        </div>

                        <!-- Поле "Email" -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            />
                            <div v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</div>
                        </div>

                        <!-- Поле "Телефон" -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                            <input
                                id="phone"
                                type="text"
                                v-model="form.phone"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            />
                            <div v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</div>
                        </div>

                        <!-- Поле "Заметки" -->
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Заметки</label>
                            <textarea
                                id="notes"
                                v-model="form.notes"
                                rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            ></textarea>
                        </div>

                        <!-- Поле "Аватар" -->
                        <div class="mb-4">
                            <label for="avatar" class="block text-sm font-medium text-gray-700">Аватар</label>
                            <input
                                id="avatar"
                                type="file"
                                @change="handleFileUpload"
                                class="mt-1 block w-full"
                            />
                            <div v-if="client.avatar" class="mt-2">
                                <img :src="'/storage/' + client.avatar" alt="Текущий аватар" class="w-16 h-16 rounded-full">
                            </div>
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end mt-4">
                            <a :href="route('clients.index')" class="text-gray-600 hover:text-gray-900 mr-4">
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

// 1. Получаем клиента из пропсов (передаётся из контроллера)
const props = defineProps({
    client: {
        type: Object,
        required: true,
    },
});

const { errors } = usePage().props;

// 2. Создаём форму, заполняя поля данными клиента
const form = useForm({
    name: props.client.name,
    email: props.client.email,
    phone: props.client.phone || '',
    notes: props.client.notes || '',
    avatar: null, // Для нового файла
});

const handleFileUpload = (event) => {
    form.avatar = event.target.files[0];
};

// 3. Отправка формы на обновление
const submit = () => {
    form.put(route('clients.update', props.client.id), {
        onSuccess: () => {
            window.location.href = route('clients.index');
        },
        onError: (err) => {
            console.log('Ошибка:', err);
        },
    });
};
</script>
