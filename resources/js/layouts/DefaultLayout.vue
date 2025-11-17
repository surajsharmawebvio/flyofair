<!-- Default Layout -->
<template>
    <!-- <div class="page-wrapper"> -->
        <!-- Header -->
        <Header />
        <!-- Main Content -->
        <main class="main-content">
            <slot />
        </main>
        <!-- Footer -->
        <SocialBar />
        <Footer/>
        <!-- Pop-up Component -->
        <PopUp 
            v-model="showPopup" 
            @request-call="handleRequestCall"
        />
    <!-- </div> -->
</template>

<script>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import SocialBar from '@/components/SocialBar.vue'
import PopUp from '@/components/pop-up.vue'
import $ from 'jquery';
import './../../js/main';
import { ref, onMounted } from 'vue';

export default {
    name: 'DefaultLayout',
    components: {
        Header,
        Footer,
        SocialBar,
        PopUp,
    },
    setup() {
        const showPopup = ref(false);

        onMounted(() => {
            // Show popup after a short delay on page load
            setTimeout(() => {
                showPopup.value = true;
            }, 2000); // 2 second delay
        });

        const handleRequestCall = () => {
            showPopup.value = false;
            // Add your call request logic here
        };

        return {
            showPopup,
            handleRequestCall
        };
    }
}
</script>

<style scoped>

</style>