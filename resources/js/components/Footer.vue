<script setup>
import { ref, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import axios from 'axios'
import Swal from 'sweetalert2'

// Configure axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true

// Get CSRF token from meta tag
const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

const email = ref('')
const loading = ref(false)

const page = usePage()
const isActive = (path) => page.url === path

// Language detection
const selectedLang = ref('en')

const detectLanguageFromUrl = () => {
    const path = window.location.pathname
    if (path.startsWith('/es')) {
        selectedLang.value = 'es'
    } else {
        selectedLang.value = 'en'
    }
}

const checkLanguageChange = () => {
    const storedLang = localStorage.getItem('language')
    if (storedLang && storedLang !== selectedLang.value) {
        selectedLang.value = storedLang
    }
}

onMounted(() => {
    detectLanguageFromUrl()
    
    // Check for language changes every second
    setInterval(checkLanguageChange, 1000)
})

async function subscribe(event) {
    // form submit prevented by @submit.prevent
    if (!email.value) {
        await Swal.fire({ icon: 'warning', title: 'Please enter your email.' })
        return
    }

    loading.value = true
    try {
        const res = await axios.post('/api/newsletter/subscribe', { email: email.value }, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })

        await Swal.fire({ icon: 'success', title: res.data.message || 'Subscribed successfully' })
        email.value = ''
    } catch (err) {
        if (err.response && err.response.status === 422 && err.response.data.errors) {
            // validation errors
            const firstKey = Object.keys(err.response.data.errors)[0]
            const firstMsg = err.response.data.errors[firstKey][0]
            await Swal.fire({ icon: 'error', title: firstMsg })
        } else if (err.response && err.response.data && err.response.data.message) {
            await Swal.fire({ icon: 'error', title: err.response.data.message })
        } else {
            await Swal.fire({ icon: 'error', title: 'Something went wrong. Please try again.' })
        }
    } finally {
        loading.value = false
    }
}

</script>

