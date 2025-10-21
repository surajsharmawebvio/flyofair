<!-- Make home component as main content using defaultlayout -->
<script setup>
    import DefaultLayout from '@/layouts/DefaultLayout.vue'
    import {
        onMounted
    } from 'vue'

    onMounted(() => {
        // Initialize all owl carousels
        $('.tour-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });

        $('.blog-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });

        $('.custom-testimonial-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            items: 1
        });

        // Initialize date picker and traveler functionality with a small delay
        setTimeout(() => {
            // Initialize date picker for all date inputs
            if (typeof flatpickr !== 'undefined' && $('.date-input').length) {
                flatpickr('.date-input', {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    disableMobile: true
                });
            }

            // Initialize traveler form functionality
            initializeTravelerForm();
        }, 100);
    })

    // Traveler form functionality
    function initializeTravelerForm() {
        // Wait a bit for DOM to be fully ready
        setTimeout(() => {
            // Handle each traveler input separately since there are multiple forms
            $('.flight-guest-input').each(function(index) {
                const $input = $(this);
                const $card = $input.siblings('.traveler-card');
                
                // Ensure the parent container is positioned relatively
                $input.closest('.col-lg-3').css('position', 'relative');
                
                if (!$card.length) {
                    return;
                }

            const counts = { adult: 1, child: 0, infant: 0 };
            let lastAppliedCounts = { ...counts };
            let lastAppliedClass = 'Economy';

            function updateCounts() {
                // Find the count elements within this specific card
                const $countSpans = $card.find('span.common-numtext');
                if ($countSpans.length >= 3) {
                    $countSpans.eq(0).text(counts.adult);
                    $countSpans.eq(1).text(counts.child);
                    $countSpans.eq(2).text(counts.infant);
                }

                const total = counts.adult + counts.child + counts.infant;
                const $checkedClass = $card.find('input[name="travelClass"]:checked');
                const travelClass = $checkedClass.length ? $checkedClass.val().toUpperCase() : 'ECONOMY';
                $input.val(`${total} passenger${total > 1 ? 's' : ''} ${travelClass}`);
            }
            updateCounts();

            // Open card on click - use event delegation
            $input.off('click.traveler').on('click.traveler', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Hide all other cards first
                $('.traveler-card').removeClass('show').hide();
                $card.addClass('show').show();
                lastAppliedCounts = { ...counts };
                lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() || 'Economy';
            });

            // Prevent card from closing when clicking inside
            $card.off('click.traveler').on('click.traveler', function(e) {
                e.stopPropagation();
            });

            // Increment buttons
            $card.find('.traveler-plus').off('click.traveler').on('click.traveler', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const target = $(this).attr('data-target');
                if (target && counts.hasOwnProperty(target)) {
                    counts[target]++;
                    updateCounts();
                }
            });

            // Decrement buttons
            $card.find('.traveler-minus').off('click.traveler').on('click.traveler', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const target = $(this).attr('data-target');
                if (target && counts.hasOwnProperty(target)) {
                    if (target === 'adult' && counts[target] <= 1) return; // Don't go below 1 adult
                    if (target !== 'adult' && counts[target] <= 0) return; // Don't go below 0 for child/infant
                    counts[target]--;
                    updateCounts();
                }
            });

            // Update when radio changes
            $card.find('input[name="travelClass"]').off('change.traveler').on('change.traveler', function() {
                updateCounts();
            });

            // Apply button
            $card.find('#applyBtn').off('click.traveler').on('click.traveler', function(e) {
                e.preventDefault();
                e.stopPropagation();
                lastAppliedCounts = { ...counts };
                lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() || 'Economy';
                $card.removeClass('show').hide();
            });

            // Cancel button
            $card.find('#cancelBtn').off('click.traveler').on('click.traveler', function(e) {
                e.preventDefault();
                e.stopPropagation();
                Object.assign(counts, lastAppliedCounts);
                const $oldRadio = $card.find(`input[name="travelClass"][value="${lastAppliedClass}"]`);
                if ($oldRadio.length) {
                    $oldRadio.prop('checked', true);
                }
                updateCounts();
                $card.removeClass('show').hide();
            });
        });

        // Close when clicking outside - use event delegation with namespace
        $(document).off('click.traveler').on('click.traveler', function(e) {
            if (!$(e.target).closest('.traveler-card, .flight-guest-input').length) {
                $('.traveler-card').removeClass('show').hide();
            }
        });
        }, 50);
    }

