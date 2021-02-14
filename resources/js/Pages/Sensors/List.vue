<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sensors
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a class="btn btn-primary" :href="route('sensors.create')">Add</a>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-flow-col grid-cols-3 grid-rows-4 gap-4">
                    <card v-for="sensor in sensors" :key="sensor.id">
                        <a :href="route('sensors.show', sensor.slug)">
                            {{ sensor.name }}
                        </a>
                    </card>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '../../Components/Card';

export default {
    components: {
        AppLayout,
        Card,
    },
    props: {
        sensors: Array,
    },
};
</script>
