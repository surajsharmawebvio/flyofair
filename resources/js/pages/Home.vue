<!-- Make home component as main content using defaultlayout -->
<script setup>
    import DefaultLayout from '@/layouts/DefaultLayout.vue'
    import {
        onMounted,
        onUnmounted,
        ref,
        computed,
        watch
    } from 'vue'
    import './../../css/common.css';
    import axios from 'axios';
    import debounce from 'lodash/debounce';

    // --- From search input handling ---
    const showSuggestions = ref(false);
    const highlighted = ref(-1);
    const fromWrapper = ref(null);

    // Handle clicks outside the dropdown (both From and To)
    function handleClickOutside(event) {
        const target = event.target;
        if (fromWrapper.value && !fromWrapper.value.contains(target)) {
            showSuggestions.value = false;
        }
        if (toWrapper.value && !toWrapper.value.contains(target)) {
            showToSuggestions.value = false;
        }
    }

    // Handle input blur
    function handleBlur() {
        // Use setTimeout to allow click events on suggestions to fire first
        setTimeout(() => {
            showSuggestions.value = false;
        }, 200);
    }

    // Add/remove click outside listener
    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside);
    });

    function onFromInput() {
        highlighted.value = -1;
        showSuggestions.value = true;
    }

    const searchQuery = ref('')
    const results = ref([])
    // --- To results (separate list) ---
    const toResults = ref([])

    const fetchAirports = debounce(async (query) => {
        if (!query) {
            results.value = []
            return
        }

        const latLong = localStorage.getItem('lat&long')

        try {
            const res = await axios.get('/airports/search', {
                params: {
                    query,
                    latLong
                },
            })
            results.value = res.data.data // assuming { data: [ ... ] }
            // console.log('Fetched airports:', results.value)
        } catch (error) {
            console.error('Error fetching airports:', error)
        }
    }, 400)

    watch(searchQuery, (newVal) => {
        fetchAirports(newVal)
    })

    const selectAirport = (airport) => {
        searchQuery.value = `${airport.airport_code} — ${airport.airport_name}`
        results.value = [] // hide dropdown after selection
        showSuggestions.value = false // hide dropdown
    }

    function onFromKeydown(e) {
        if (!showSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlighted.value = Math.min(highlighted.value + 1, results.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlighted.value = Math.max(highlighted.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlighted.value >= 0 && results.value[highlighted.value]) {
                selectAirport(results.value[highlighted.value]);
            } else if (results.value.length === 1) {
                selectAirport(results.value[0]);
            }
        } else if (e.key === 'Escape') {
            showSuggestions.value = false;
        }
    }

    function selectSuggestion(item) {
        searchQuery.value = item.name;
        showSuggestions.value = false;
        highlighted.value = -1;
    }

    // --- To search input handling ---
    const toQuery = ref('');
    const showToSuggestions = ref(false);
    const highlightedTo = ref(-1);
    const toWrapper = ref(null);

    function onToInput() {
        highlightedTo.value = -1;
        showToSuggestions.value = true;
    }

    // Watch and fetch for To input (separate results)
    const fetchAirportsTo = debounce(async (query) => {
        if (!query) {
            toResults.value = [];
            return;
        }

        const latLong = localStorage.getItem('lat&long')

        try {
            const res = await axios.get('/airports/search', {
                params: {
                    query,
                    latLong
                },
            })
            toResults.value = res.data.data || []
        } catch (error) {
            console.error('Error fetching airports (to):', error)
        }
    }, 400)

    watch(toQuery, (newVal) => {
        fetchAirportsTo(newVal)
    })

    function selectToAirport(airport) {
        toQuery.value = `${airport.airport_code} — ${airport.airport_name}`
        toResults.value = []
        showToSuggestions.value = false
    }

    function onToKeydown(e) {
        if (!showToSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedTo.value = Math.min(highlightedTo.value + 1, toResults.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedTo.value = Math.max(highlightedTo.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedTo.value >= 0 && toResults.value[highlightedTo.value]) {
                selectToAirport(toResults.value[highlightedTo.value]);
            } else if (toResults.value.length === 1) {
                selectToAirport(toResults.value[0]);
            }
        } else if (e.key === 'Escape') {
            showToSuggestions.value = false;
        }
    }

    function handleToBlur() {
        setTimeout(() => {
            showToSuggestions.value = false;
        }, 200);
    }

    function getLocation() {
        if (navigator.geolocation && !localStorage.getItem('lat&long')) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    localStorage.setItem('lat&long', JSON.stringify({
                        lat: position.coords.latitude,
                        lon: position.coords.longitude
                    }));
                },
                (error) => {
                    console.error('Error getting location:', error);
                }
            );
        }
    }

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

        // Call the location fetch moved from options-api
        // if (!localStorage.getItem('lat&long')) getLocation();
        getLocation();
    })

    // Traveler form functionality
    function initializeTravelerForm() {
        // Wait a bit for DOM to be fully ready
        setTimeout(() => {
            // Handle each traveler input separately since there are multiple forms
            $('.flight-guest-input').each(function (index) {
                const $input = $(this);
                const $card = $input.siblings('.traveler-card');

                // Ensure the parent container is positioned relatively
                $input.closest('.col-lg-3').css('position', 'relative');

                if (!$card.length) {
                    return;
                }

                const counts = {
                    adult: 1,
                    child: 0,
                    infant: 0
                };
                let lastAppliedCounts = {
                    ...counts
                };
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
                    const travelClass = $checkedClass.length ? $checkedClass.val().toUpperCase() :
                        'ECONOMY';
                    $input.val(`${total} passenger${total > 1 ? 's' : ''} ${travelClass}`);
                }
                updateCounts();

                // Open card on click - use event delegation
                $input.off('click.traveler').on('click.traveler', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Hide all other cards first
                    $('.traveler-card').removeClass('show').hide();
                    $card.addClass('show').show();
                    lastAppliedCounts = {
                        ...counts
                    };
                    lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() ||
                        'Economy';
                });

                // Prevent card from closing when clicking inside
                $card.off('click.traveler').on('click.traveler', function (e) {
                    e.stopPropagation();
                });

                // Increment buttons
                $card.find('.traveler-plus').off('click.traveler').on('click.traveler', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const target = $(this).attr('data-target');
                    if (target && counts.hasOwnProperty(target)) {
                        counts[target]++;
                        updateCounts();
                    }
                });

                // Decrement buttons
                $card.find('.traveler-minus').off('click.traveler').on('click.traveler', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const target = $(this).attr('data-target');
                    if (target && counts.hasOwnProperty(target)) {
                        if (target === 'adult' && counts[target] <= 1)
                            return; // Don't go below 1 adult
                        if (target !== 'adult' && counts[target] <= 0)
                            return; // Don't go below 0 for child/infant
                        counts[target]--;
                        updateCounts();
                    }
                });

                // Update when radio changes
                $card.find('input[name="travelClass"]').off('change.traveler').on('change.traveler',
                    function () {
                        updateCounts();
                    });

                // Apply button
                $card.find('#applyBtn').off('click.traveler').on('click.traveler', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    lastAppliedCounts = {
                        ...counts
                    };
                    lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() ||
                        'Economy';
                    $card.removeClass('show').hide();
                });

                // Cancel button
                $card.find('#cancelBtn').off('click.traveler').on('click.traveler', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    Object.assign(counts, lastAppliedCounts);
                    const $oldRadio = $card.find(
                        `input[name="travelClass"][value="${lastAppliedClass}"]`);
                    if ($oldRadio.length) {
                        $oldRadio.prop('checked', true);
                    }
                    updateCounts();
                    $card.removeClass('show').hide();
                });
            });

            // Close when clicking outside - use event delegation with namespace
            $(document).off('click.traveler').on('click.traveler', function (e) {
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
                <img src="images/banner.png" alt="">
            </div>

            <div class="flight-texture">
                <img src="images/about-loaction.png" alt="">
            </div>
            <div class="container">
                <div class="row justify-content-start align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-box">
                            <h1 class="bannertitle">
                                Get Closer to the Dream: <span>Your Tour Essentials Await</span>
                            </h1>
                            <div class="banner-para">
                                <p>
                                    Your ultimate destination for all things help you celebrate & remember tour
                                    experience.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-image text-center">
                            <img src="images/hero-man.webp" alt="banner image">
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
                                        aria-controls="oneway-pane" aria-selected="true">Oneway</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="round-tab" data-bs-toggle="tab"
                                        data-bs-target="#round-pane" type="button" role="tab" aria-controls="round-pane"
                                        aria-selected="false">Round
                                        Trip</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="multi-tab" data-bs-toggle="tab"
                                        data-bs-target="#multi-pane" type="button" role="tab" aria-controls="multi-pane"
                                        aria-selected="false">Multi
                                        Trip</button>
                                </li>
                            </ul>

                            <!-- Tab content -->
                            <div class="tab-content flight-tab-content" id="flightTabContent">

                                <!-- One Way -->
                                <div class="tab-pane fade show active" id="oneway-pane" role="tabpanel">
                                    <form class="row g-3 align-items-end flight-form-fields">
                                        <div ref="fromWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">From</label>
                                            <input v-model="searchQuery" 
                                                @input="onFromInput" 
                                                @keydown="onFromKeydown"
                                                @focus="showSuggestions = true"
                                                @blur="handleBlur"
                                                type="text" 
                                                class="form-control flight-input"
                                                placeholder="Add departure" 
                                                id="flight-search-from" 
                                                autocomplete="off">

                                            <!-- Suggestions dropdown -->
                                            <ul v-if="showSuggestions && results.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in results" 
                                                    :key="index"
                                                    class="list-group-item" 
                                                    style="cursor:pointer;"
                                                    @mousedown.prevent="selectAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> — {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div ref="toWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">To</label>
                                            <input v-model="toQuery" @input="onToInput" @keydown="onToKeydown"
                                                @focus="showToSuggestions = true"
                                                @blur="handleToBlur"
                                                type="text" class="form-control flight-input"
                                                placeholder="Add destination" id="flight-search-to" autocomplete="off">

                                            <!-- To Suggestions dropdown -->
                                            <ul v-if="showToSuggestions && toResults.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in toResults" :key="index"
                                                    class="list-group-item" style="cursor:pointer;"
                                                    @mousedown.prevent="selectToAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> — {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Departure date</label>
                                            <input id="Departure1" type="text" class="date-input flight-input"
                                                placeholder="Departure date" readonly>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Guests</label>
                                            <input readonly class="form-control flight-guest-input flight-input"
                                                placeholder="1 passenger ECONOMY" id="travelerInput">
                                            <!-- Popup card -->
                                            <div class="traveler-card shadow p-3 rounded-3 mt-2" id="travelerCard">
                                                <h6 class="mb-3 fw-bold">Select Travelers & Class</h6>

                                                <!-- Travelers Count -->
                                                <div class="mb-3 traveler-section">
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Adults (12+ Yrs)</span>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="adult"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="adult"><i
                                                                    class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Children (2-12 Yrs)</span>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="child"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="childCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="child"><i
                                                                    class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center">
                                                        <span class="boldtext">Infants (0-2 Yrs)</span>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="infant"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="infant"><i
                                                                    class="fa-solid fa-plus"></i></button>
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
                                        <div class="col-lg-2 col-12 d-grid">
                                            <button type="submit" class="btn flight-search-btn">Get a quote</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Round Trip -->
                                <div class="tab-pane fade" id="round-pane" role="tabpanel">
                                    <form class="row g-3 align-items-end flight-form-fields">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Email</label>
                                            <input type="text" class="form-control flight-input"
                                                placeholder="Enter email">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Phone</label>
                                            <input type="text" id="mobile_code2" class="form-control"
                                                placeholder="Phone Number" name="name">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <label class="form-label search-label">Departure from</label>
                                            <input type="text" class="form-control flight-input"
                                                placeholder="Add departure">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <label class="form-label search-label">Arrive at</label>
                                            <input type="text" class="form-control flight-input"
                                                placeholder="Add arrival">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <label class="form-label search-label">Departure date</label>
                                            <input id="Departure" type="text" class="date-input flight-input"
                                                placeholder="Departure date" readonly>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Return date</label>
                                            <input id="Return" type="text" class="date-input flight-input"
                                                placeholder="Return date" readonly>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <label class="form-label search-label">Guests</label>
                                            <input type="text" readonly
                                                class="form-control flight-guest-input flight-input"
                                                placeholder="1 passenger ECONOMY" id="travelerInput">
                                            <!-- Popup card -->
                                            <div class="traveler-card shadow p-3 rounded-3 mt-2" id="travelerCard">
                                                <h6 class="mb-3 fw-bold">Select Travelers & Class</h6>

                                                <!-- Travelers Count -->
                                                <div class="mb-3 traveler-section">
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Adults (12+ Yrs)</span>
                                                        <div class="d-flex">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="adult"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="adult"><i
                                                                    class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Children (2-12 Yrs)</span>
                                                        <div class="d-flex">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="child"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="childCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="child"><i
                                                                    class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center">
                                                        <span class="boldtext">Infants (0-2 Yrs)</span>
                                                        <div class="d-flex">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="infant"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="infant"><i
                                                                    class="fa-solid fa-plus"></i></button>
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
                                        <div class="col-lg-2 col-12 d-grid">
                                            <button type="submit" class="btn flight-search-btn">Get a quote</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Multi-City -->
                                <div class="tab-pane fade" id="multi-pane" role="tabpanel">
                                    <form class="">
                                        <div class="row g-3 align-items-end flight-form-fields">
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Email</label>
                                                <input type="text" class="form-control flight-input"
                                                    placeholder="Enter email">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Phone</label>
                                                <input type="text" id="mobile_code3" class="form-control"
                                                    placeholder="Phone Number" name="name">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Departure from</label>
                                                <input type="text" class="form-control flight-input"
                                                    placeholder="Add departure">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Arrive at</label>
                                                <input type="text" class="form-control flight-input"
                                                    placeholder="Add arrival">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Departure date</label>
                                                <input id="Departure1" type="text" class="date-input flight-input"
                                                    placeholder="Departure date" readonly>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Guests</label>
                                                <input type="text" readonly
                                                    class="form-control flight-guest-input flight-input"
                                                    placeholder="1 passenger ECONOMY" id="travelerInput">
                                            </div>
                                            <div class="col-lg-2 col-12 d-grid mobsearchbtn">
                                                <button type="submit" class="btn flight-search-btn">Get a quote</button>
                                            </div>
                                        </div>
                                        <div class="addflightbtnbox">
                                            <a href="" class="linkbtn applyBtn applyBtnnew"> <i
                                                    class="fa-solid fa-plus"></i>
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
                </div>
            </div>
        </section>
        <section class="common-section destinations-section">
            <div class="textureimage">
                <img src="images/home/h1-img-9.png" alt="">
            </div>
            <div class="textureimageleft">
                <img src="images/about-4-1.webp" alt="">
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
                                    <div class="nameinfo-box">
                                        <h4>New York City</h4>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-02.jpg" alt="Brazil">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Chicago</h4>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-03.jpg" alt="Canada">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Los Angeles</h4>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-04.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Denver</h4>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-05.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Atlanta</h4>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-05.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Miami</h4>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-05.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Orlando</h4>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="tour-card">
                                <img src="images/home/destination-05.jpg" alt="Turkey">
                                <div class="tour-info">
                                    <div class="nameinfo-box">
                                        <h4>Frankfurt</h4>
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
                            <h2 class="mb-2">Our <span
                                    class="text-primary text-primarysec text-decoration-underline">Benefits</span>
                                &amp; Key
                                Advantages</h2>
                            <p class="sub-title">DreamsTour, a tour operator specializing in dream destinations, offers
                                a variety of
                                benefits for travelers.</p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between">
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-vip">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3>VIP Packages</h3>
                            <p>Include premium seating, meet-and-greet experiences, backstage tours.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-ticket">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div>
                            <h3>Concert Tickets</h3>
                            <p>A centralized place to buy tickets for various dates of the tour.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-travel">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            <h3>Travel Packages</h3>
                            <p>Bundles that include concert tickets, accommodations.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-price">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <h3>Best Price Guarantee</h3>
                            <p>Such as private rehearsals, soundcheck access.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-vip">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3>VIP Packages</h3>
                            <p>Include premium seating, meet-and-greet experiences, backstage tours.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-ticket">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div>
                            <h3>Concert Tickets</h3>
                            <p>A centralized place to buy tickets for various dates of the tour.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-travel">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            <h3>Travel Packages</h3>
                            <p>Bundles that include concert tickets, accommodations.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6 col-lg-3">
                        <div class="info-card">
                            <div class="info-icon icon-price">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <h3>Best Price Guarantee</h3>
                            <p>Such as private rehearsals, soundcheck access.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tg-chose-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="tg-chose-content">
                            <div class="section-header text-start">
                                <h2 class="mb-2">Book your next trip <span
                                        class="text-primary text-primarysec text-decoration-underline">Benein 3 easy
                                        stepsfits</span></h2>
                            </div>
                            <div class="tg-chose-list-wrap">
                                <div class="tg-chose-list d-flex"><span class="tg-chose-list-icon list-icon-one"><svg
                                            width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                                fill="white" />
                                        </svg>

                                    </span>
                                    <div class="tg-chose-list-content">
                                        <h4 class="tg-chose-list-title mb-5">Choose Destination</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Urna, tortor tempus.
                                        </p>
                                    </div>
                                </div>
                                <div class="tg-chose-list d-flex"><span class="tg-chose-list-icon list-icon-two"><svg
                                            width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                    <div class="tg-chose-list-content">
                                        <h4 class="tg-chose-list-title mb-5">Make Payment</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Urna, tortor tempus.
                                        </p>
                                    </div>
                                </div>
                                <div class="tg-chose-list d-flex"><span class="tg-chose-list-icon list-icon-three"><svg
                                            width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.544607 4.47549C0.248039 4.47549 0.00539207 4.23284 0 3.93627V0.544608C0 0.242647 0.242647 0 0.544607 0H3.93627C4.23284 0 4.47549 0.242647 4.47549 0.544608V1.72549H17.5245V0.544608C17.5245 0.248039 17.7672 0.00539216 18.0637 0H21.4554C21.752 0 21.9946 0.242647 22 0.544608V3.93627C22 4.23284 21.7574 4.47549 21.4554 4.47549H20.2745V17.5245H21.4554C21.752 17.5245 21.9946 17.7672 22 18.0637V21.4554C22 21.752 21.7574 21.9946 21.4554 22H18.0637C17.7672 22 17.5245 21.7574 17.5245 21.4554V20.2745H4.47549V21.4554C4.47549 21.752 4.23284 21.9946 3.93627 22H0.544607C0.248039 22 0.00539207 21.7574 0 21.4554V18.0637C0 17.7672 0.242647 17.5245 0.544607 17.5245H1.72549V4.47549H0.544607ZM20.9216 3.39706V1.07843H18.6029V3.39706H20.9216ZM18.6029 20.9216H20.9216V18.6029H18.6029V20.9216ZM4.47549 18.0637V19.1961H17.5245V18.0637C17.5245 17.7672 17.7672 17.5245 18.0637 17.5245H19.1961V4.47549H18.0637C17.7672 4.47549 17.5245 4.23284 17.5245 3.93627V2.80392H4.47549V3.93627C4.47549 4.23284 4.23284 4.47549 3.93627 4.47549H2.80392V17.5245H3.93627C4.23284 17.5245 4.47549 17.7672 4.47549 18.0637ZM1.07843 18.6029V20.9216H3.39706V18.6029H1.07843ZM3.39706 3.39706V1.07843H1.07843V3.39706H3.39706Z"
                                                fill="white" />
                                        </svg>

                                    </span>
                                    <div class="tg-chose-list-content">
                                        <h4 class="tg-chose-list-title mb-5">Reach Airport on Selected Date</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Urna, tortor tempus.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="tg-chose-right">
                            <img src="images/home/advance.png" alt="image">
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
                                        <span>What is included in the cruise package?</span>
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
                                        <span>What should I pack for the cruise?</span>
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
                                        <span>What happens if the cruise is cancelled?</span>
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
                                        <span>Do I need a visa to join the cruise?</span>
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
                                        <span>What safety measures are in place on board?</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="common-section NewsLettert-section d-none">
            <div class="container">
                <div class="NewsLettert-InnConBox">
                    <div class="NewsLettert-bg">
                        <img src="images/home/header-image-2-1.jpg" alt="" class="img-fluid">
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-10 col-md-12 col-sm-12 col-12">
                            <div class="common-box NewsLettert-TitleBox">
                                <span class="common-SubTitle">stay in the loop</span>
                                <div class="section-header text-center">
                                    <h2 class="mb-2">sign up to receive our <span
                                            class="text-primary text-primarysec text-decoration-underline">emails and
                                            enjoy 15% off</span>
                                        your first
                                        order.</h2>
                                </div>
                                <form action="" class="NewsLettert-form">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Your email here">
                                        <button type="button" class="btn common-bgBtn"><span>get started</span></button>
                                    </div>
                                </form>
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
                            <h2 class="mb-2">Where Does <span
                                    class="text-primary text-primarysec text-decoration-underline">Your
                                    Heart</span>
                                Wish To Wander?</h2>
                            <p class="sub-title">DreamsTour, a tour operator specializing in dream destinations, offers
                                a variety of
                                benefits for travelers.</p>
                        </div>
                    </div>
                </div>

                <div class="owl-carousel custom-testimonial-carousel">
                    <!-- Testimonial 1 -->
                    <div class="testimonial-box">
                        <h4>Hidden Treasure</h4>
                        <p>I went on the Gone with the Wind tour, and it was my first multi-day bus tour. The experience
                            was
                            terrific, thanks to the friendly tour guides.</p>
                        <div class="testimonial-footer">
                            <img src="https://i.pravatar.cc/50?img=10" alt="User 1">
                            <div>
                                <strong>Bryan Bradfield</strong><br>
                                <small>Cape Town, South Africa</small>
                            </div>
                            <span class="rating-badge">5.0</span>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="testimonial-box">
                        <h4>Easy to Find your Leisuree Place</h4>
                        <p>Thanks for arranging a smooth travel experience for us. Our cab driver was polite, timely,
                            and
                            helpful.
                            The team ensured making it a stress-free trip.</p>
                        <div class="testimonial-footer">
                            <img src="https://i.pravatar.cc/50?img=11" alt="User 2">
                            <div>
                                <strong>Prajakta Sasane</strong><br>
                                <small>Paris, France</small>
                            </div>
                            <span class="rating-badge">5.0</span>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="testimonial-box">
                        <h4>Great Service</h4>
                        <p>We had a fantastic time as a family. There were activities for every age group, and the kids
                            loved
                            the
                            kids’ club, fun activities, good customer service.</p>
                        <div class="testimonial-footer">
                            <img src="https://i.pravatar.cc/50?img=12" alt="User 3">
                            <div>
                                <strong>James Andrew</strong><br>
                                <small>Newyork, United States</small>
                            </div>
                            <span class="rating-badge">5.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </DefaultLayout>
</template>