</script>

<template>
    <DefaultLayout>
        <section class="bannersection">
            <div class="bannerbgsec">
                <img src="images/banner/yiKmOft.jpeg" alt="">
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">
                        <div class="banner-box">
                            <h1 class="bannertitle">
                                Get Closer to the Dream: Your Tour Essentials Await
                            </h1>
                            <!--
                            <div class="banner-para">
                                <p>
                                    Your ultimate destination for all things help you celebrate & remember tour
                                    experience.
                                </p>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="flight-booking-wrapper py-4">
            <div class="home-flight-booking">
                <div class="flight-booking-box">

                    <!-- Tabs -->
                    <ul class="nav flight-radio-tabs" id="flightTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="oneway-tab" data-bs-toggle="tab"
                                data-bs-target="#oneway-pane" type="button" role="tab" aria-controls="oneway-pane"
                                aria-selected="true">Oneway</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="round-tab" data-bs-toggle="tab" data-bs-target="#round-pane"
                                type="button" role="tab" aria-controls="round-pane" aria-selected="false">Round
                                Trip</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="multi-tab" data-bs-toggle="tab" data-bs-target="#multi-pane"
                                type="button" role="tab" aria-controls="multi-pane" aria-selected="false">Multi
                                Trip</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content flight-tab-content" id="flightTabContent">

                        <!-- One Way -->
                        <div class="tab-pane fade show active" id="oneway-pane" role="tabpanel">
                            <form class="row g-3 align-items-end flight-form-fields">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">From</label>
                                    <input type="text" class="form-control flight-input" placeholder="Add departure">
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">To</label>
                                    <input type="text" class="form-control flight-input" placeholder="Add destination">
                                </div>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <label class="form-label search-label">Departure date</label>
                                    <input id="Departure1" type="text" class="form-control date-input flight-input"
                                        placeholder="Departure date" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label class="form-label search-label">Guests</label>
                                    <input readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 passenger ECONOMY" id="travelerInput">
                                    <!-- Popup card -->
                                    <div class="traveler-card shadow p-3 rounded-3 mt-2" id="travelerCard" style="display: none;">
                                        <h6 class="mb-3 fw-bold">Select Travelers & Class</h6>

                                        <!-- Travelers Count -->
                                        <div class="mb-3 traveler-section">
                                            <div
                                                class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                <span class="boldtext">Adults (12+ Yrs)</span>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="adult"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="adult"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div
                                                class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                <span class="boldtext">Children (2-12 Yrs)</span>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="child"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="childCount" class="mx-2 common-numtext">0</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="child"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="traveler-row d-flex justify-content-between align-items-center">
                                                <span class="boldtext">Infants (0-2 Yrs)</span>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="infant"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="infant"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Class Selection -->
                                        <div class="mb-3 traveler-section">
                                            <label class="fw-semibold d-block mb-2">Class</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="eco" value="Economy" checked>
                                                <label class="form-check-label custome-form-check-label"
                                                    for="eco">Economy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="prem" value="Premium Economy">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="prem">Premium Economy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="bus" value="Business">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="bus">Business</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="first" value="First Class">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="first">First Class</label>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="text-end">
                                            <button class="btn cancelBtn me-2" id="cancelBtn">Cancel</button>
                                            <button class="btn applyBtn" id="applyBtn">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-12 d-grid">
                                    <button type="submit" class="btn flight-search-btn">Search</button>
                                </div>
                            </form>
                        </div>

                        <!-- Round Trip -->
                        <div class="tab-pane fade" id="round-pane" role="tabpanel">
                            <form class="row g-3 align-items-end flight-form-fields">
                                <div class="col-lg-2 col-md-6 col-12">
                                    <label class="form-label search-label">Departure from</label>
                                    <input type="text" class="form-control flight-input" placeholder="Add departure">
                                </div>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <label class="form-label search-label">Arrive at</label>
                                    <input type="text" class="form-control flight-input" placeholder="Add arrival">
                                </div>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <label class="form-label search-label">Departure date</label>
                                    <input id="Departure" type="text" class="form-control date-input flight-input"
                                        placeholder="Departure date" readonly>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <label class="form-label search-label">Return date</label>
                                    <input id="Return" type="text" class="form-control date-input flight-input"
                                        placeholder="Return date" readonly>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <label class="form-label search-label">Guests</label>
                                    <input type="text" readonly class="form-control flight-guest-input flight-input"
                                        placeholder="1 passenger ECONOMY" id="travelerInput">
                                    <!-- Popup card -->
                                    <div class="traveler-card shadow p-3 rounded-3 mt-2" id="travelerCard" style="display: none;">
                                        <h6 class="mb-3 fw-bold">Select Travelers & Class</h6>

                                        <!-- Travelers Count -->
                                        <div class="mb-3 traveler-section">
                                            <div
                                                class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                <span class="boldtext">Adults (12+ Yrs)</span>
                                                <div class="d-flex">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="adult"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="adult"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div
                                                class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                <span class="boldtext">Children (2-12 Yrs)</span>
                                                <div class="d-flex">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="child"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="childCount" class="mx-2 common-numtext">0</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="child"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="traveler-row d-flex justify-content-between align-items-center">
                                                <span class="boldtext">Infants (0-2 Yrs)</span>
                                                <div class="d-flex">
                                                    <button class="btn btn-light btn-sm traveler-minus"
                                                        data-target="infant"><i class="fa-solid fa-minus"></i></button>
                                                    <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                    <button class="btn btn-light btn-sm traveler-plus"
                                                        data-target="infant"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Class Selection -->
                                        <div class="mb-3 traveler-section">
                                            <label class="fw-semibold d-block mb-2">Class</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="eco" value="Economy" checked>
                                                <label class="form-check-label custome-form-check-label"
                                                    for="eco">Economy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="prem" value="Premium Economy">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="prem">Premium Economy</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="bus" value="Business">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="bus">Business</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input travel-class" type="radio"
                                                    name="travelClass" id="first" value="First Class">
                                                <label class="form-check-label custome-form-check-label"
                                                    for="first">First Class</label>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="text-end">
                                            <button class="btn cancelBtn me-2" id="cancelBtn">Cancel</button>
                                            <button class="btn applyBtn" id="applyBtn">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-12 d-grid">
                                    <button type="submit" class="btn flight-search-btn">Search</button>
                                </div>
                            </form>
                        </div>

                        <!-- Multi-City -->
                        <div class="tab-pane fade" id="multi-pane" role="tabpanel">
                            <form class="">
                                <div class="row g-3 align-items-end flight-form-fields">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Departure from</label>
                                        <input type="text" class="form-control flight-input"
                                            placeholder="Add departure">
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Arrive at</label>
                                        <input type="text" class="form-control flight-input" placeholder="Add arrival">
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <label class="form-label search-label">Departure date</label>
                                        <input id="Departure1" type="text" class="form-control date-input flight-input"
                                            placeholder="Departure date" readonly>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <label class="form-label search-label">Guests</label>
                                        <input type="text" readonly class="form-control flight-guest-input flight-input"
                                            placeholder="1 passenger ECONOMY" id="travelerInput">
                                    </div>
                                    <div class="col-lg-1 col-12 d-grid mobsearchbtn">
                                        <button type="submit" class="btn flight-search-btn">Search</button>
                                    </div>
                                </div>
                                <div class="addflightbtnbox">
                                    <a href="" class="linkbtn applyBtn applyBtnnew"> <i class="fa-solid fa-plus"></i>
                                        Add Flight</a>
                                    <a href="" class="linkbtn cancelBtnnew cancelBtn" style="display:none;"> <i
                                            class="fa-solid fa-xmark"></i>
                                        Clear
                                        All</a>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <section class="common-section destinations-section">
            <div class="textureimage">
                <img src="images/home/h1-img-9.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-10 text-center">
                                <div class="section-header text-center">
                                    <h2 class="mb-2">Search by <span
                                            class="text-primary text-primarysec text-decoration-underline">Destinations</span>
                                        Around the World </h2>
                                    <p class="sub-title">DreamsTour Marketplace is a platform designed to connect fans
                                        with exclusive
                                        experiences related to a specific tour</p>
                                </div>
                            </div>
                        </div>
                        <div class="tour-slider owl-carousel">
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-01.jpg" alt="Australia">
                                <div class="tour-info">
                                    <h4>Australia</h4>
                                    <div class="rating">
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>400 Reviews</span>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-02.jpg" alt="Brazil">
                                <div class="tour-info">
                                    <h4>Brazil</h4>
                                    <div class="rating">
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>422 Reviews</span>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-03.jpg" alt="Canada">
                                <div class="tour-info">
                                    <h4>Canada</h4>
                                    <div class="rating">
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>370 Reviews</span>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-04.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <h4>Turkey</h4>
                                    <div class="rating">
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>452 Reviews</span>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-05.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <h4>Turkey</h4>
                                    <div class="rating">
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span>452 Reviews</span>
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
                    <div class="col-lg-6 text-center">
                        <div class="section-header text-center">
                            <h2 class="mb-2">Why <span class="text-primary text-primarysec text-decoration-underline">
                                    Choose</span>
                                Us?</h2>
                            <p class="sub-title">
                                DreamsTour, a tour operator specializing in dream destinations, offers
                                a variety of
                                benefits for travelers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between testimonial-info-cards">
                    <!-- Best Price Guarantee -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #28a745;">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <h3>Best Price Guarantee</h3>
                            <p>We offer competitively priced fares to ensure you always get the best deals.</p>
                        </div>
                    </div>

                    <!-- 24/7 Customer Assistance -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #007bff;">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <h3>24/7 Customer Assistance</h3>
                            <p>Our dedicated team is available round the clock for any booking or travel assistance.</p>
                        </div>
                    </div>

                    <!-- Flexible Changes & Cancellations -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #ffc107;">
                                <i class="fa-solid fa-sync-alt"></i>
                            </div>
                            <h3>Flexible Changes & Cancellations</h3>
                            <p>Easily modify your flight details, including name changes or cancellations.</p>
                        </div>
                    </div>

                    <!-- Transparent Fees -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #17a2b8;">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <h3>Transparent Fees</h3>
                            <p>Enjoy complete clarity with no hidden charges or surprise costs.</p>
                        </div>
                    </div>

                    <!-- Seamless Booking Experience -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #6f42c1;">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h3>Seamless Booking Experience</h3>
                            <p>Quick search, simple navigation, and secure checkout for hassle-free bookings.</p>
                        </div>
                    </div>

                    <!-- Exclusive Offers & Deals -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #e83e8c;">
                                <i class="fa-solid fa-gift"></i>
                            </div>
                            <h3>Exclusive Offers & Deals</h3>
                            <p>Get access to real-time discounts and special travel promotions.</p>
                        </div>
                    </div>

                    <!-- Expert Travel Assistance -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #fd7e14;">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <h3>Expert Travel Assistance</h3>
                            <p>Personalized support from experienced travel professionals.</p>
                        </div>
                    </div>

                    <!-- Secure Transactions -->
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon" style="background-color: #dc3545;">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <h3>Secure Transactions</h3>
                            <p>Your data and payments are protected with advanced security measures.</p>
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
                            <h2 class="mb-2">Everything You Wonder <span
                                    class="text-primary text-primarysec text-decoration-underline">About
                                    Cruises:</span>
                                Answered Here</h2>
                        </div>
                        <div class="accordion custom-accordion" id="accordionExample">

                            <!-- Accordion Item 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span>How far in advance should I book my flight for the best price?
                                        </span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Our cruise packages typically include accommodation, meals, entertainment,
                                            and access to onboard activities. Some packages also include shore
                                            excursions and drinks. Check your specific package details.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span>Can I change or cancel my flight after booking?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Bring comfortable clothing for daytime activities, formal wear for dinners,
                                            swimwear, toiletries, and any personal items you need. Don’t forget your
                                            travel documents and a hat or sunscreen for sunny days.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <span>What documents do I need for domestic and international flights?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            In case of cancellation due to unforeseen circumstances, we offer full
                                            refunds or the option to reschedule your cruise. We will inform you promptly
                                            and assist with your preferred option to ensure a smooth process.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        <span>How can I check my flight status or itinerary?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Visa requirements depend on your nationality and the cruise itinerary. We
                                            recommend checking the visa policies for each port of call and consulting
                                            with your local embassy before booking.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        <span>Are there additional charges for baggage?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Safety is our top priority. We adhere to strict health protocols,
                                            including regular sanitation, safety drills, and trained crew members to
                                            ensure a secure and protected environment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        <span>How do I choose my preferred seat?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Safety is our top priority. We adhere to strict health protocols,
                                            including regular sanitation, safety drills, and trained crew members to
                                            ensure a secure and protected environment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        <span>How do I contact customer support for flight assistance?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Safety is our top priority. We adhere to strict health protocols,
                                            including regular sanitation, safety drills, and trained crew members to
                                            ensure a secure and protected environment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </DefaultLayout>
