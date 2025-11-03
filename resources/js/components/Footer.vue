<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import axios from 'axios'
import Swal from 'sweetalert2'

const email = ref('')
const loading = ref(false)

const page = usePage()
const isActive = (path) => page.url === path

async function subscribe(event) {
    // form submit prevented by @submit.prevent
    if (!email.value) {
        await Swal.fire({ icon: 'warning', title: 'Please enter your email.' })
        return
    }

    loading.value = true
    try {
        const tokenMeta = document.head.querySelector('meta[name="csrf-token"]')
        const headers = {}
        if (tokenMeta) headers['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content')

        const res = await axios.post('/newsletter/subscribe', { email: email.value }, { headers })

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
                            <h5 class="foot-title">Quick Link</h5>
                            <ul class="foot-list">
                                <li>
                                    <Link href="/about" aria-current="page">About Us</Link>
                                </li>
                                <li>
                                    <Link href="/contact">Contact Us</Link>
                                </li>
                                <li>
                                    <Link href="/author">Author</Link>
                                </li>
                                <li>
                                    <Link href="/" aria-current="page">Home</Link>
                                </li>
                                <li>
                                    <Link href="/blog/">Blog</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-2 col-sm-6 col-12">
                        <div class="footer-box">
                            <h5 class="foot-title">Legal</h5>
                            <ul class="foot-list">
                                <li>
                                    <Link href="/terms-and-conditions">
                                        Terms & Conditions</Link>
                                </li>
                                <li>
                                    <Link href="/privacy-policy">Privacy Policy</Link>
                                </li>
                                <li>
                                    <Link href="/disclaimer">Disclaimer</Link>
                                </li>
                                <li>
                                    <Link href="/sitemap">Sitemap</Link>
                                </li>
                                <li>
                                    <Link href="/articulos">articulos</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-sm-6 col-12">
                        <div class="footer-box">
                            <h5 class="foot-title">contact</h5>
                            <ul class="contact-list">
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                    </div>
                                    <a target="_blank" href="javascript:void(0)">+(844) 933-1926</a>
                                </li>
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-envelope-at"></i>
                                        </span>
                                    </div>
                                    <a href="javascript:void(0)">connect@infinitytravelmate.com</a>
                                </li>
                                <li>
                                    <div class="">
                                        <span>
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                    </div>
                                    <a>1876 Harvest Cir Tustin, CA 92780, USA</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-5 col-sm-6 col-12">
                        <div class="footer-box">
                            <h5 class="foot-title">Subscribe to Our Newsletter</h5>
                            <small class="smalltextsec">Just sign up and we'll send you a notification by email.</small>
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
                            <p>
                                infinitytravelmate.com (Infinity Travels), operated by Infinity Web Solutions LLC
                                (EIN:
                                82-160816), is a
                                premier travel brand. We are an IATA certified company (Number: 05-7 1127 4)
                                headquarter
                                at 1876 Harvest
                                Cir, Tustin, CA 92780-4589. We ensure that our flight services meet the highest
                                standards as per IATA
                                guidelines. Our additional services like hotels and cruises are sourced from the
                                leading
                                suppliers in
                                the industry, i.e. Mondee, TravelBoutiqueOnline. Trawex, Downtown, Hotelbeds,
                                Skybird
                                etc.
                            </p>
                            <p>
                                By using our services, you agree to our <a href="">infinitytravelmate.com</a>
                                (Infinity
                                Travels)'s <a href="">Terms & Conditions</a> and <a href="">Privacy Policy</a>
                            </p>
                            <p>
                                Please note that all transactions are subject to <a href=""> our Service Fees</a>
                                and <a href="">Post Ticketing
                                    Fees</a> For more details, make sure to check insights from our<a href="">
                                    Cookie
                                    Policy</a>
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
                        <div class="copy-box">© Copyright 2025 Infinity Web Solutions LLC | DBA -
                            InfinityTravels.
                            All
                            Rights Reserved.</div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                        <div class="travel-top-social footsociallist">
                            <a href="javascript:void(0)" target="_blank"><i
                                    class="fa-brands fa-square-facebook"></i></a>
                            <a href="javascript:void(0)" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a href="javascript:void(0)" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                            <a href="javascript:void(0)" target="_blank"><i class="bi bi-twitter-x"></i></a>
                            <a href="javascript:void(0)" target="_blank"><i class="bi bi-pinterest"></i></a>
                            <a href="javascript:void(0)" target="_blank"><i
                                    class="fa-brands fa-square-linkedin"></i></a>
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
            <a href="index.html" class="navbar-brand travel-logo d-flex align-items-center">
                                    <img src="/images/logo.webp" alt="logo" class="me-2 d-block">
            </a>
            <button type="button" class="btn-closebt" data-bs-dismiss="offcanvas">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 travel-header">
                <!-- Normal links -->
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/') }" href="/">Home</Link></li>
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/about') }" href="/about">About Us</Link></li>
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/sitemap') }" href="/sitemap">Sitemap</Link></li>
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/author') }" href="/author">Author</Link></li>
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/blog') }" href="/blog">Blog</Link></li>
                <li class="nav-item"><Link class="nav-link" :class="{ active: isActive('/contact') }" href="/contact">Contact Us</Link></li>
            </ul>
            <!-- Call info -->
            <a href="tel:88 (09) 53 33 09" class="travel-call d-flex align-items-center me-4">
                <span class="travel-call-icon me-2"><i class="bi bi-telephone"></i></span>
                <div class="small">Call Us<br><strong>+88 (09) 53 33 09</strong></div>
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
                    <h5 class="travel-modal-title" id="travelExpertModalLabel">
                        Talk To Our Travel Expert Now (24X7)
                    </h5>
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

                    <a href="tel:+18447331212" class="travel-call-btn">
                        <i class="fas fa-phone"></i>
                        +1 (844) 733-1212
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