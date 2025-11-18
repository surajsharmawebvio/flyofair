@extends('app')

@section('title', 'FlyOFair | Reservas de Vuelos de Aerolíneas con Asistencia 24/7')

@section('meta')
    <meta name="description" content="FlyOFair es un portal único para viajeros que buscan asistencia con reservas de vuelos, cancelaciones, reembolsos, cambios de nombre y más. Llame +1-877-238-0219 ahora." />
    <link rel="canonical" href="{{ url('/es') }}" />
@endsection

@section('content')
    <div id="app">
        <!-- Spanish version of the home page -->
        <section class="bannersection">
            <div class="bannerbgsec">
                <img src="{{ asset('images/banner.png') }}" alt="" />
            </div>

            <div class="flight-texture">
                <img src="{{ asset('images/about-loaction.png') }}" alt="" />
            </div>

            <div class="container">
                <div class="row justify-content-start align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-box">
                            <h1 class="bannertitle">El cielo no es el límite, <span> es solo el comienzo.</span></h1>
                            <div class="banner-para">
                                <p>Con FlyOFair, lleva tus sueños al cielo y trae momentos que quedarán en tu corazón para siempre. Experimenta reservas de vuelos sin problemas, asistencia personalizada y soporte al cliente incomparable.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-image text-center">
                            <img src="{{ asset('images/hero-man.webp') }}" alt="imagen del banner" />
                        </div>
                    </div>
                </div>

                <!-- Flight Booking Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="flight-booking-box">
                            <!-- Flight booking form content would go here -->
                            <p>El formulario de reserva de vuelos se implementará aquí</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Include necessary JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@endsection