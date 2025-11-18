@extends('app')

@section('title', 'FlyOFair | Airlines Flight Booking With 24/7 Assistance')

@section('meta')
    <meta name="description" content="FlyOFair is a one-stop portal for travellers seeking assistance with flight bookings, cancellations, refunds, name changes, and more. Call +1-877-238-0219 now." />
    <link rel="canonical" href="{{ url('/') }}" />
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
                    <h1 class="bannertitle">The sky isn't the limit, <span> it's just the beginning.</span></h1>
                    <div class="banner-para">
                        <p>With FlyOFair, take your dreams to the sky and bring back moments that will stay in your heart forever!</p>
                    </div> 
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="banner-image text-center">
                    <img src="/images/hero-man.webp" alt="banner image" />
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
                                Oneway
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="round-tab" data-bs-toggle="tab"
                                data-bs-target="#round-pane" type="button" role="tab" aria-controls="round-pane"
                                aria-selected="false">
                                Round Trip
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="multi-tab" data-bs-toggle="tab"
                                data-bs-target="#multi-pane" type="button" role="tab" aria-controls="multi-pane"
                                aria-selected="false">
                                Multi Trip
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
                                    <label class="form-label search-label">From</label>
                                    <input type="text" name="from" class="form-control flight-input airport-from-input" 
                                        placeholder="Add departure" id="oneway-from" autocomplete="off" required>
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">To</label>
                                    <input type="text" name="to" class="form-control flight-input airport-to-input" 
                                        placeholder="Add destination" id="oneway-to" autocomplete="off" required>
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Departure date</label>
                                    <input id="oneway-departure" type="text" name="departureDate" class="date-input flight-input"
                                        placeholder="Departure date" readonly required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Guests</label>
                                    <input readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 passenger ECONOMY" />
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
                                    <label class="form-label search-label">From</label>
                                    <input type="text" name="from" class="form-control flight-input airport-from-input" 
                                        placeholder="Add departure" id="round-from" autocomplete="off" required />
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12" style="position: relative;">
                                    <label class="form-label search-label">To</label>
                                    <input type="text" name="to" class="form-control flight-input airport-to-input" 
                                        placeholder="Add arrival" id="round-to" autocomplete="off" required />
                                    <ul class="list-group position-absolute shadow airport-suggestions" 
                                        style="width:100%; max-height:220px; z-index:1050; display:none; overflow-y:auto;">
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Departure date</label>
                                    <input id="round-departure" type="text" name="departureDate" class="date-input flight-input"
                                        placeholder="Departure date" readonly required />
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Return date</label>
                                    <input id="round-return" type="text" name="returnDate" class="date-input flight-input"
                                        placeholder="Return date" readonly required />
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Guests</label>
                                    <input type="text" readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 passenger ECONOMY" />
                                    @include('partials.traveler-card')
                                </div>
                                <div class="col-lg-2 d-grid col-12">
                                    <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
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
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Guests</label>
                                        <input type="text" readonly class="form-control flight-guest-input flight-input"
                                            placeholder="1 passenger ECONOMY" />
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
                                Explore your desired <span
                                    class="text-primary text-primarysec text-decoration-underline">destinations</span>
                                at ease.
                            </h2>
                            <p class="sub-title">
                                FlyOFair offers a passenger-centric platform that delivers the cheapest deals
                                and 24/7 assistance to global travellers.
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
                                <h4>Los Angeles</h4>
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
                                <h4>New York City</h4>
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
                        <strong>Why are we the best?</strong>
                    </h2>
                    <p class="sub-title">
                        Check out our key benefits and advantages that can guide you to the right ways for your
                        next travel planning.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-vip">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <h3>Smooth Flight Search</h3>
                    <p>Search flights without hassle and find the best fare for your destination.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-ticket">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3>Easy Flight Booking</h3>
                    <p>Get the seamless booking process with us for your dream destination.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-travel">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h3>Get Flight Deals</h3>
                    <p>Find the best flight deals and discounts from us and save your money.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-price">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Transparent Process</h3>
                    <p>We don't charge any hidden fees or use any hidden procedures.</p>
                </div>
            </div>
            <div class="col-sm-6 col-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon icon-support">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3>24/7 Travel Assistance</h3>
                    <p>Get 24/7, 365-day assistance from us for your travel needs.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-passenger">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3>Passenger-friendly platform</h3>
                    <p>Get a passenger-friendly platform to make your dream travel come true.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-info">
                        <i class="fa-solid fa-info-circle"></i>
                    </div>
                    <h3>Information Travel Resources</h3>
                    <p>Find all updates and information related to airlines' deals and discounts</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-6">
                <div class="info-card">
                    <div class="info-icon icon-trust">
                        <i class="fa-solid fa-shield"></i>
                    </div>
                    <h3>Trusted </h3>
                    <p>As an IATA-approved OTA, we drive complete trust with our end consumers.</p>
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
                            Key Benefits of
                            <span class="text-primary text-primarysec text-decoration-underline">Choosing
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
                                <h3 class="tg-chose-list-title mb-5">Personalized Flight Recommendations</h3>
                                <p>FlyOFair will guide you and suggest tailor-made flight options.</p>
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
                                <h4 class="tg-chose-list-title mb-5">Real-time Flight Updates</h4>
                                <p>Always stay informed with real-time flight updates and notifications.</p>
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
                                <h3 class="tg-chose-list-title mb-5">Easy modifications </h3>
                                <p>Get the benefits of modifying your booking, including cancellations and changes.</p>
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
                        All About
                        <span class="text-primary text-primarysec text-decoration-underline">FlyOFair</span>
                        You Should Know
                    </h2>
                </div>
                <div class="accordion custom-accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                <span>Can I modify my reservation on FlyOFair?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Yes, you can modify your reservation in accordance with the airline's terms
                                    and conditions. We are available 24/7 to guide you with the modifications.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>How can FlyOFair help you find the best deals?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    We are offering the best passenger-centric platform that delivers amazing
                                    deals and discounts through fare comparison for global travellers.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                                <span>Does FlyOFair offer customer service assistance?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    Yes, FlyOFair offers customer service assistance to its valued passengers.
                                    Travellers can connect with us 24/7, 365 days a year for expert help.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false"
                                aria-controls="collapseFive">
                                <span>How can I stay updated on new offers and deals?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h4>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    With FlyOFair, you can access our newsletter, and from there you will
                                    receive emails with current deals and discounts to your desired
                                    destinations.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <span>Why makes FlyOFair better than other online travel agencies?</span>
                                <i class="icon fas fa-eye-slash ms-auto"></i>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="sub-title">
                                    FlyOFair is completely focused on passenger satisfaction and convenience. As
                                    a trusted OTA, we offer an easy flight search and reservation experience.
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
                        What do our
                        <span class="text-primary text-primarysec text-decoration-underline">valuable
                            passengers</span> say about us?
                    </h3>
                    <p class="sub-title">
                        We truly value our passengers' travel experience, and here are some that explain everything.
                    </p>
                </div>
            </div>
        </div>

        <div class="owl-carousel custom-testimonial-carousel">
            <div class="testimonial-box">
                <p>
                    From the moment I booked until landing in Bali, everything felt effortless. The check‑in team was so kind and even remembered my seat preference. Watching the sunrise over the ocean as we landed — perfection. It didn't feel like just a trip; it felt like the beginning of something magical.
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
                    I was nervous about traveling solo, but the crew made me feel right at home. They helped me find local tips for Paris and even printed a mini city guide. Amazing service with a personal touch — I arrived ready to fall in love with the city of lights.
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
                    Usually, long flights feel exhausting, but this one honestly flew by. Everything from the seat comfort to the onboard dinner made me feel cared for. By the time we descended over Tokyo's neon skyline, I felt refreshed and excited, not tired. That's the difference genuine hospitality makes
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
                    Sometimes, travel feels transactional. But not this time. The team anticipated what I needed before I even asked — from keeping my coffee hot to helping with a delayed transfer. When I reached Zurich, I realized it wasn't just the destination that impressed me — it was the journey.
                </p>
                <div class="testimonial-footer">
                    <img src="https://i.pravatar.cc/50?img=12" alt="User 4" />
                    <div>
                        <strong>James Andrson</strong><br />
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