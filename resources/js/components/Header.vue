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
    const isActive = (path) => {
        const currentUrl = page.url
        // Handle exact matches and trailing slash variations
        return currentUrl === path || currentUrl === path + '/' || currentUrl + '/' === path
    }
    const currentPath = ref('')
    const selectedLang = ref('en')

    const handleLanguageChange = (event) => {
        const newLang = event.target.value
        selectedLang.value = newLang
        
        localStorage.setItem('language', newLang);
        // Always redirect to root for English, /es for Spanish
        if (newLang === 'en') {
            router.visit('/');
        } else {
            router.visit('/es');
        }
    }

    const toggleNavbarClass = () => {
        if (window.location.pathname === '/' || window.location.pathname === '/es' || window.location.pathname === '/es/') {
            $('.navbar').removeClass('header-fixed')
        } else {
            $('.navbar').addClass('header-fixed')
        }
        currentPath.value = window.location.pathname
    }

    const detectLanguageFromUrl = () => {
        const path = window.location.pathname
        if (path.startsWith('/es')) {
            selectedLang.value = 'es'
            localStorage.setItem('language', 'es')
        } else {
            selectedLang.value = 'en'
            localStorage.setItem('language', 'en')
        }
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
        detectLanguageFromUrl()

        // Initialize jQuery event handlers
        $('.travel-call').on('mouseenter', function () {
            $(this).find('.small').css('color', '#ffffff')
        }).on('mouseleave', function () {
            $(this).find('.small').css('color', '#000000')
        })

        // Close offcanvas when any Link component is clicked
        document.addEventListener('inertia:navigate', closeOffcanvas);

        // Detect language changes on navigation
        document.addEventListener('inertia:navigate', detectLanguageFromUrl);
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
                    <Link :href="selectedLang === 'es' ? '/es' : '/'" class="navbar-brand travel-logo d-flex align-items-center">
                    <img src="/images/logo.webp" alt="logo" class="me-2 normallogo">
                    <img src="/images/logo.webp" alt="logo" class="me-2 stickylogo">
                    </Link>
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
                        <!-- English links -->
                        <template v-if="selectedLang === 'en'">
                            <li class="nav-item">
                                <Link class="nav-link" :class="{ active: isActive('/') }" href="/">
                                Home
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/about-us/') ? 'active' : '']" href="/about-us/">About Us</Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/blog/') ? 'active' : '']" href="/blog/">Blog</Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/contact-us/') ? 'active' : '']" href="/contact-us/">Contact Us</Link>
                            </li>
                        </template>
                        
                        <!-- Spanish links -->
                        <template v-if="selectedLang === 'es'">
                            <li class="nav-item">
                                <Link class="nav-link" :class="{ active: isActive('/es') || isActive('/es/') }" href="/es">
                                Inicio
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/sobre-nosotros') ? 'active' : '']" href="/es/sobre-nosotros">Sobre Nosotros</Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/articulos') ? 'active' : '']" href="/es/articulos">Artículos</Link>
                            </li>
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/contactanos') ? 'active' : '']" href="/es/contactanos">Contáctanos</Link>
                            </li>
                        </template>
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
        <!-- English navigation -->
        <template v-if="selectedLang === 'en'">
            <Link href="/" class="mobnav-item" data-page="Home" :class="{ active: isActive('/') }">
                <span>Home</span>
            </Link>
            <Link href="/about-us/" class="mobnav-item" data-page="About" :class="['nav-link', isActive('/about-us/') ? 'active' : '']">
                <span>About</span>
            </Link>
            <Link href="/blog/" class="mobnav-item" data-page="Blog" :class="['nav-link', isActive('/blog/') ? 'active' : '']">
                <span>Blog</span>
            </Link>
            <Link href="/contact-us/" class="mobnav-item" data-page="Contact" :class="['nav-link', isActive('/contact-us/') ? 'active' : '']">
                <span>Contact</span>
            </Link>
        </template>
        
        <!-- Spanish navigation -->
        <template v-if="selectedLang === 'es'">
            <Link href="/es" class="mobnav-item" data-page="Inicio" :class="{ active: isActive('/es') || isActive('/es/') }">
                <span>Inicio</span>
            </Link>
            <Link href="/es/sobre-nosotros" class="mobnav-item" data-page="Sobre" :class="['nav-link', isActive('/es/sobre-nosotros') ? 'active' : '']">
                <span>Sobre</span>
            </Link>
            <Link href="/es/articulos" class="mobnav-item" data-page="Articulos" :class="['nav-link', isActive('/es/articulos') ? 'active' : '']">
                <span>Artículos</span>
            </Link>
            <Link href="/es/contactanos" class="mobnav-item" data-page="Contacto" :class="['nav-link', isActive('/es/contactanos') ? 'active' : '']">
                <span>Contacto</span>
            </Link>
        </template>
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
