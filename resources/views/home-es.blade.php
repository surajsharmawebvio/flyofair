@extends('app')

@section('title', 'FlyOFair | Reserva de vuelos con asistencia 24/7')

@section('meta')
    <meta name="description" content="FlyOFair es un portal integral para viajeros que necesitan ayuda con reservas de vuelos, cancelaciones, reembolsos, cambios de nombre y mucho más. Llame ahora al +1-877-238-0219." />
    <link rel="canonical" href="https://www.flyofair.com/es" />
@endsection

@section('content')
<section class="bannersection">
    <div class="bannerbgsec">
        <img src="/images/banner.png" alt="" />
    </div>

    <div class="flight-texture">
        <img src="/images/about-loaction.png" alt="" />
    </div>
    <div class="container">
        <div class="row justify-content-start align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="banner-box">
                    <h1 class="bannertitle">El cielo no es el límite, <span> es solo el comienzo.</span></h1>
                    <div class="banner-para">
                        <p>Con FlyOFair, lleva tus sueños al cielo y trae momentos que quedarán en tu corazón para siempre!</p>
                    </div> 
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="banner-image text-center">
                    <img src="/images/hero-man.webp" alt="imagen del banner" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="flight-booking-box">
                    <!-- Tabs -->
                    <ul class="nav flight-radio-tabs" id="flightTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="oneway-tab" data-bs-toggle="tab"
                                data-bs-target="#oneway-pane" type="button" role="tab"
                                aria-controls="oneway-pane" aria-selected="true">
                                Solo Ida
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="round-tab" data-bs-toggle="tab"
                                data-bs-target="#round-pane" type="button" role="tab" aria-controls="round-pane"
                                aria-selected="false">
                                Ida y Vuelta
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="multi-tab" data-bs-toggle="tab"
                                data-bs-target="#multi-pane" type="button" role="tab" aria-controls="multi-pane"
                                aria-selected="false">
                                Multi Ciudad
                            </button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content flight-tab-content" id="flightTabContent">
                        <!-- One Way -->
                        <div class="tab-pane fade show active" id="oneway-pane" role="tabpanel">
                            <form class="row g-3 align-items-end flight-form-fields flight-booking-form" data-trip-type="oneway">
                                @csrf
                                <input type="hidden" name="tripType" value="oneway" />
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Email</label>
                                    <input type="email" name="email" class="form-control flight-input"
                                        placeholder="Enter email" required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Phone</label>
                                    <div class="input-group">
                                        <select class="form-select country-code-select" style="max-width: 100px;">
                                            <!-- Options will be populated by JS -->
                                        </select>
                                        <input type="tel" class="form-control" placeholder="Phone Number"
                                            name="phone" required />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">Desde</label>
                                    <input type="text" name="from" class="form-control flight-input airport-from-input" 
                                        placeholder="Agregar salida" id="oneway-from" autocomplete="off" required>
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">Hasta</label>
                                    <input type="text" name="to" class="form-control flight-input airport-to-input" 
                                        placeholder="Agregar destino" id="oneway-to" autocomplete="off" required>
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Fecha de salida</label>
                                    <input id="oneway-departure" type="text" name="departureDate" class="date-input flight-input"
                                        placeholder="Departure date" readonly required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Pasajeros</label>
                                    <input readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 pasajero ECONÓMICO" />
                                    @include('partials.traveler-card')
                                </div>
                                <div class="col-lg-2 d-grid col-12">
                                    <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
                                </div>
                            </form>
                        </div>

                        <!-- Round Trip -->
                        <div class="tab-pane fade" id="round-pane" role="tabpanel">
                            <form class="row g-3 align-items-end flight-form-fields flight-booking-form" data-trip-type="round">
                                @csrf
                                <input type="hidden" name="tripType" value="round" />
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Email</label>
                                    <input type="email" name="email" class="form-control flight-input"
                                        placeholder="Enter email" required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Phone</label>
                                    <div class="input-group">
                                        <select class="form-select country-code-select" style="max-width: 100px;">
                                        </select>
                                        <input type="tel" class="form-control" placeholder="Phone Number"
                                            name="phone" required />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">Desde</label>
                                    <input type="text" name="from" class="form-control flight-input airport-from-input" 
                                        placeholder="Agregar salida" id="round-from" autocomplete="off" required />
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">Hasta</label>
                                    <input type="text" name="to" class="form-control flight-input airport-to-input" 
                                        placeholder="Agregar llegada" id="round-to" autocomplete="off" required />
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Fecha de salida</label>
                                    <input id="round-departure" type="text" name="departureDate" class="date-input flight-input"
                                        placeholder="Fecha de salida" readonly required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Fecha de regreso</label>
                                    <input id="round-return" type="text" name="returnDate" class="date-input flight-input"
                                        placeholder="Fecha de regreso" readonly required />
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Pasajeros</label>
                                    <input readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 pasajero ECONÓMICO" />
                                    @include('partials.traveler-card')
                                </div>
                                <div class="col-lg-2 d-grid col-12">
                                    <button type="submit" class="btn flight-search-btn">OBTENER COTIZACIÓN</button>
                                </div>
                            </form>
                        </div>

                        <!-- Multi-City -->
                        <div class="tab-pane fade" id="multi-pane" role="tabpanel">
                            <form class="flight-booking-form" data-trip-type="multi">
                                @csrf
                                <input type="hidden" name="tripType" value="multi" />
                                <div class="row g-3 align-items-end flight-form-fields">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Email</label>
                                        <input type="email" name="email" class="form-control flight-input"
                                            placeholder="Enter email" required />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Phone</label>
                                        <div class="input-group">
                                            <select class="form-select country-code-select" style="max-width: 100px;">
                                            </select>
                                            <input type="tel" class="form-control" placeholder="Phone Number"
                                                name="phone" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                        <label class="form-label search-label">From</label>
                                        <input type="text" name="from" class="form-control flight-input airport-from-input" 
                                            placeholder="Add departure" id="multi-from" autocomplete="off" required />
                                        <ul class="list-group position-absolute shadow airport-suggestions" 
                                            style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                        <label class="form-label search-label">To</label>
                                        <input type="text" name="to" class="form-control flight-input airport-to-input" 
                                            placeholder="Add arrival" id="multi-to" autocomplete="off" required />
                                        <ul class="list-group position-absolute shadow airport-suggestions" 
                                            style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Departure date</label>
                                        <input id="multi-departure" type="text" name="departureDate" class="date-input flight-input"
                                            placeholder="Departure date" readonly required />
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <label class="form-label search-label">Pasajeros</label>
                                        <input readonly class="form-control flight-guest-input flight-input"
                                            placeholder="1 pasajero ECONÓMICO" />
                                    </div>
                                    <div class="col-lg-2 d-grid mobsearchbtn col-12">
                                        <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
                                    </div>
                                </div>
                                <div class="addflightbtnbox">
                                    <a href="javascript:void(0)" class="linkbtn applyBtn applyBtnnew"> 
                                        <i class="fa-solid fa-plus"></i> Add Flight
                                    </a>
                                    <a href="javascript:void(0)" class="linkbtn cancelBtnnew cancelBtn" style="display: none">
                                        <i class="fa-solid fa-xmark"></i> Clear All
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section destinations-section">
    <div class="textureimage">
        <img src="/images/home/h1-img-9.png" alt="" />
    </div>
    <div class="textureimageleft">
        <img src="/images/about-4-1.webp" alt="" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 text-center">
                        <div class="section-header text-center">
                            <h2 class="mb-2">
                                Descubre los principales destinos de todo el mundo
                            </h2>
                            <p class="sub-title">
                                Explora los destinos más increíbles y crea recuerdos inolvidables con tu familia y amigos.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tour-slider owl-carousel">
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/atlanta.webp" alt="Atlanta" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Atlanta</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/chicago.webp" alt="Chicago" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Chicago</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/Frankfurt.webp" alt="Frankfurt" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Frankfurt</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/los-angeles.webp" alt="los-angeles" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Los Ángeles</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/miami.webp" alt="miami" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Miami</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/new-york-city.webp" alt="new-york-city" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Nueva York</h4>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="tour-card">
                        <img src="/images/destination/orlando.webp" alt="orlando" />
                        <div class="tour-info">
                            <div class="nameinfo-box">
                                <h4>Orlando</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section benefit-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 text-center">
                <div class="section-header text-center">
                    <h2 class="mb-2">
                        <strong>¿Por qué somos los mejores?</strong>
                    </h2>
                    <p class="sub-title">
                        Descubre nuestros beneficios clave y ventajas que pueden guiarte a las formas correctas para tu próxima planificación de viaje.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-vip">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <h3>Búsqueda de Vuelos Fluida</h3>
                    <p>Busca vuelos sin problemas y encuentra la mejor tarifa para tu destino.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-ticket">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3>Reserva Fácil de Vuelos</h3>
                    <p>Obtén un proceso de reserva sin problemas con nosotros para tu destino soñado.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-travel">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h3>Obtén Ofertas de Vuelos</h3>
                    <p>Encuentra las mejores ofertas y descuentos de vuelos con nosotros y ahorra dinero.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-price">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Proceso Transparente</h3>
                    <p>No cobramos tarifas ocultas ni usamos procedimientos ocultos.</p>
                </div>
            </div>
            <div class="col-sm-6 col-6 col-lg-3">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-support">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3>Asistencia de Viaje 24/7</h3>
                    <p>Obtén asistencia 24/7, 365 días de nosotros para tus necesidades de viaje.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-passenger">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3>Plataforma amigable para pasajeros</h3>
                    <p>Obtén una plataforma amigable para hacer realidad tu viaje soñado.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-info">
                        <i class="fa-solid fa-info-circle"></i>
                    </div>
                    <h3>Recursos de Información de Viaje</h3>
                    <p>Encuentra todas las actualizaciones e información sobre ofertas y descuentos de aerolíneas</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card h-100" style="min-height: 150px;">
                    <div class="info-icon icon-trust">
                        <i class="fa-solid fa-shield"></i>
                    </div>
                    <h3>Confiable</h3>
                    <p>Como OTA aprobada por IATA, generamos confianza completa con nuestros consumidores finales.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tg-chose-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-7">
                <div class="tg-chose-content">
                    <div class="section-header text-start">
                        <h2 class="mb-2">
                            Beneficios Clave de
                            <span class="text-primary text-primarysec text-decoration-underline">Elegir
                                FlyOFair</span>
                        </h2>
                    </div>
                    <div class="tg-chose-list-wrap">
                        <div class="tg-chose-list d-flex">
                            <span class="tg-chose-list-icon list-icon-one"><svg width="22" height="22"
                                    viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                        fill="white" />
                                </svg>
                            </span>
                            <div class="tg-chose-list-content">
                                <h3 class="tg-chose-list-title mb-5">Reserva de vuelos asequible</h3>
                                <p>Obtenga tarifas asequibles de vuelos con FlyOFair para su próximo viaje.</p>
                            </div>
                        </div>
                        <div class="tg-chose-list d-flex">
                            <span class="tg-chose-list-icon list-icon-two"><svg width="22" height="22"
                                    viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                        fill="white" />
                                </svg>
                            </span>
                            <div class="tg-chose-list-content">
                                <h4 class="tg-chose-list-title mb-5">Asistencia profesional de agentes de viajes</h4>
                                <p>Obtenga ayuda profesional de nuestros agentes de viajes experimentados.</p>
                            </div>
                        </div>
                        <div class="tg-chose-list d-flex">
                            <span class="tg-chose-list-icon list-icon-three"><svg width="22" height="22"
                                    viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                        fill="white" />
                                </svg>
                            </span>
                            <div class="tg-chose-list-content">
                                <h3 class="tg-chose-list-title mb-5">Soporte las 24 horas del día, los 7 días de la semana</h3>
                                <p>Obtenga soporte las 24 horas del día, los 7 días de la semana para todas sus consultas de viaje.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-5">
                <div class="tg-chose-right">
                    <img src="/images/home/advance.png" alt="image" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section faq-section">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="section-header text-center">
                    <h2 class="mb-2">
                        Todo sobre
                        <span class="text-primary text-primarysec text-decoration-underline">FlyOFair</span>
                        que debes saber
                    </h2>
                </div>
                <div class="accordion custom-accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                <span>¿Qué es FlyOFair?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    FlyOFair es una agencia de viajes en línea (OTA) emergente que brinda servicios de viaje integrales a viajeros globales. Ofrecemos reservas de vuelos, cancelaciones, políticas de nombre, actualizaciones de asientos y mucho más.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>¿Cómo puede comunicarse con FlyOFair?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Puede comunicarse con nosotros por correo electrónico, teléfono o chat en vivo. Nuestro equipo de atención al cliente está disponible las 24 horas del día, los 7 días de la semana para ayudarlo.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                                <span>¿Qué servicios ofrece FlyOFair a los pasajeros?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Ofrecemos servicios de reserva de vuelos, cancelaciones, reembolsos, cambios de nombre, actualizaciones de asientos, reservas de hoteles y alquiler de coches.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false"
                                aria-controls="collapseFive">
                                <span>¿FlyOFair ofrece asistencia al cliente las 24 horas, los 7 días de la semana?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Sí, FlyOFair ofrece asistencia al cliente las 24 horas del día, los 7 días de la semana a viajeros globales.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <span>¿Cómo puede reservar un vuelo con FlyOFair?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Puede reservar un vuelo con FlyOFair visitando nuestro sitio web, llamando a nuestra línea de atención al cliente o chateando con nosotros en vivo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section custom-testimonial-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="section-header text-center">
                    <h3 class="mb-2" style="font-weight: 600;">
                        ¿Qué dicen nuestros
                        <span class="text-primary text-primarysec text-decoration-underline">pasajeros valiosos</span> sobre nosotros?
                    </h3>
                    <p class="sub-title">
                        Valoramos verdaderamente la experiencia de viaje de nuestros pasajeros, y aquí hay algunos que lo explican todo.
                    </p>
                </div>
            </div>
        </div>

        <div class="owl-carousel custom-testimonial-carousel">
            <div class="testimonial-box">
                <p>
                    Desde el momento en que reservé hasta aterrizar en Bali, todo se sintió sin esfuerzo. El equipo de check-in fue muy amable e incluso recordó mi preferencia de asiento. Ver el amanecer sobre el océano mientras aterrizábamos — perfección. No se sintió como un simple viaje; se sintió como el comienzo de algo mágico.
                </p>
                <div class="testimonial-footer">
                    <img src="https://i.pravatar.cc/50?img=10" alt="User 1" />
                    <div>
                        <strong>Bryan Bradfield</strong><br />
                    </div>
                </div>
            </div>
            <div class="testimonial-box">
                <p>
                    Estaba nerviosa por viajar sola, pero la tripulación me hizo sentir como en casa. Me ayudaron a encontrar consejos locales para París e incluso imprimieron una mini guía de la ciudad. Servicio increíble con un toque personal — llegué lista para enamorarme de la ciudad de las luces.
                </p>
                <div class="testimonial-footer">
                    <img src="https://i.pravatar.cc/50?img=11" alt="User 2" />
                    <div>
                        <strong>Prajakta Sasane</strong><br />
                    </div>
                </div>
            </div>
            <div class="testimonial-box">
                <p>
                    Por lo general, los vuelos largos se sienten agotadores, pero este realmente voló. Todo, desde la comodidad del asiento hasta la cena a bordo, me hizo sentir cuidado. Para cuando descendimos sobre el horizonte de neón de Tokio, me sentí renovado y emocionado, no cansado. Esa es la diferencia que hace la hospitalidad genuina.
                </p>
                <div class="testimonial-footer">
                    <img src="https://i.pravatar.cc/50?img=12" alt="User 3" />
                    <div>
                        <strong>James Andrew</strong><br />
                    </div>
                </div>
            </div>
            <div class="testimonial-box">
                <p>
                    A veces, viajar se siente transaccional. Pero no esta vez. El equipo anticipó lo que necesitaba antes de que lo pidiera — desde mantener mi café caliente hasta ayudar con una transferencia retrasada. Cuando llegué a Zúrich, me di cuenta de que no era solo el destino lo que me impresionó — fue el viaje.
                </p>
                <div class="testimonial-footer">
                    <img src="https://i.pravatar.cc/50?img=12" alt="User 4" />
                    <div>
                        <strong>James Anderson</strong><br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="/js/home.js"></script>
@endpush