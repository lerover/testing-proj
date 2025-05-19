<template>
    <div>
        <div class="my-10 p-5">
            <div class="space-y-5">
                <form @submit.prevent="formAction" class="space-y-5">
                    <div>
                        <input @input="form.image = $event.target.files[0]" @change="handleImageUpload" type="file" class="file-input file-input-bordered w-full max-w-xs">
                    </div>

                    <div v-if="imageURL">
                        <img :src="imageURL" alt="" class="w-24 h-24">
                    </div>

                    <div v-if="participant && !imageURL">
                        <img :src="`/storage/participants/${participant.image}`" class="w-24 h-24" alt="">
                    </div>

                    <div>
                        <input type="text" v-model="form.name" class="input input-bordered w-full max-w-xs">
                    </div>

                    <div class="space-x-5">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <Link :href="route('participants.index')" class="btn btn-neutral">Cancel</Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    participant: Object,
})
const form = useForm({
    image: null,
    name: '',
});

if(props.participant){
    form.image = props.participant.image;
    form.name = props.participant.name;
}




const formAction = () =>{
    if(props.participant){
        form._method = 'put';
        router.post(route('participants.update', props.participant.id), form, {
            onSuccess: () => {
                form.reset();
                alert('Participant updated successfully');
            }
        });
    }else{
        form.post(route('participants.store'),{
            onSuccess: () => {
                form.reset();
                alert('Participant created successfully');
            }
        });
    }
}

const imageURL = ref(null);

const handleImageUpload = (event) => {
    const selectedFile = event.target.files[0];
    if(selectedFile){
        const reader = new FileReader();
        reader.onload = (e) =>{
            imageURL.value = e.target.result;
        }
        reader.readAsDataURL(selectedFile);
    }
}

</script>
<style lang="css"></style>
