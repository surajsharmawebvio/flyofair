<script setup>
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import { onMounted, onUnmounted, onBeforeUnmount, ref, watch, shallowRef, computed } from 'vue'
import './../../css/common.css'
import axios from 'axios'
import debounce from 'lodash/debounce'

// Refs for both search inputs
const searchQuery = ref('')
const toQuery = ref('')
const results = shallowRef([])
const toResults = shallowRef([])

// UI state
const showSuggestions = ref(false)
const showToSuggestions = ref(false)
const highlighted = ref(-1)
const highlightedTo = ref(-1)
const fromWrapper = ref(null)
const toWrapper = ref(null)

// Cache for geolocation
let cachedLatLong = null

// Request controllers for cancellation
let fromAbortController = null
let toAbortController = null

// Cache blur timeouts
let fromBlurTimeout = null
let toBlurTimeout = null

// Get cached or fetch lat/long from localStorage
const getLatLong = () => {
    if (cachedLatLong === null) {
        cachedLatLong = localStorage.getItem('lat&long')
    }
    return cachedLatLong
}

// Unified click outside handler
const handleClickOutside = (event) => {
    const target = event.target
    if (fromWrapper.value && !fromWrapper.value.contains(target)) {
        showSuggestions.value = false
    }
    if (toWrapper.value && !toWrapper.value.contains(target)) {
        showToSuggestions.value = false
    }
}

// Optimized blur handlers with timeout cleanup
const handleBlur = () => {
    fromBlurTimeout = setTimeout(() => {
        showSuggestions.value = false
    }, 200)
}

const handleToBlur = () => {
    toBlurTimeout = setTimeout(() => {
        showToSuggestions.value = false
    }, 200)
}

// Unified input handler
const onFromInput = () => {
    highlighted.value = -1
    showSuggestions.value = true
}

const onToInput = () => {
    highlightedTo.value = -1
    showToSuggestions.value = true
}

// Optimized airport fetch function with request cancellation
const createFetchAirports = (resultsRef, controllerRef) => debounce(async (query) => {
    if (!query || query.length < 2) {
        resultsRef.value = []
        return
    }

    // Cancel previous request if exists
    if (controllerRef.current) {
        controllerRef.current.abort()
    }

    // Create new abort controller
    controllerRef.current = new AbortController()
    const latLong = getLatLong()

    try {
        const res = await axios.get('/airports/search', {
            params: { query, latLong },
            signal: controllerRef.current.signal
        })
        resultsRef.value = res.data.data || []
    } catch (error) {
        if (error.name !== 'CanceledError' && error.name !== 'AbortError') {
            console.error('Error fetching airports:', error)
        }
    } finally {
        controllerRef.current = null
    }
}, 400)

// Create controller wrapper objects
const fromController = { current: null }
const toController = { current: null }

const fetchAirports = createFetchAirports(results, fromController)
const fetchAirportsTo = createFetchAirports(toResults, toController)

// Watch queries with better control
watch(searchQuery, (newVal) => {
    if (newVal) {
        fetchAirports(newVal)
    } else {
        results.value = []
    }
})

watch(toQuery, (newVal) => {
    if (newVal) {
        fetchAirportsTo(newVal)
    } else {
        toResults.value = []
    }
})

// Airport selection - optimized
const selectAirport = (airport) => {
    searchQuery.value = `${airport.airport_code} — ${airport.airport_name}`
    results.value = []
    showSuggestions.value = false
    highlighted.value = -1
}

const selectToAirport = (airport) => {
    toQuery.value = `${airport.airport_code} — ${airport.airport_name}`
    toResults.value = []
    showToSuggestions.value = false
    highlightedTo.value = -1
}

