@extends('app')

@section('title', 'FlyOFair | Sitemap')

@section('meta')
    <meta name="description" content="The Sitemap of FlyOFair contains all the information about the pages available on the website. Visitors or users can directly check any page via the sitemap." />
    <link rel="canonical" href="https://www.flyofair.com/sitemap/" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sitemap.css') }}">
@endpush

@section('content')
    <section class="innerbanner-section">
        <div class="innerbannerbg">
            <img src="{{ asset('images/banner/about-banner.jpg') }}" alt="">
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
                        <!-- English Quick Links Section -->
                        <div class="footer-section-block">
                            <h3 class="footer-section-heading">English Pages</h3>
                            <div class="footer-links-grid">
                                <div class="footer-link-column">
                                    <a href="{{ url('/') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Home</span>
                                    </a>
                                    <a href="{{ url('/blog') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Blog</span>
                                    </a>
                                    <a href="{{ url('/about-us') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">About Us</span>
                                    </a>
                                </div>
                                <div class="footer-link-column">
                                    <a href="{{ url('/contact-us') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Contact Us</span>
                                    </a>
                                    <a href="{{ url('/author') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Author</span>
                                    </a>
                                    <a href="{{ url('/terms-and-conditions') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Terms and Conditions</span>
                                    </a>
                                </div>
                                <div class="footer-link-column">
                                    <a href="{{ url('/privacy-policy') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Privacy Policy</span>
                                    </a>
                                    <a href="{{ url('/disclaimer') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Disclaimer</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Spanish Quick Links Section -->
                        <div class="footer-section-block">
                            <h3 class="footer-section-heading">Páginas en Español</h3>
                            <div class="footer-links-grid">
                                <div class="footer-link-column">
                                    <a href="{{ url('/es') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Inicio</span>
                                    </a>
                                    <a href="{{ url('/es/articulos') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Artículos</span>
                                    </a>
                                    <a href="{{ url('/es/sobre-nosotros') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Sobre Nosotros</span>
                                    </a>
                                </div>
                                <div class="footer-link-column">
                                    <a href="{{ url('/es/contactanos') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Contáctanos</span>
                                    </a>
                                    <a href="{{ url('/es/autor') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Autor</span>
                                    </a>
                                    <a href="{{ url('/es/terminos-y-condiciones') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Términos y Condiciones</span>
                                    </a>
                                </div>
                                <div class="footer-link-column">
                                    <a href="{{ url('/es/politica-de-privacidad') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Política de Privacidad</span>
                                    </a>
                                    <a href="{{ url('/es/descargo-de-responsabilidad') }}" class="footer-link-item">
                                        <i class="bi bi-record-circle footer-link-arrow"></i>
                                        <span class="footer-link-text">Descargo de Responsabilidad</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Section -->
                        @if(isset($blogs) && count($blogs) > 0)
                        <div class="footer-section-block">
                            <h3 class="footer-section-heading">Our Blog</h3>
                            <div class="footer-links-grid">
                                @php
                                    $blogChunks = array_chunk($blogs, ceil(count($blogs) / 3));
                                @endphp
                                @foreach($blogChunks as $blogGroup)
                                    <div class="footer-link-column">
                                        @foreach($blogGroup as $blog)
                                            <a href="{{ url('/blog/' . $blog['slug']) }}" class="footer-link-item">
                                                <i class="bi bi-record-circle footer-link-arrow"></i>
                                                <span class="footer-link-text">{{ $blog['title'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Articulos Section -->
                        @if(isset($articulos) && count($articulos) > 0)
                        <div class="footer-section-block">
                            <h3 class="footer-section-heading">Artículos</h3>
                            <div class="footer-links-grid">
                                @php
                                    $articuloChunks = array_chunk($articulos, ceil(count($articulos) / 3));
                                @endphp
                                @foreach($articuloChunks as $articuloGroup)
                                    <div class="footer-link-column">
                                        @foreach($articuloGroup as $articulo)
                                            <a href="{{ url('/es/articulos/' . $articulo['slug']) }}" class="footer-link-item">
                                                <i class="bi bi-record-circle footer-link-arrow"></i>
                                                <span class="footer-link-text">{{ $articulo['title'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection