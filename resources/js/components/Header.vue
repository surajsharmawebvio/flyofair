<script setup>
    import {
        Link,
        usePage
    } from '@inertiajs/vue3'
    import {
        onMounted,
        watch,
        ref
    } from 'vue'
    import $ from 'jquery'
    import { router } from '@inertiajs/vue3';

    const page = usePage()
    const isActive = (path) => page.url === path
    const currentPath = ref('')
    const selectedLang = ref('en')

    const handleLanguageChange = (event) => {
        const newLang = event.target.value
        selectedLang.value = newLang
        
        localStorage.setItem('language', newLang);
        router.visit('/');
    }

    const toggleNavbarClass = () => {
        if (window.location.pathname === '/') {
            $('.navbar').removeClass('header-fixed')
        } else {
            $('.navbar').addClass('header-fixed')
        }
        currentPath.value = window.location.pathname
    }

    const closeOffcanvas = () => {
        // Remove backdrop
        $('.offcanvas-backdrop').remove();
        // Hide offcanvas
        $('#offcanvasExample').removeClass('show');
        // Enable scrolling
        $('body').removeClass('modal-open').css('overflow', '').css('padding-right', '');
    }

    onMounted(() => {
        toggleNavbarClass()

        // Initialize jQuery event handlers
        $('.travel-call').on('mouseenter', function () {
            $(this).find('.small').css('color', '#ffffff')
        }).on('mouseleave', function () {
            $(this).find('.small').css('color', '#000000')
        })

        // Close offcanvas when any Link component is clicked
        document.addEventListener('inertia:navigate', closeOffcanvas);

        selectedLang.value = localStorage.getItem('language') || 'en';
    })

    // Watch for route changes to toggle navbar class
    watch(() => currentPath.value, () => {
        toggleNavbarClass()
    })

</script>

<template>
    <header>
        <!-- ===== Main Navbar ===== -->
        <nav class="navbar navbar-expand-lg travel-header">
            <div class="container">
                <!-- Logo -->
                <div class="navbar-brand travel-logo d-flex align-items-center">
                    <button class="mobbtn d-lg-none navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <span class="navbar-toggler-icon bar-1"></span>
                        <span class="navbar-toggler-icon bar-2"></span>
                        <span class="navbar-toggler-icon bar-3"></span>
                    </button>
                    <div class="navbar-brand travel-logo d-flex align-items-center">
                    <img src="/images/logo.webp" alt="logo" class="me-2 normallogo">
                    <img src="/images/logo.webp" alt="logo" class="me-2 stickylogo">
                    </div>
                </div>
                <!-- Reservation button (desktop) -->
                <div class="d-lg-none ms-auto me-2 mobbtsec">
                    <div class="langselectmob">
                        <select class="form-select" aria-label="Language selector" v-model="selectedLang"
                            @change="handleLanguageChange">
                            <option value="en">En</option>
                            <option value="es">Es</option>
                        </select>
                    </div>
                    <!-- Reservation button -->
                    <a href="tel:88 (09) 53 33 09" class="travel-call d-flex align-items-center me-0 newtravel-call">
                        <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                        <div class="small"><strong>+88 (09) 53 33 09</strong></div>
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="collapse navbar-collapse" id="travelNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <!-- Normal links -->
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ active: isActive('/') }" href="/">
                            Home
                            </Link>
                        </li>
                        <li class="nav-item" v-if="selectedLang === 'en'">
                            <Link :class="['nav-link', isActive('/about') ? 'active' : '']" href="/about">About Us</Link>
                        </li>
                        <li class="nav-item" v-if="selectedLang === 'en'">
                            <Link :class="['nav-link', isActive('/blog/') ? 'active' : '']" href="/blog/">Blog</Link>
                        </li>
                        <li class="nav-item" v-if="selectedLang === 'es'">
                            <Link :class="['nav-link', isActive('/articulos') ? 'active' : '']" href="/articulos">Articulos</Link>
                        </li>
                        <li class="nav-item" v-if="selectedLang === 'en'">
                            <Link :class="['nav-link', isActive('/contact') ? 'active' : '']" href="/contact">Contact Us
                            </Link>
                        </li>
                    </ul>

                    <!-- Call info -->
                    <div class="m-3">
                        <select class="form-select" aria-label="Language selector" v-model="selectedLang"
                            @change="handleLanguageChange">
                            <option value="en">En</option>
                            <option value="es">Es</option>
                        </select>
                    </div>
                    <a href="tel:88 (09) 53 33 09" class="travel-call d-flex align-items-center me-0">
                        <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                        <div class="small"><strong>+88 (09) 53 33 09</strong></div>
                    </a>
                </div>
            </div>
        </nav>

    </header>
    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <Link href="/" class="mobnav-item active" data-page="Home" :class="{ active: isActive('/') }">
            <span>Home</span>
        </Link>
        <Link href="/about" class="mobnav-item" data-page="My Trips" :class="['nav-link', isActive('/about') ? 'active' : '']">
            <span>About</span>
        </Link>
        <Link href="/blog/" class="mobnav-item" data-page="My Trips" :class="['nav-link', isActive('/blog/') ? 'active' : '']">
            <span>Blog</span>
        </Link>
        <Link href="/articulos" class="mobnav-item" data-page="Where2Go" :class="['nav-link', isActive('/articulos') ? 'active' : '']">
            <span>Articulos</span>
        </Link>
        <Link href="/contact" class="mobnav-item" data-page="Wallet" :class="['nav-link', isActive('/contact') ? 'active' : '']">
            <span>Contact</span>
        </Link>
    </nav>
</template>

<script>
    import './../../css/common.css';

</script>

<style scoped>
    .travel-call {
        text-decoration: none;
    }

</style>
