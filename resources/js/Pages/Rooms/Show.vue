<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a class="btn btn-primary" :href="route('rooms.index')"><- Back</a>
            </div>
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

                    <table class="mb-4">
                        <thead>
                        <tr>
                            <th class="border border-black p-1">ID</th>
                            <th class="border border-black p-1">Name</th>
                            <th class="border border-black p-1">Slug</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border border-black p-1">{{ room.id }}</td>
                            <td class="border border-black p-1">{{ room.name }}</td>
                            <td class="border border-black p-1">{{ room.slug }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <div>
                        <h3>Latest Reading</h3>
                        <hr class="mb-2">
                        <div v-if="room.latest_reading">
                            <p :title="room.latest_reading.created_at">Timestamp: {{
                                    this.moment(room.latest_reading.created_at).fromNow()
                                }}</p>
                            <p>Temperature: {{ room.latest_reading.temperature }}°C</p>
                            <p>Humidity: {{ room.latest_reading.humidity || 'N/A' }}%</p>
                        </div>
                        <div v-else class="bg-red-700 text-white inline-block p-2">Never</div>
                    </div>
                </card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '../../Components/Card';
import RoomCard from '../../Components/RoomCard';
import JetButton from '@/Jetstream/Button';
import moment from 'moment';

export default {
    components: {
        RoomCard,
        Card,
        AppLayout,
        JetButton,
    },
    props: {
        room: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                    slug: this.room.slug,
                },
                {method: 'delete'}),
        };
    },
    methods: {
        submit() {
            this.form.delete(this.route('rooms.destroy', this.room.slug));
        },
        moment: function(date) {
            return moment(date);
        },
    },
};
</script>