<template>
    <footer class="footer-section">
        <div class="container">
            <div class="inner-footer">
                <div class="row">
                    <!-- <div class="col-xxl-3 col-xl-3 col-lg-2 col-sm-12 col-12">
                        <div class="footer-box">
                            <div class="footer-logo">
                                <img src="/images/logo.webp" alt="" class="img-fluid">
                            </div>
                            <div class="common-para">
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Animi, suscipit non. Porro,
                                    quae! Sint, cupiditate. Doloremque hic corrupti vitae optio.</p>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-sm-6 col-12">
                        <div class="footer-box">
                            <p class="foot-title">{{ selectedLang === 'es' ? 'Enlaces Rápidos' : 'Quick Link' }}</p>
                            <ul class="foot-list">
                                <!-- English links -->
                                <template v-if="selectedLang === 'en'">
                                    <li>
                                        <Link href="/blog/">Blog</Link>
                                    </li>
                                    <li>
                                        <Link href="/author/">Author</Link>
                                    </li>
                                    <li>
                                        <Link href="/about-us/">About Us</Link>
                                    </li>
                                    <li>
                                        <Link href="/es/articulos/">Artículos</Link>
                                    </li>
                                    <li>
                                        <Link href="/contact-us/">Contact Us</Link>
                                    </li>
                                    <li>
                                    <Link href="/sitemap/">{{ selectedLang === 'es' ? 'Mapa del Sitio' : 'Sitemap' }}</Link>
                                </li>
                                </template>
                                
                                <!-- Spanish links -->
                                <template v-if="selectedLang === 'es'">
                                    <li>
                                        <Link href="/es/articulos/">Artículos</Link>
                                    </li>
                                    <li>
                                        <Link href="/es/sobre-nosotros/">Sobre Nosotros</Link>
                                    </li>
                                    <li>
                                        <Link href="/es/autor/">Autor</Link>
                                    </li>
                                    <li>
                                        <Link href="/es/contactanos/">Contáctanos</Link>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-2 col-sm-6 col-12">
                        <div class="footer-box">
                            <p class="foot-title">{{ selectedLang === 'es' ? 'Legal' : 'Legal' }}</p>
                            <ul class="foot-list">
                                <li>
                                    <Link :href="selectedLang === 'es' ? '/es/descargo-de-responsabilidad/' : '/disclaimer/'">
                                        {{ selectedLang === 'es' ? 'Descargo de Responsabilidad' : 'Disclaimer' }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="selectedLang === 'es' ? '/es/politica-de-privacidad/' : '/privacy-policy/'">
                                        {{ selectedLang === 'es' ? 'Política de Privacidad' : 'Privacy Policy' }}
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="selectedLang === 'es' ? '/es/terminos-y-condiciones/' : '/terms-and-conditions/'">
                                        {{ selectedLang === 'es' ? 'Términos y Condiciones' : 'Terms & Conditions' }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-sm-6 col-12">
                        <div class="footer-box">
                            <p class="foot-title">{{ selectedLang === 'es' ? 'contacto' : 'contact' }}</p>
                            <ul class="contact-list">
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                    </div>
                                    <a href="tel:+1-877-238-0219">+1-877-238-0219</a>
                                </li>
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-envelope-at"></i>
                                        </span>
                                    </div>
                                    <a href="mailto:contact@flyofair.com">contact@flyofair.com</a>
                                </li>
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                    </div>
                                    <a href="javascript:void(0)">17875 Von Karman Ave, Suite 150 & 250, Irvine, California, 92614, United States of America</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-5 col-sm-6 col-12">
                        <div class="footer-box">
                            <p class="foot-title">{{ selectedLang === 'es' ? 'Suscríbete a Nuestro Boletín' : 'Subscribe to Our Newsletter' }}</p>
                            <small class="smalltextsec">{{ selectedLang === 'es' ? 'Solo regístrate y te enviaremos una notificación por correo electrónico.' : 'Just sign up and we\'ll send you a notification by email.' }}</small>
                            <form @submit.prevent="subscribe" class="NewsLettert-form">
                                <div class="input-group">
                                    <input v-model="email" type="email" class="form-control" placeholder="Your email here" required>
                                    <button :disabled="loading" type="submit" class="btn common-bgBtn">
                                        <span v-if="!loading">get started</span>
                                        <span v-else>please wait...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="memberbox">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-6 col-12">
                        <ul class="memberlist">
                            <li>
                                <a href="javascript:void(0)">
                                    <img src="/images/iataabta1.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <img src="/images/american_society.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <img src="/images/Cruise-Lines-International.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <img src="/images/pci-compliance.png" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <img src="/images/cloudflare-logo.webp" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6 col12">
                        <ul class="paymentacceplist">
                            <li>
                                <img src="/images/Discover.png" alt="">
                            </li>
                            <li>
                                <img src="/images/VISA.png" alt="">
                            </li>
                            <li>
                                <img src="/images/mastercard.png" alt="">
                            </li>
                            <li>
                                <img src="/images/american.png" alt="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="newcopypara">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-12 col-12">
                        <div class="textparafooter">
                            <p v-if="selectedLang === 'en'">
                                FlyOFair is a third-party Online Travel Agency, or OTA, that does not represent itself as an authorised partner of any airline. We offer information on airlines' services and facilities. Also, all the information on this website is based on research and current market updates. But we assure you that we offer 100% legitimate services with completely transparent procedures—without any hidden charges. By using our services and facilities, you agree to our terms and conditions and privacy policy. 
                            </p>
                            <p v-else>
                                FlyOFair es una Agencia de Viajes en Línea (OTA) de terceros que no se presenta como socio autorizado de ninguna aerolínea. Ofrecemos información sobre los servicios y comodidades de las aerolíneas. Además, toda la información en este sitio web se basa en investigación y actualizaciones actuales del mercado. Pero te aseguramos que ofrecemos servicios 100% legítimos con procedimientos completamente transparentes, sin cargos ocultos. Al usar nuestros servicios y comodidades, aceptas nuestros términos y condiciones y política de privacidad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6 col-sm-12 col-12">
                        <div class="copy-box">
                            © Copyright 2025 FlyOFair | All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== All modal & Offcanvas (Mobile)  ===== -->
    <div class="offcanvas offcanvas-start mobmenucanvas" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <Link href="/" class="navbar-brand travel-logo d-flex align-items-center">
                <img src="/images/logo.webp" alt="logo" class="me-2 d-block">
            </Link>
            <button type="button" class="btn-closebt" data-bs-dismiss="offcanvas">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 travel-header">
                <!-- English links -->
                <template v-if="selectedLang === 'en'">
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/') }" href="/">Home</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/about-us/') }" href="/about-us/">About Us</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/sitemap/') }" href="/sitemap/">Sitemap</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/author/') }" href="/author/">Author</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/blog/') }" href="/blog/">Blog</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/contact-us/') }" href="/contact-us/">Contact Us</Link></li>
                </template>
                
                <!-- Spanish links -->
                <template v-if="selectedLang === 'es'">
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/') || isActive('/es/') }" href="/es/">Inicio</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/sobre-nosotros/') }" href="/es/sobre-nosotros/">Sobre Nosotros</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/sitemap/') }" href="/sitemap/">Mapa del Sitio</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/autor/') }" href="/es/autor/">Autor</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/articulos/') }" href="/es/articulos/">Artículos</Link></li>
                    <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/es/contactanos/') }" href="/es/contactanos/">Contáctanos</Link></li>
                </template>
            </ul>
            <!-- Call info -->
            <a href="tel:+1-877-238-0219" class="travel-call d-flex align-items-center me-4">
                <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                <div class="small">Call Us<br><strong>+1-877-238-0219 </strong></div>
            </a>
        </div>
    </div>

    <!-- =====  Travel Expert Modal ===== -->
    <div class="modal fade" id="travelExpertModal" tabindex="-1" aria-labelledby="travelExpertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog travel-modal-dialog modal-dialog-centered">
            <div class="modal-content travel-modal-content">
                <div class="travel-modal-header">
                    <button type="button" class="travel-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <p class="travel-modal-title" id="travelExpertModalLabel">
                        Talk To Our Travel Expert Now (24X7)
                    </p>
                    <p class="travel-modal-subtitle">Why Call To Our Travel Expert</p>
                </div>
                <div class="modal-body travel-modal-body">
                    <div class="travel-expert-image">
                        <img src="/images/pngcall.jpg" alt="Travel Expert">
                    </div>

                    <ul class="travel-features-list">
                        <li class="travel-feature-item">
                            <i class="bi bi-capslock travel-feature-icon"></i>
                            <span>Expert Guidance By Our Travel Experts</span>
                        </li>
                        <li class="travel-feature-item">
                            <i class="bi bi-capslock travel-feature-icon"></i>
                            <span>24-Hour Cancellation</span>
                        </li>
                        <li class="travel-feature-item">
                            <i class="bi bi-capslock travel-feature-icon"></i>
                            <span>Immediate Booking Confirmation</span>
                        </li>
                        <li class="travel-feature-item">
                            <i class="bi bi-capslock travel-feature-icon"></i>
                            <span>Flexible Payment Plans</span>
                        </li>
                    </ul>

                    <a href="tel:+1-877-238-0219" class="travel-call-btn">
                        <i class="fas fa-phone"></i>
                        +1-877-238-0219 
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- =====  Travel Expert Modal ===== -->
</template>

<script>
export default {
    name: 'Footer'
}
</script>

<style scoped>
</style>