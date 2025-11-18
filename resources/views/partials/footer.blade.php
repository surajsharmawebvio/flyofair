<footer class="footer-section">
    <div class="container">
        <div class="inner-footer">
            <div class="row">
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-sm-6 col-12">
                    <div class="footer-box">
                        <p class="foot-title">{{ request()->is('es*') ? 'Enlaces Rápidos' : 'Quick Link' }}</p>
                        <ul class="foot-list">
                            @if(!request()->is('es*'))
                                <!-- English links -->
                                <li><a href="/blog/">Blog</a></li>
                                <li><a href="/author/">Author</a></li>
                                <li><a href="/about-us/">About Us</a></li>
                                <li><a href="/es/articulos/">Artículos</a></li>
                                <li><a href="/contact-us/">Contact Us</a></li>
                                <li><a href="/sitemap/">Sitemap</a></li>
                            @else
                                <!-- Spanish links -->
                                <li><a href="/es/articulos/">Artículos</a></li>
                                <li><a href="/es/sobre-nosotros/">Sobre Nosotros</a></li>
                                <li><a href="/es/autor/">Autor</a></li>
                                <li><a href="/es/contactanos/">Contáctanos</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-2 col-sm-6 col-12">
                    <div class="footer-box">
                        <p class="foot-title">Legal</p>
                        <ul class="foot-list">
                            <li>
                                <a href="{{ request()->is('es*') ? '/es/descargo-de-responsabilidad/' : '/disclaimer/' }}">
                                    {{ request()->is('es*') ? 'Descargo de Responsabilidad' : 'Disclaimer' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ request()->is('es*') ? '/es/politica-de-privacidad/' : '/privacy-policy/' }}">
                                    {{ request()->is('es*') ? 'Política de Privacidad' : 'Privacy Policy' }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ request()->is('es*') ? '/es/terminos-y-condiciones/' : '/terms-and-conditions/' }}">
                                    {{ request()->is('es*') ? 'Términos y Condiciones' : 'Terms & Conditions' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-sm-6 col-12">
                    <div class="footer-box">
                        <p class="foot-title">{{ request()->is('es*') ? 'contacto' : 'contact' }}</p>
                        <ul class="contact-list">
                            <li>
                                <div class="">
                                    <span><i class="bi bi-telephone"></i></span>
                                </div>
                                <a href="tel:+1-877-238-0219">+1-877-238-0219</a>
                            </li>
                            <li>
                                <div class="">
                                    <span><i class="bi bi-envelope-at"></i></span>
                                </div>
                                <a href="mailto:contact@flyofair.com">contact@flyofair.com</a>
                            </li>
                            <li>
                                <div class="">
                                    <span><i class="bi bi-geo-alt"></i></span>
                                </div>
                                <a href="javascript:void(0)">17875 Von Karman Ave, Suite 150 & 250, Irvine, California, 92614, United States of America</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-5 col-sm-6 col-12">
                    <div class="footer-box">
                        <p class="foot-title">{{ request()->is('es*') ? 'Suscríbete a Nuestro Boletín' : 'Subscribe to Our Newsletter' }}</p>
                        <small class="smalltextsec">{{ request()->is('es*') ? 'Solo regístrate y te enviaremos una notificación por correo electrónico.' : 'Just sign up and we\'ll send you a notification by email.' }}</small>
                        <form id="newsletter-form" class="NewsLettert-form">
                            @csrf
                            <div class="input-group">
                                <input type="email" id="newsletter-email" class="form-control" placeholder="Your email here" required>
                                <button type="submit" class="btn common-bgBtn">
                                    <span class="submit-text">get started</span>
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
                        <li><a href="javascript:void(0)"><img src="/images/iataabta1.png" alt=""></a></li>
                        <li><a href="javascript:void(0)"><img src="/images/american_society.png" alt=""></a></li>
                        <li><a href="javascript:void(0)"><img src="/images/Cruise-Lines-International.png" alt=""></a></li>
                        <li><a href="javascript:void(0)"><img src="/images/pci-compliance.png" alt=""></a></li>
                        <li><a href="javascript:void(0)"><img src="/images/cloudflare-logo.webp" alt=""></a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col12">
                    <ul class="paymentacceplist">
                        <li><img src="/images/Discover.png" alt=""></li>
                        <li><img src="/images/VISA.png" alt=""></li>
                        <li><img src="/images/mastercard.png" alt=""></li>
                        <li><img src="/images/american.png" alt=""></li>
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
                        @if(!request()->is('es*'))
                            <p>
                                FlyOFair is a third-party Online Travel Agency, or OTA, that does not represent itself as an authorised partner of any airline. We offer information on airlines' services and facilities. Also, all the information on this website is based on research and current market updates. But we assure you that we offer 100% legitimate services with completely transparent procedures—without any hidden charges. By using our services and facilities, you agree to our terms and conditions and privacy policy. 
                            </p>
                        @else
                            <p>
                                FlyOFair es una Agencia de Viajes en Línea (OTA) de terceros que no se presenta como socio autorizado de ninguna aerolínea. Ofrecemos información sobre los servicios y comodidades de las aerolíneas. Además, toda la información en este sitio web se basa en investigación y actualizaciones actuales del mercado. Pero te aseguramos que ofrecemos servicios 100% legítimos con procedimientos completamente transparentes, sin cargos ocultos. Al usar nuestros servicios y comodidades, aceptas nuestros términos y condiciones y política de privacidad.
                            </p>
                        @endif
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

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-start mobmenucanvas" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <a href="{{ request()->is('es*') ? '/es' : '/' }}" class="navbar-brand travel-logo d-flex align-items-center">
            <img src="/images/logo.webp" alt="logo" class="me-2 d-block">
        </a>
        <button type="button" class="btn-closebt" data-bs-dismiss="offcanvas">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 travel-header">
            @if(!request()->is('es*'))
                <!-- English links -->
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}" href="/about-us/">About Us</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('sitemap*') ? 'active' : '' }}" href="/sitemap/">Sitemap</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('author*') ? 'active' : '' }}" href="/author/">Author</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="/blog/">Blog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('contact-us*') ? 'active' : '' }}" href="/contact-us/">Contact Us</a></li>
            @else
                <!-- Spanish links -->
                <li class="nav-item"><a class="nav-link {{ request()->is('es') || request()->is('es/') ? 'active' : '' }}" href="/es/">Inicio</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('es/sobre-nosotros*') ? 'active' : '' }}" href="/es/sobre-nosotros/">Sobre Nosotros</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('es/sitemap*') ? 'active' : '' }}" href="/sitemap/">Mapa del Sitio</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('es/autor*') ? 'active' : '' }}" href="/es/autor/">Autor</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('es/articulos*') ? 'active' : '' }}" href="/es/articulos/">Artículos</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('es/contactanos*') ? 'active' : '' }}" href="/es/contactanos/">Contáctanos</a></li>
            @endif
        </ul>
    </div>