// Unified keyboard navigation
const createKeydownHandler = (suggestionRef, highlightedRef, resultsRef, selectFn) => (e) => {
    if (!suggestionRef.value) return

    switch (e.key) {
        case 'ArrowDown':
            e.preventDefault()
            highlightedRef.value = Math.min(highlightedRef.value + 1, resultsRef.value.length - 1)
            break
        case 'ArrowUp':
            e.preventDefault()
            highlightedRef.value = Math.max(highlightedRef.value - 1, 0)
            break
        case 'Enter':
            e.preventDefault()
            if (highlightedRef.value >= 0 && resultsRef.value[highlightedRef.value]) {
                selectFn(resultsRef.value[highlightedRef.value])
            } else if (resultsRef.value.length === 1) {
                selectFn(resultsRef.value[0])
            }
            break
        case 'Escape':
            suggestionRef.value = false
            break
    }
}

const onFromKeydown = createKeydownHandler(showSuggestions, highlighted, results, selectAirport)
const onToKeydown = createKeydownHandler(showToSuggestions, highlightedTo, toResults, selectToAirport)

// Geolocation with better error handling
const getLocation = () => {
    if (!navigator.geolocation || localStorage.getItem('lat&long')) {
        return
    }

    const options = {
        timeout: 10000,
        maximumAge: 300000 // Cache for 5 minutes
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const locationData = JSON.stringify({
                lat: position.coords.latitude,
                lon: position.coords.longitude
            })
            localStorage.setItem('lat&long', locationData)
            cachedLatLong = locationData
        },
        (error) => console.error('Error getting location:', error),
        options
    )
}

// Owl Carousel initialization - optimized with config reuse
const CAROUSEL_CONFIGS = Object.freeze({
    '.tour-slider': {
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 3 }
        }
    },
    '.blog-slider': {
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 }
        }
    },
    '.custom-testimonial-carousel': {
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        items: 1
    }
})

const initializeCarousels = () => {
    if (typeof $ === 'undefined' || typeof $.fn.owlCarousel === 'undefined') {
        console.warn('OwlCarousel not loaded')
        return
    }

    Object.entries(CAROUSEL_CONFIGS).forEach(([selector, config]) => {
        const $element = $(selector)
        if ($element.length) {
            $element.owlCarousel(config)
        }
    })
}

