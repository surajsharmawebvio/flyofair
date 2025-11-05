<template>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="images/banner/about-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading" data-text="ABOUT US">Sitemap</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="common-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-links-wrapper">
                            <!-- Quick Link Section -->
                            <div class="footer-section-block">
                                <h3 class="footer-section-heading">Quick Link</h3>
                                <div class="footer-links-grid">
                                    <div class="footer-link-column">
                                        <Link href="/" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Home</span>
                                        </Link>
                                        <Link href="/blog" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Blog</span>
                                        </Link>
                                        <Link href="/about" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">About Us</span>
                                        </Link>
                                    </div>
                                    <div class="footer-link-column">
                                        <Link href="/contact" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Contact Us</span>
                                        </Link>
                                        <Link href="/services" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Services</span>
                                        </Link>
                                        <Link href="/articulos" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Articulos</span>
                                        </Link>
                                    </div>
                                    <div class="footer-link-column">
                                        <Link href="/terms" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Terms and Conditions</span>
                                        </Link>
                                        <Link href="/privacy-policy" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Privacy Policy</span>
                                        </Link>
                                        <Link href="/disclaimer" class="footer-link-item">
                                            <i class="bi bi-record-circle footer-link-arrow"></i>
                                            <span class="footer-link-text">Disclaimer</span>
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Blog Section -->
                            <div class="footer-section-block" v-if="blogs.length">
                                <h3 class="footer-section-heading">Our Blog</h3>
                                <div class="footer-links-grid">
                                    <template v-for="(blogGroup, index) in blogGroups" :key="index">
                                        <div class="footer-link-column">
                                            <Link 
                                                v-for="blog in blogGroup" 
                                                :key="blog.slug"
                                                :href="`/blog/${blog.slug}`"
                                                class="footer-link-item"
                                            >
                                                <i class="bi bi-record-circle footer-link-arrow"></i>
                                                <span class="footer-link-text">{{ blog.title }}</span>
                                            </Link>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Articulos Section -->
                            <div class="footer-section-block" v-if="articulos.length">
                                <h3 class="footer-section-heading">Artículos</h3>
                                <div class="footer-links-grid">
                                    <template v-for="(articuloGroup, index) in articuloGroups" :key="index">
                                        <div class="footer-link-column">
                                            <Link 
                                                v-for="articulo in articuloGroup" 
                                                :key="articulo.slug"
                                                :href="`/articulos/${articulo.slug}`"
                                                class="footer-link-item"
                                            >
                                                <i class="bi bi-record-circle footer-link-arrow"></i>
                                                <span class="footer-link-text">{{ articulo.title }}</span>
                                            </Link>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import './../../css/sitemap.css';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    blogs: {
        type: Array,
        required: true
    },
    articulos: {
        type: Array,
        required: true
    }
});

// Function to split items into 3 columns
const splitIntoColumns = (items) => {
    const groupSize = Math.ceil(items.length / 3);
    return [
        items.slice(0, groupSize),
        items.slice(groupSize, groupSize * 2),
        items.slice(groupSize * 2)
    ];
};

// Split blogs into 3 columns
const blogGroups = computed(() => {
    return splitIntoColumns([...props.blogs]);
});

// Split articulos into 3 columns
const articuloGroups = computed(() => {
    return splitIntoColumns([...props.articulos]);
});
</script>

<style scoped>
</style>