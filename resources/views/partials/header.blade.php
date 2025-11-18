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
                <a href="{{ request()->is('es*') ? '/es' : '/' }}" class="navbar-brand travel-logo d-flex align-items-center">
                    <img src="/images/logo.webp" alt="logo" class="me-2 normallogo">
                    <img src="/images/logo.webp" alt="logo" class="me-2 stickylogo">
                </a>
            </div>
            <!-- Mobile buttons -->
            <div class="d-lg-none ms-auto me-2 mobbtsec">
                <div class="langselectmob">
                    <select class="form-select lang-selector" aria-label="Language selector">
                        <option value="en" {{ !request()->is('es*') ? 'selected' : '' }}>En</option>
                        <option value="es" {{ request()->is('es*') ? 'selected' : '' }}>Es</option>
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
                    @if(!request()->is('es*'))
                        <!-- English links -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}" href="/about-us/">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="/blog/">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact-us*') ? 'active' : '' }}" href="/contact-us/">Contact Us</a>
                        </li>
                    @else
                        <!-- Spanish links -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('es') || request()->is('es/') ? 'active' : '' }}" href="/es">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('es/articulos*') ? 'active' : '' }}" href="/es/articulos">Artículos</a>
                        </li>
                    @endif
                </ul>

                <!-- Call info -->
                <div class="m-3">
                    <select class="form-select lang-selector" aria-label="Language selector">
                        <option value="en" {{ !request()->is('es*') ? 'selected' : '' }}>En</option>
                        <option value="es" {{ request()->is('es*') ? 'selected' : '' }}>Es</option>
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

<script>
// Header functionality
document.addEventListener('DOMContentLoaded', function() {
    // Language selector functionality
    document.querySelectorAll('.lang-selector').forEach(select => {
        select.addEventListener('change', function() {
            const newLang = this.value;
            localStorage.setItem('language', newLang);
            if (newLang === 'en') {
                window.location.href = '/';
            } else {
                window.location.href = '/es';
            }
        });
    });

    // Toggle navbar class based on page
    function toggleNavbarClass() {
        const path = window.location.pathname;
        if (path === '/' || path === '/es' || path === '/es/') {
            document.querySelector('.navbar').classList.remove('header-fixed');
        } else {
            document.querySelector('.navbar').classList.add('header-fixed');
        }
    }
    
    toggleNavbarClass();

    // Travel call hover effects
    $('.travel-call').hover(
        function() {
            $(this).find('.small').css('color', '#ffffff');
        },
        function() {
            $(this).find('.small').css('color', '#000000');
        }
    );
});
</script>

<style>
    .travel-call {
        text-decoration: none;
    }
    .small {
        font-size: 14px !important;
        color: white !important;
    }
</style>