</div>

<!-- Travel Expert Modal -->
<div class="modal fade" id="travelExpertModal" tabindex="-1" aria-labelledby="travelExpertModalLabel" aria-hidden="true">
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

@push('scripts')
<script>
// Newsletter subscription functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const emailInput = document.getElementById('newsletter-email');
    const submitBtn = form.querySelector('.btn');
    const submitText = submitBtn.querySelector('.submit-text');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!emailInput.value) {
            Swal.fire({ icon: 'warning', title: 'Please enter your email.' });
            return;
        }

        // Disable button
        submitBtn.disabled = true;
        submitText.textContent = 'please wait...';

        try {
            const response = await axios.post('/api/newsletter/subscribe', {
                email: emailInput.value
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            await Swal.fire({ 
                icon: 'success', 
                title: response.data.message || 'Subscribed successfully' 
            });
            
            emailInput.value = '';
        } catch (error) {
            if (error.response && error.response.status === 422 && error.response.data.errors) {
                const firstKey = Object.keys(error.response.data.errors)[0];
                const firstMsg = error.response.data.errors[firstKey][0];
                await Swal.fire({ icon: 'error', title: firstMsg });
            } else if (error.response && error.response.data && error.response.data.message) {
                await Swal.fire({ icon: 'error', title: error.response.data.message });
            } else {
                await Swal.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
            }
        } finally {
            submitBtn.disabled = false;
            submitText.textContent = 'get started';
        }
    });
});
</script>
@endpush
