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
                            <div v-if="room.current_condition_reading && room.current_condition_reading.length > 0">
                            <span class="font-bold" >
                            {{ (room.current_condition_reading[0].temperature || '') + '°C' }}
                            </span>
                            <span class="italic font-thin" v-if="room.current_condition_reading  && room.current_condition_reading.length > 0">
                            @
                            {{ (room.current_condition_reading[0].humidity || '') + '%' }}
                            </span>
                            </div>
                            <div v-else>
                                <span class="font-bold text-red-500">
                                    ERROR LOADING
                                </span>
                            </div>
                        </div>


                        <hr class="mb-8">

                        <h4 class="text-center">Sensor data over the last 24 hours</h4>
                        <hr>

                        <div class="flex mb-4" v-if="readings[room.slug]">
                            <div class="flex-1">
                                <temp-chart :data="readings[room.slug]" title="Temperature (24 hours)"/>
                            </div>
                            <div class="flex-1">
                                <humidity-chart :data="readings[room.slug]" title="Humidity (24 hours)"/>
                            </div>
                        </div>


                        <h4 class="text-center">Sensor data over the last week</h4>
                        <hr>

                        <div class="flex mb-4" v-if="readingsLong[room.slug]">

                            <div class="flex-1">
                                <temp-chart :data="readingsLong[room.slug]" title="Temperature (1 week)"/>
                            </div>
                            <div class="flex-1">
                                <humidity-chart :data="readingsLong[room.slug]" title="Humidity (1 week)"/>
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
import Vue from 'vue';

export default {
    components: {
        HumidityChart,
        Card,
        TempChart,
        AppLayout,
    },
    data() {
        return {
            readings: {},
            readingsLong: {},
        };
    },
    props: {
        rooms: Array,
    },
    mounted() {
        this.fetchReadings();
    },
    methods: {
        fetchReadings() {
            if (this.rooms.length > 0) {
                this.rooms.map(async (room) => {
                    let response = await axios.get(`/api/rooms/${room.slug}/readings`);
                    Vue.set(this.readings, room.slug, response.data);
                });

                this.rooms.map(async (room) => {
                    let response = await axios.get(`/api/rooms/${room.slug}/readings?interval="7 days"&bucket="3 hour"`);
                    Vue.set(this.readingsLong, room.slug, response.data);
                });
            }
        },
    },
};
</script>
