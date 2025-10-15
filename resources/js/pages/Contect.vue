<!-- create contact component -->
<template>
    <div class="container mt-5">
        <h1>Contact Us</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="form.name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="form.email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" v-model="form.message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
    name: '',
    email: '',
    message: ''
});

const submitForm = () => {
    // Handle form submission
    console.log('Form submitted:', form.value);
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
}
</style>