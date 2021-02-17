<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sensor: {{ sensor.name }}
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a class="btn btn-primary" :href="route('sensors.index')"><- Back</a>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <card>
                    <form @submit.prevent="submit">
                        <div class="flex items-center justify-end mt-4">
                            <a :href="route('sensors.edit', sensor.slug)" class="inline-flex items-center px-4 py-2 bg-yellow-300 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:border-yellow-900 focus:shadow-outline-yellow transition ease-in-out duration-150 ml-4">
                                Edit
                            </a>
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                Delete
                            </jet-button>
                        </div>
                    </form>
                    <table class="mb-4">
                        <thead>
                        <tr>
                            <th class="border border-black p-1">ID</th>
                            <th class="border border-black p-1">Name</th>
                            <th class="border border-black p-1">Slug</th>
                            <th class="border border-black p-1">Room</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border border-black p-1">{{ sensor.id }}</td>
                            <td class="border border-black p-1">{{ sensor.name }}</td>
                            <td class="border border-black p-1">{{ sensor.slug }}</td>
                            <td class="border border-black p-1" v-if="sensor.room">{{ sensor.room.name }}</td>
                            <td class="border border-black p-1" v-else>-</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="mb-4 p-4 rounded text-white bg-purple-900 border-2 border-pink-500 inline-block">
                        <strong>API URI</strong>
                        <p v-if="sensor.room">
                            <code class="bg-purple-700 inline-block p-1">
                                POST: {{ route('sensorLogReading', [sensor.slug]) }}
                            </code>
                        </p>
                    </div>

                    <div v-if="sensor.latest_reading">
                        <h3>Latest Reading</h3>
                        <hr>
                        <p :title="sensor.latest_reading.created_at">Timestamp: {{
                                this.moment(sensor.latest_reading.created_at).fromNow()
                            }}</p>
                        <p>Temperature: {{ sensor.latest_reading.temperature }}°C</p>
                        <p>Humidity: {{ sensor.latest_reading.humidity || 'N/A' }}%</p>

                    </div>
                </card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import moment from 'moment';
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
            form: this.$inertia.form(
                {
                    slug: this.sensor.slug,
                },
                {
                    method: 'delete',
                },
            ),
        };
    },
    methods: {
        submit() {
            this.form.delete(this.route('sensors.destroy', this.sensor.slug));
        },
        moment: function(date) {
            return moment(date);
        },
    },
};
</script>
