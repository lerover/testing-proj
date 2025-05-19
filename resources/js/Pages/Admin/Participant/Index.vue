<template>
    <div>
        <div class="flex justify-end my-10 p-5">
            <Link :href="route('participants.create')" class="btn btn-primary">Create Participant</Link>
        </div>
        <div class="grid grid-cols-3 gap-5 my-10 p-5">
            <div v-for="participant in participants" :key="participant.id" class="flex flex-col items-center gap-5 border-gray-300 border-2 rounded-lg p-5">
                <img :src="`/storage/participants/${participant.image}`" class="w-48 h-48 object-cover" alt="">
                <p class="font-bold">{{ participant.name }}</p>

                <form @submit.prevent="deleteParticipant(participant.id)" class="flex gap-5">
                    <Link :href="route('participants.edit', participant.id)" class="btn btn-sm btn-primary">Edit</Link>
                    <button class="btn btn-sm btn-error">Delete</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    id: null,
})

const props = defineProps({
    participants: Array,
})

const deleteParticipant = (id) => {
    form.delete(route('participants.destroy', id));
}
</script>
<style lang="css">


</style>
