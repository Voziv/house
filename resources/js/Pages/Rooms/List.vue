<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-flow-col grid-cols-3 grid-rows-4 gap-4">
                    <room-card :room="room" v-for="room in rooms" :key="room.id" />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '../../Components/Card';
import RoomCard from '../../Components/RoomCard';

export default {
    components: {
        RoomCard,
        Card,
        AppLayout,
    },
    props: {
        rooms: Array,
    },
};
</script>
