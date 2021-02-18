<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add new sensor
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a class="btn btn-primary" :href="route('sensors.index')"><- Back</a>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <card>
                    <jet-validation-errors class="mb-4"/>

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="Name"/>
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                       autofocus/>
                        </div>

                        <div class="mt-4">
                            <jet-label for="slug" value="Slug"/>
                            <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" required/>
                        </div>

                        <div class="mt-4">
                            <jet-label for="room_id" value="Room"/>
                            <select id="room_id" class="mt-1 block w-full" v-model="form.room_id">
                                <option value="0">None</option>
                                <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }}</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                Create
                            </jet-button>
                        </div>
                    </form>
                </card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import JetValidationErrors from '@/Jetstream/ValidationErrors';
import JetButton from '@/Jetstream/Button';
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';

export default {
    components: {
        AppLayout,
        Card,
        JetValidationErrors,
        JetButton,
        JetInput,
        JetLabel,
    },
    props: {
        rooms: Array,
        sensor: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: 'My sensor',
                slug: 'my-sensor-slug',
                room_id: (this.sensor.room) ? this.sensor.room_id : 0,
            }),
        };
    },
    methods: {
        submit() {
            this.form.transform(data => ({
                ...data,
            })).post(this.route('sensors.store'));
        },
    },
};
</script>
