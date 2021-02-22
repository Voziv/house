<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-end mt-4">
                    <a class="btn btn-primary" :href="route('rooms.create')">+</a>
                </div>
            </div>
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-flow-col grid-cols-3 grid-rows-4 gap-4">
                    <a :href="route('rooms.show', room.slug)" v-for="room in rooms" :key="room.id">
                        <room-card :room="room"/>
                    </a>
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
        AppLayout,
        Card,
        RoomCard,
    },
    props: {
        rooms: Array,
    },
};
</script>