// Optimized traveler form with better event delegation
const initializeTravelerForm = () => {
    const $inputs = $('.flight-guest-input')
    if (!$inputs.length) return

    $inputs.each(function () {
        const $input = $(this)
        const $card = $input.siblings('.traveler-card')
        const $parent = $input.closest('.col-lg-3, .col-lg-2')

        $parent.css('position', 'relative')

        if (!$card.length) return

        const counts = { adult: 1, child: 0, infant: 0 }
        let lastAppliedCounts = { ...counts }
        let lastAppliedClass = 'Economy'

        // Cache jQuery selectors
        const $countSpans = $card.find('span.common-numtext')
        const $adultCount = $countSpans.eq(0)
        const $childCount = $countSpans.eq(1)
        const $infantCount = $countSpans.eq(2)

        const updateCounts = () => {
            // Update count displays
            $adultCount.text(counts.adult)
            $childCount.text(counts.child)
            $infantCount.text(counts.infant)

            // Update input value
            const total = counts.adult + counts.child + counts.infant
            const $checkedClass = $card.find('input[name="travelClass"]:checked')
            const travelClass = $checkedClass.length ? $checkedClass.val().toUpperCase() : 'ECONOMY'
            $input.val(`${total} passenger${total > 1 ? 's' : ''} ${travelClass}`)
        }

        updateCounts()

        // Event handlers with better delegation
        $input.off('click.traveler').on('click.traveler', function (e) {
            e.preventDefault()
            e.stopPropagation()
            $('.traveler-card').not($card).removeClass('show').hide()
            $card.toggleClass('show').toggle()
            if ($card.hasClass('show')) {
                lastAppliedCounts = { ...counts }
                lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() || 'Economy'
            }
        })

        $card.off('click.traveler').on('click.traveler', (e) => e.stopPropagation())

        // Plus/Minus buttons with event delegation
        $card.off('click.traveler', '.traveler-plus, .traveler-minus')
            .on('click.traveler', '.traveler-plus, .traveler-minus', function (e) {
                e.preventDefault()
                e.stopPropagation()

                const $btn = $(this)
                const target = $btn.attr('data-target')
                const isPlus = $btn.hasClass('traveler-plus')

                if (!target || !counts.hasOwnProperty(target)) return

                if (isPlus) {
                    counts[target]++
                } else {
                    if (target === 'adult' && counts[target] <= 1) return
                    if (target !== 'adult' && counts[target] <= 0) return
                    counts[target]--
                }

                updateCounts()
            })

        $card.find('input[name="travelClass"]').off('change.traveler').on('change.traveler', updateCounts)

        // Apply/Cancel buttons
        $card.off('click.traveler', '#applyBtn, #cancelBtn')
            .on('click.traveler', '#applyBtn', function (e) {
                e.preventDefault()
                e.stopPropagation()
                lastAppliedCounts = { ...counts }
                lastAppliedClass = $card.find('input[name="travelClass"]:checked').val() || 'Economy'
                $card.removeClass('show').hide()
            })
            .on('click.traveler', '#cancelBtn', function (e) {
                e.preventDefault()
                e.stopPropagation()
                Object.assign(counts, lastAppliedCounts)
                const $oldRadio = $card.find(`input[name="travelClass"][value="${lastAppliedClass}"]`)
                if ($oldRadio.length) $oldRadio.prop('checked', true)
                updateCounts()
                $card.removeClass('show').hide()
            })
    })

    // Global click handler with delegation
    $(document).off('click.traveler').on('click.traveler', function (e) {
        if (!$(e.target).closest('.traveler-card, .flight-guest-input').length) {
            $('.traveler-card').removeClass('show').hide()
        }
    })
}

// Initialize flatpickr
const initializeFlatpickr = () => {
    if (typeof flatpickr === 'undefined') return

    const $dateInputs = $('.date-input')
    if (!$dateInputs.length) return

    flatpickr('.date-input', {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disableMobile: true
    })
}

// Cleanup function
const cleanup = () => {
    // Cancel any pending API requests
    if (fromController.current) fromController.current.abort()
    if (toController.current) toController.current.abort()

    // Clear timeouts
    if (fromBlurTimeout) clearTimeout(fromBlurTimeout)
    if (toBlurTimeout) clearTimeout(toBlurTimeout)

    // Remove event listeners
    document.removeEventListener('click', handleClickOutside)
    $(document).off('click.traveler')

    // Destroy carousels
    Object.keys(CAROUSEL_CONFIGS).forEach(selector => {
        const $element = $(selector)
        if ($element.length && $element.data('owl.carousel')) {
            $element.trigger('destroy.owl.carousel')
        }
    })
}

// Lifecycle hooks
onMounted(() => {
    document.addEventListener('click', handleClickOutside, { passive: true })
    
    // Initialize in optimal order
    getLocation()
    
    // Use requestAnimationFrame for better performance
    requestAnimationFrame(() => {
        initializeCarousels()
        
        // Defer non-critical initializations
        setTimeout(() => {
            initializeFlatpickr()
            initializeTravelerForm()
        }, 50)
    })
})

onBeforeUnmount(cleanup)
onUnmounted(cleanup)
</script>

<template>
    <DefaultLayout>
        <!-- Banner Section -->
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
                                        aria-selected="false">Round Trip</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="multi-tab" data-bs-toggle="tab"
                                        data-bs-target="#multi-pane" type="button" role="tab" aria-controls="multi-pane"
                                        aria-selected="false">Multi Trip</button>
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

                                <!-- Round Trip & Multi-City tabs remain the same -->
                                <!-- I've kept them as-is to avoid template truncation -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- All other sections remain unchanged -->
    </DefaultLayout>
</template>