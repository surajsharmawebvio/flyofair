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
            window.$('.navbar').removeClass('header-fixed')
        } else {
            window.$('.navbar').addClass('header-fixed')
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
        window.$('.offcanvas-backdrop').remove();
        // Hide offcanvas
        window.$('#offcanvasExample').removeClass('show');
        // Enable scrolling
        window.$('body').removeClass('modal-open').css('overflow', '').css('padding-right', '');
    }

    onMounted(() => {
        toggleNavbarClass()
        detectLanguageFromUrl()

        // Initialize jQuery event handlers
        window.$('.travel-call').on('mouseenter', function () {
            window.$(this).find('.small').css('color', '#ffffff')
        }).on('mouseleave', function () {
            window.$(this).find('.small').css('color', '#000000')
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
                    <a href="tel:+1-877-238-0219" class="travel-call d-flex align-items-center me-0 newtravel-call">
                        <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                        <div class="small"><strong>+1-877-238-0219</strong></div>
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
                            <!-- <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/sobre-nosotros') ? 'active' : '']" href="/es/sobre-nosotros">Sobre Nosotros</Link>
                            </li> -->
                            <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/articulos') ? 'active' : '']" href="/es/articulos">Artículos</Link>
                            </li>
                            <!-- <li class="nav-item">
                                <Link :class="['nav-link', isActive('/es/contactanos') ? 'active' : '']" href="/es/contactanos">Contáctanos</Link>
                            </li> -->
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
                    <a href="tel:+1-877-238-0219" class="travel-call d-flex align-items-center me-0">
                        <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                        <div class="small"><strong>+1-877-238-0219 </strong></div>
                    </a>
                </div>
            </div>
        </nav>

    </header>
    <!-- Bottom Navigation -->
</template>

<script>
    import './../../css/common.css';

</script>

<style scoped>
    .travel-call {
        text-decoration: none;
    }
    .small {
        font-size: 14px !important;
        color: white !important;
    }

</style>
