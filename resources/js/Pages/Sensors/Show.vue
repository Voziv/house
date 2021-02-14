<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sensor: {{ sensor.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <card>
                    <form @submit.prevent="submit">
                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                Delete
                            </jet-button>
                        </div>
                    </form>
                    <p>Name: {{ sensor.name }}</p>
                    <p>Slug: {{ sensor.slug }}</p>
                    <p>
                        Assigned to:
                        <span v-if="sensor.room">{{ sensor.room.name }}</span>
                        <span v-else>Not Assigned.</span>
                    </p>
                </card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '../../Components/Card';
import JetButton from '@/Jetstream/Button';

export default {
    components: {
        Card,
        AppLayout,
        JetButton,
    },
    props: {
        sensor: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                    slug: this.sensor.slug,
                },
                {method: 'delete'}),
        };
    },
    methods: {
        submit() {
            this.form.delete(this.route('sensors.destroy', this.sensor.slug));
        },
    },
};
</script>
