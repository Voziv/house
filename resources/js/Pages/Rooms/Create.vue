<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new room
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a class="btn btn-primary" :href="route('rooms.index')"><- Back</a>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <card>
                    <h3 class="py-4">New Room</h3>
                    <hr>
                    <jet-validation-errors class="mb-4"/>

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="Name"/>
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                       autofocus/>
                        </div>

                        <div class="mt-4">
                            <jet-label for="slug" value="Slug"/>
                            <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" required/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                Create
                            </jet-button>
                        </div>
                    </form>
                </card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import JetButton from '@/Jetstream/Button';
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import JetValidationErrors from '@/Jetstream/ValidationErrors';

export default {
    components: {
        AppLayout,
        Card,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
    },
    props: {
        room: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                slug: '',
            }),
        };
    },
    methods: {
        submit() {
            this.form.transform(data => ({
                ...data,
            })).post(this.route('rooms.store'));
        },
    },
};
</script>
