<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-flow-col grid-cols-1 grid-rows-4 gap-4">
                    <card v-for="room in rooms" :key="room.id">
                        <div class="flex mb-2">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300 flex-1">
                                {{ room.name }}
                            </h4>
                            <div>
                            <span class="font-bold">
                            {{ (room.latest_reading.temperature || '') + '°C' }}
                            </span>
                                <span class="italic font-thin">
                            @
                            {{ (room.latest_reading.humidity || '') + '%' }}
                            </span>
                            </div>
                        </div>

                        <hr class="mb-8">

                        <h4 class="text-center">Sensor data over the last 24 hours</h4>
                        <hr>

                        <div class="flex mb-4">
                            <div class="flex-1">
                                <temp-chart :data="room.temperatures" title="Temperature (24 hours)"/>
                            </div>
                            <div class="flex-1">
                                <humidity-chart :data="room.temperatures" title="Humidity (24 hours)"/>
                            </div>
                        </div>


                        <h4 class="text-center">Sensor data over the last week</h4>
                        <hr>

                        <div class="flex mb-4">

                            <div class="flex-1">
                                <temp-chart :data="room.temperatures_week" title="Temperature (1 week)"/>
                            </div>
                            <div class="flex-1">
                                <humidity-chart :data="room.temperatures_week" title="Humidity (1 week)"/>
                            </div>
                        </div>
                    </card>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import TempChart from '../Components/TempChart';
import Card from '../Components/Card';
import HumidityChart from '../Components/HumidityChart';

export default {
    components: {
        HumidityChart,
        Card,
        TempChart,
        AppLayout,
    },
    props: {
        rooms: Array,
    },
};
</script>
