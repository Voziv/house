<template>
    <card>
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">{{ room.name }}</h4>
        <div v-if="room.latest_reading" class="flex justify-evenly">
            <div class="p-4 text-center">
                {{ room.latest_reading.temperature }} °C
            </div>
            <div class="p-4 text-center">
                {{ room.latest_reading.humidity }}%
            </div>
        </div>
        <div v-else>
            N/A
        </div>
    </card>

</template>

<script>
    import Card from './Card';
    export default {
        components: {Card},
        props: {
            room: {
                type: Object,
            },
        }
    }
</script>
