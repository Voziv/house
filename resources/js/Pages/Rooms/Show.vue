<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="flex items-center justify-end mt-4">
                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Delete
                        </jet-button>
                    </div>
                </form>
                <room-card :room="room"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '../../Components/Card';
import RoomCard from '../../Components/RoomCard';
import JetButton from '@/Jetstream/Button';

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
    },
};
</script>
