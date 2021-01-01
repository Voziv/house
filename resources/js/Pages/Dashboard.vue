<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-flow-col grid-cols-3 grid-rows-4 gap-4">
                    <card v-for="room in rooms" :key="room.id">
                        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                            {{ room.name }}
                            -
                            {{ (room.latest_reading.temperature || "") + "°C"}}
                            @
                            {{ (room.latest_reading.humidity || "") + "%"}}
                        </h4>
                        <room-chart :temperatures="room.temperatures" />
                    </card>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Welcome from '@/Jetstream/Welcome';
import RoomCard from '../Components/RoomCard';
import RoomChart from '../Components/RoomChart';
import Card from '../Components/Card';

export default {
    components: {
        Card,
        RoomChart,
        RoomCard,
        AppLayout,
        Welcome,
    },
    props: {
        rooms: Array,
    },
};
</script>
