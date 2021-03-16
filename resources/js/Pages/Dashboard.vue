<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-flow-row grid-cols-2 auto-rows-max gap-4">
                    <card v-for="room in rooms" :key="room.id">
                        <div class="flex mb-2">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-300 flex-1">
                                {{ room.name }}
                            </h4>
                            <div v-if="room.latest_condition_reading">
                                <span class="font-bold">
                                    {{ (room.latest_condition_reading.temperature || '') + '°C' }}
                                </span>
                                <span class="italic font-thin">
                                    @{{ (room.latest_condition_reading.humidity || '') + '%' }}
                                </span>
                            </div>
                            <div v-else>
                                <span class="font-bold text-red-500">
                                    ERROR LOADING
                                </span>
                            </div>
                        </div>

                        <hr class="mb-8">

                        <div class="mb-4" v-if="readings[room.slug]">
                            <div>
                                <temp-range-chart :height="300" :data="readings[room.slug]"/>
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
import Card from '../Components/Card';
import HumidityRangeChart from '@/Components/HumidityRangeChart';
import TempRangeChart from '@/Components/TempRangeChart';
import Vue from 'vue';

export default {
    components: {
        AppLayout,
        Card,
        HumidityRangeChart,
        TempRangeChart,
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
                    let response = await axios.get(
                        `/api/rooms/${room.slug}/readings?interval="24 hours"&bucket="30 minutes`);
                    Vue.set(this.readings, room.slug, response.data);
                });
            }
        },
    },
};
</script>
