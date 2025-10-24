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
    <!-- </div> -->
</template>

<script>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import SocialBar from '@/components/SocialBar.vue'
import $ from 'jquery';
import './../../js/main';

export default {
    name: 'DefaultLayout',
    components: {
        Header,
        Footer,
        SocialBar,
    }
}
</script>

<style scoped>

</style>