</template>

<script>
    import './../../css/common.css';
    import DefaultLayout from '@/layouts/DefaultLayout.vue';

    export default {
        name: 'Home',
        components: {
            DefaultLayout
        }
    }

</script>

<style scoped>
    @media (max-width: 767.98px) {
        .NewsLettert-InnConBox {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }

    @media (max-width: 1199px) {
        .NewsLettert-InnConBox {
            min-height: 250px !important;
        }
    }

    .flight-booking-box {
        padding: 10px;
    }

    .home-flight-booking {
        width: 85%;
        margin: auto;
    }

    .poppin-font {
        font-family: 'Poppins', sans-serif;
    }

    .tg-chose-area {
        padding: 0 0 !important;
    }

    /* use @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap'); font where class is roboto */
    .roboto-font {
        font-family: 'Roboto', sans-serif;
    }
    .testimonial-info-cards {
        row-gap: 20px;
    }

    .testimonial-info-cards .info-card {
        height: 175px;
    }

    /* Initially hide traveler cards */
    .traveler-card {
        display: none !important;
        position: absolute;
        z-index: 1000;
        background: white;
        min-width: 300px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        top: 100%;
        left: 0;
        right: 0;
    }

    /* Show state */
    .traveler-card.show {
        display: block !important;
    }

    /* Position the traveler input container relative for absolute positioning */
    .flight-guest-input {
        position: relative;
    }
    
    /* Ensure proper positioning for form field containers */
    .flight-form-fields .col-lg-3 {
        overflow: visible;
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
    body, h1, h2, h3, h4, h5, h6, p {
        /* font-family: "Rubik", sans-serif; */
        font-family: "Cambria" !important;
        font-weight: 400;
        font-style: normal;
    }

</style>
