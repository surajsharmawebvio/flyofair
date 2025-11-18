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
    import Swal from 'sweetalert2';
    import { Head } from '@inertiajs/vue3';

    const API_BASE_URL = 'https://development.theinfinitytravel.com/api/v1/all/airport-list?input='

    // Country codes data
    const countryCodes = ref([
        { code: '+1', country: 'US', name: 'United States', flag: '🇺🇸' },
        { code: '+1', country: 'CA', name: 'Canada', flag: '🇨🇦' },
        { code: '+44', country: 'GB', name: 'United Kingdom', flag: '🇬🇧' },
        { code: '+91', country: 'IN', name: 'India', flag: '🇮🇳' },
        { code: '+86', country: 'CN', name: 'China', flag: '🇨🇳' },
        { code: '+81', country: 'JP', name: 'Japan', flag: '🇯🇵' },
        { code: '+49', country: 'DE', name: 'Germany', flag: '🇩🇪' },
        { code: '+33', country: 'FR', name: 'France', flag: '🇫🇷' },
        { code: '+39', country: 'IT', name: 'Italy', flag: '🇮🇹' },
        { code: '+34', country: 'ES', name: 'Spain', flag: '🇪🇸' },
        { code: '+61', country: 'AU', name: 'Australia', flag: '🇦🇺' },
        { code: '+55', country: 'BR', name: 'Brazil', flag: '🇧🇷' },
        { code: '+52', country: 'MX', name: 'Mexico', flag: '🇲🇽' },
        { code: '+7', country: 'RU', name: 'Russia', flag: '🇷🇺' },
        { code: '+82', country: 'KR', name: 'South Korea', flag: '🇰🇷' },
        { code: '+971', country: 'AE', name: 'UAE', flag: '🇦🇪' },
        { code: '+966', country: 'SA', name: 'Saudi Arabia', flag: '🇸🇦' },
        { code: '+65', country: 'SG', name: 'Singapore', flag: '🇸🇬' },
        { code: '+27', country: 'ZA', name: 'South Africa', flag: '🇿🇦' },
        { code: '+234', country: 'NG', name: 'Nigeria', flag: '🇳🇬' },
    ]);
    const selectedCountryCode = ref('+1');

    // Detect country by IP
    async function detectCountryByIP() {
        try {
            const response = await axios.get('https://ipapi.co/json/', {
                withCredentials: false,
                headers: {
                    'Accept': 'application/json'
                },
                transformRequest: [(data, headers) => {
                    // Remove CSRF token and other Laravel headers
                    delete headers['X-CSRF-TOKEN'];
                    delete headers['X-Requested-With'];
                    return data;
                }]
            });
            const countryCode = response.data.country_code;
            
            // Find matching country code
            const country = countryCodes.value.find(c => c.country === countryCode);
            if (country) {
                selectedCountryCode.value = country.code;
            }
        } catch (error) {
            console.error('Error detecting country:', error);
            // Default to +1 if detection fails
            selectedCountryCode.value = '+1';
        }
    }

    // Common function for airport search
    async function searchAirports(query, resultsSetter) {
        if (!query) {
            resultsSetter([])
            return
        }

        const latLong = JSON.parse(localStorage.getItem('lat&long') || '{}')
        const {
            lat,
            lng
        } = latLong

        let url = API_BASE_URL

        if (typeof query === 'string') {
            url = url.replace('input=', `input=${encodeURIComponent(query)}`)
        } else if (lat && lng) {
            url = url.replace('input=', `lat=${lat}&lng=${lng}`)
        }

        try {
            const res = await axios.get(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                withCredentials: false,
            })
            resultsSetter(res.data.data || res.data || [])
        } catch (error) {
            console.error('Error fetching airports:', error)
        }
    }

    // --- From search input handling ---
    const showSuggestions = ref(false);
    const highlighted = ref(-1);
    const fromWrapper = ref(null);
    const searchQuery = ref('');
    const results = ref([]);

    // Handle clicks outside the dropdown (both From and To)
    function handleClickOutside(event) {
        const target = event.target;
        if (fromWrapper.value && !fromWrapper.value.contains(target)) {
            showSuggestions.value = false;
        }
        if (toWrapper.value && !toWrapper.value.contains(target)) {
            showToSuggestions.value = false;
        }
        // multi-city wrappers
        if (multiFromWrapper && multiFromWrapper.value && !multiFromWrapper.value.contains(target)) {
            showMultiFromSuggestions.value = false;
        }
        if (multiToWrapper && multiToWrapper.value && !multiToWrapper.value.contains(target)) {
            showMultiToSuggestions.value = false;
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

    function onFromInput(e) {
        highlighted.value = -1;
        showSuggestions.value = true;
        // Make sure search query triggers the watcher
        searchQuery.value = e.target.value;
    }

    // --- To results (separate list) ---
    const toResults = ref([])

    const fetchAirports = debounce((query) => searchAirports(query, airportResults => {
        results.value = airportResults;
        console.log('Updated results:', results.value);
    }), 400)

    // 👇 Watcher (same as before)
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
    const fetchAirportsTo = debounce((query) => searchAirports(query, results => toResults.value = results), 400)

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

    // --- Round Trip From search handling ---
    const roundFromQuery = ref('');
    const roundFromResults = ref([]);
    const showRoundFromSuggestions = ref(false);
    const highlightedRoundFrom = ref(-1);
    const roundFromWrapper = ref(null);

    const fetchRoundFromAirports = debounce((query) => searchAirports(query, results => roundFromResults.value =
        results), 400)

    watch(roundFromQuery, (newVal) => {
        fetchRoundFromAirports(newVal)
    })

    function onRoundFromInput() {
        highlightedRoundFrom.value = -1;
        showRoundFromSuggestions.value = true;
    }

    function handleRoundFromBlur() {
        setTimeout(() => {
            showRoundFromSuggestions.value = false;
        }, 200);
    }

    function selectRoundFromAirport(airport) {
        roundFromQuery.value = `${airport.airport_code} — ${airport.airport_name}`;
        roundFromResults.value = [];
        showRoundFromSuggestions.value = false;
    }

    function onRoundFromKeydown(e) {
        if (!showRoundFromSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedRoundFrom.value = Math.min(highlightedRoundFrom.value + 1, roundFromResults.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedRoundFrom.value = Math.max(highlightedRoundFrom.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedRoundFrom.value >= 0 && roundFromResults.value[highlightedRoundFrom.value]) {
                selectRoundFromAirport(roundFromResults.value[highlightedRoundFrom.value]);
            } else if (roundFromResults.value.length === 1) {
                selectRoundFromAirport(roundFromResults.value[0]);
            }
        } else if (e.key === 'Escape') {
            showRoundFromSuggestions.value = false;
        }
    }

    // --- Round Trip To search handling ---
    const roundToQuery = ref('');
    const roundToResults = ref([]);
    const showRoundToSuggestions = ref(false);
    const highlightedRoundTo = ref(-1);
    const roundToWrapper = ref(null);

    // --- Multi Trip From search handling ---
    const multiFromQuery = ref('');
    const multiFromResults = ref([]);
    const showMultiFromSuggestions = ref(false);
    const highlightedMultiFrom = ref(-1);
    const multiFromWrapper = ref(null);

    // --- Multi Trip To search handling ---
    const multiToQuery = ref('');
    const multiToResults = ref([]);
    const showMultiToSuggestions = ref(false);
    const highlightedMultiTo = ref(-1);
    const multiToWrapper = ref(null);

    const fetchRoundToAirports = debounce((query) => searchAirports(query, results => roundToResults.value = results),
        400)

    watch(roundToQuery, (newVal) => {
        fetchRoundToAirports(newVal)
    })

    function onRoundToInput() {
        highlightedRoundTo.value = -1;
        showRoundToSuggestions.value = true;
    }

    function handleRoundToBlur() {
        setTimeout(() => {
            showRoundToSuggestions.value = false;
        }, 200);
    }

    function selectRoundToAirport(airport) {
        roundToQuery.value = `${airport.airport_code} — ${airport.airport_name}`;
        roundToResults.value = [];
        showRoundToSuggestions.value = false;
    }

    function onRoundToKeydown(e) {
        if (!showRoundToSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedRoundTo.value = Math.min(highlightedRoundTo.value + 1, roundToResults.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedRoundTo.value = Math.max(highlightedRoundTo.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedRoundTo.value >= 0 && roundToResults.value[highlightedRoundTo.value]) {
                selectRoundToAirport(roundToResults.value[highlightedRoundTo.value]);
            } else if (roundToResults.value.length === 1) {
                selectRoundToAirport(roundToResults.value[0]);
            }
        } else if (e.key === 'Escape') {
            showRoundToSuggestions.value = false;
        }
    }

    // --- Multi Trip functions (reuse searchAirports) ---
    const fetchMultiFromAirports = debounce((query) => searchAirports(query, results => multiFromResults.value =
        results), 400)
    const fetchMultiToAirports = debounce((query) => searchAirports(query, results => multiToResults.value = results),
        400)

    watch(multiFromQuery, (newVal) => {
        fetchMultiFromAirports(newVal)
    })

    watch(multiToQuery, (newVal) => {
        fetchMultiToAirports(newVal)
    })

    function onMultiFromInput() {
        highlightedMultiFrom.value = -1;
        showMultiFromSuggestions.value = true;
        // ensure the value propagates for watcher
        // (if using event target like other handlers, but here we use v-model)
    }

    function onMultiToInput() {
        highlightedMultiTo.value = -1;
        showMultiToSuggestions.value = true;
    }

    function handleMultiFromBlur() {
        setTimeout(() => {
            showMultiFromSuggestions.value = false;
        }, 200);
    }

    function handleMultiToBlur() {
        setTimeout(() => {
            showMultiToSuggestions.value = false;
        }, 200);
    }

    function selectMultiFromAirport(airport) {
        multiFromQuery.value = `${airport.airport_code} — ${airport.airport_name}`;
        multiFromResults.value = [];
        showMultiFromSuggestions.value = false;
    }

    function selectMultiToAirport(airport) {
        multiToQuery.value = `${airport.airport_code} — ${airport.airport_name}`;
        multiToResults.value = [];
        showMultiToSuggestions.value = false;
    }

    function onMultiFromKeydown(e) {
        if (!showMultiFromSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedMultiFrom.value = Math.min(highlightedMultiFrom.value + 1, multiFromResults.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedMultiFrom.value = Math.max(highlightedMultiFrom.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedMultiFrom.value >= 0 && multiFromResults.value[highlightedMultiFrom.value]) {
                selectMultiFromAirport(multiFromResults.value[highlightedMultiFrom.value]);
            } else if (multiFromResults.value.length === 1) {
                selectMultiFromAirport(multiFromResults.value[0]);
            }
        } else if (e.key === 'Escape') {
            showMultiFromSuggestions.value = false;
        }
    }

    function onMultiToKeydown(e) {
        if (!showMultiToSuggestions.value) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedMultiTo.value = Math.min(highlightedMultiTo.value + 1, multiToResults.value.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedMultiTo.value = Math.max(highlightedMultiTo.value - 1, 0);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedMultiTo.value >= 0 && multiToResults.value[highlightedMultiTo.value]) {
                selectMultiToAirport(multiToResults.value[highlightedMultiTo.value]);
            } else if (multiToResults.value.length === 1) {
                selectMultiToAirport(multiToResults.value[0]);
            }
        } else if (e.key === 'Escape') {
            showMultiToSuggestions.value = false;
        }
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

    const handleFormSubmit = (event) => {
        event.preventDefault();
        const form = event.target;
        const tripType = form.querySelector('input[name="tripType"]').value;

        // Common form data for all trip types
        const formData = {
            tripType,
            email: form.querySelector('input[placeholder="Enter email"]').value,
            phone: selectedCountryCode.value + ' ' + form.querySelector('input[placeholder="Phone Number"]').value,
            travelerInfo: form.querySelector('.flight-guest-input').value
        };

        // Add specific fields based on trip type
        if (tripType === 'oneway') {
            formData.from = searchQuery.value;
            formData.to = toQuery.value;
            formData.departureDate = form.querySelector('#Departure1').value;
        } else if (tripType === 'round') {
            formData.from = roundFromQuery.value;
            formData.to = roundToQuery.value;
            formData.departureDate = form.querySelector('#Departure').value;
            formData.returnDate = form.querySelector('#Return').value;
        } else if (tripType === 'multi') {
            // Handle multi-city trips
            const flightRows = form.querySelectorAll('.flight-row');
            formData.trips = Array.from(flightRows).map(row => ({
                from: row.querySelector('input[placeholder="Add departure"]').value,
                to: row.querySelector('input[placeholder="Add arrival"]').value,
                date: row.querySelector('.date-input').value
            }));
        }

        // Make API call with formData
        const token = document.head.querySelector('meta[name="csrf-token"]')
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
        if (token) headers['X-CSRF-TOKEN'] = token.content

        axios.post('/api/get-quote', formData, { headers })
            .then(response => {
                console.log('Quote request successful:', response.data);
                const message = response.data.message || 'Quote request sent successfully.';
                Swal.fire({
                    icon: 'success',
                    title: 'Sent',
                    text: message,
                    confirmButtonText: 'OK'
                });
                // Optionally clear fields after success
                // form.reset();
            })
            .catch(error => {
                console.error('Error submitting quote request:', error);
                let errMsg = 'Failed to send quote request.';
                if (error.response && error.response.data) {
                    if (error.response.data.message) errMsg = error.response.data.message;
                    else if (error.response.data.errors) errMsg = Object.values(error.response.data.errors)
                        .flat().join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errMsg,
                    confirmButtonText: 'OK'
                });
            });

        // console.log('Submitting flight search:', formData);
    };

    onMounted(() => {
        // Detect country by IP on mount
        detectCountryByIP();
        
        // Add click handler for popup button
        document.addEventListener('click', (e) => {
            if (e.target.id === 'popup' || e.target.closest('#popup')) {
                openPopup();
            }
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
                    disableMobile: true,
                });
            }

            // Initialize traveler form functionality
            initializeTravelerForm();
        }, 100);

        document.querySelectorAll(".accordion-button").forEach((button) => {
            const icon = button.querySelector(".icon");
            const collapseTargetId = button.getAttribute("data-bs-target");
            const collapseElement = document.querySelector(collapseTargetId);

            // When accordion is fully shown
            collapseElement.addEventListener("shown.bs.collapse", () => {
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            });

            // When accordion is fully hidden
            collapseElement.addEventListener("hidden.bs.collapse", () => {
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            });
        });

        function initFlatpickr(container) {
            if (typeof flatpickr !== "undefined") {
                container.find(".date-input").each(function () {
                    if (this._flatpickr) this._flatpickr.destroy();
                    flatpickr(this, {
                        altInput: true,
                        altFormat: "F j, Y",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disableMobile: true,
                    });
                });
            }
        }

        function toggleClearButton() {
            $(".tab-pane").each(function () {
                const pane = $(this);
                const rowCount = pane.find(".flight-form-fields .flight-row").length;
                // Show Clear All only if more than 1 row exists
                pane.find(".cancelBtnnew").toggle(rowCount > 1);
            });
        }

        const newRowTemplate = (isFirst = false) => `
            <div class="flight-row row g-3 mb-0 mt-2">
            ${
                isFirst
                ? `
            <div class="mobtravel-list-diveder">
                <span class="mob-diverder">
                ** -------------- Trip list-------------- **
                </span>
            </div>`
                : ""
            }
            <div class="col-lg-4 col-md-4 col-12">
                <label class="form-label search-label">Departure from</label>
                <input type="text" class="form-control flight-input" placeholder="Add departure">
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <label class="form-label search-label">Arrive at</label>
                <input type="text" class="form-control flight-input" placeholder="Add arrival">
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <label class="form-label search-label">Departure date</label>
                <input type="text" class="form-control date-input flight-input" placeholder="Departure date" readonly>
            </div>
            <div class="col-lg-1 col-md-1">
                <a href="#" class="linkbtn cancelthisBtnnew cancelBtn">
                <i class="fa-solid fa-trash-can"></i>
                </a>
            </div>
            </div>`;

        // Attach autocomplete to a newly created jQuery row (departure/arrival inputs)
        function attachAutocompleteToRow($row) {
            const $from = $row.find('input[placeholder="Add departure"]');
            const $to = $row.find('input[placeholder="Add arrival"]');

            [$from, $to].forEach(function ($input) {
                if (!$input || !$input.length) return;
                const $wrapper = $input.parent();
                $wrapper.css('position', 'relative');

                const $list = $('<ul class="list-group position-absolute shadow" ' +
                    'style="width:100%; max-height:220px; z-index:1050; display:none;"></ul>');
                $wrapper.append($list);

                const debouncedSearch = debounce(function (query) {
                    if (!query) {
                        $list.empty().hide();
                        return;
                    }
                    // reuse searchAirports which accepts (query, resultsSetter)
                    searchAirports(query, function (results) {
                        $list.empty();
                        if (!results || results.length === 0) {
                            $list.hide();
                            return;
                        }
                        results.forEach(function (airport) {
                            const $li = $(
                                '<li class="list-group-item" style="cursor:pointer;"><strong>' +
                                airport.airport_code + '</strong> — ' +
                                airport.airport_name + '</li>'
                            );
                            $li.on('mousedown', function (e) {
                                e.preventDefault();
                                $input.val(airport.airport_code +
                                    ' — ' + airport.airport_name);
                                $list.empty().hide();
                            });
                            $list.append($li);
                        });
                        $list.show();
                    });
                }, 400);

                $input.on('input', function () {
                    debouncedSearch($input.val());
                });

                $input.on('keydown', function (e) {
                    const $items = $list.find('li');
                    if (!$items.length) return;
                    let idx = $items.index($items.filter('.active'));
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        idx = Math.min(idx + 1, $items.length - 1);
                        $items.removeClass('active');
                        $items.eq(idx).addClass('active');
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        idx = Math.max(idx - 1, 0);
                        $items.removeClass('active');
                        $items.eq(idx).addClass('active');
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (idx >= 0 && $items.length) {
                            $items.eq(idx).trigger('mousedown');
                        } else if ($items.length === 1) {
                            $items.eq(0).trigger('mousedown');
                        }
                    } else if (e.key === 'Escape') {
                        $list.hide();
                    }
                });

                $input.on('blur', function () {
                    setTimeout(function () {
                        $list.hide();
                    }, 200);
                });

                $input.on('focus', function () {
                    if ($list.children().length) $list.show();
                });
            });
        }

        $(".applyBtnnew").on("click", function (e) {
            e.preventDefault();
            const activeTab = $(".tab-pane.active");
            const fieldContainer = activeTab.find(".flight-form-fields");
            const totalRows = fieldContainer.find(".flight-row").length;

            if (totalRows >= 5) {
                alert("You can add a maximum of 5 trips.");
                return;
            }

            const newRow = $(newRowTemplate(totalRows === 0)); // divider only for first row
            fieldContainer.append(newRow);

            initFlatpickr(newRow);
            // attach autocomplete to inputs in the newly appended row
            attachAutocompleteToRow(newRow);
            toggleClearButton();
        });

        // Attach autocomplete to any existing rows on page load (multi-pane)
        $('#multi-pane .flight-form-fields .flight-row').each(function () {
            attachAutocompleteToRow($(this));
        });
    });

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
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 3
                    }
                }
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
                        lastAppliedClass = $card.find('input[name="travelClass"]:checked')
                            .val() ||
                            'Economy';
                    });

                    // Prevent card from closing when clicking inside
                    $card.off('click.traveler').on('click.traveler', function (e) {
                        e.stopPropagation();
                    });

                    // Increment buttons
                    $card.find('.traveler-plus').off('click.traveler').on('click.traveler', function (
                        e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const target = $(this).attr('data-target');
                        if (target && counts.hasOwnProperty(target)) {
                            counts[target]++;
                            updateCounts();
                        }
                    });

                    // Decrement buttons
                    $card.find('.traveler-minus').off('click.traveler').on('click.traveler', function (
                        e) {
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
                        lastAppliedClass = $card.find('input[name="travelClass"]:checked')
                            .val() ||
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

    }

</script>

<template>
    <Head>
        <title>FlyOFair | Airlines Flight Booking With 24/7 Assistance</title>
        <meta name="description" content="FlyOFair is a one-stop portal for travellers seeking assistance with flight bookings, cancellations, refunds, name changes, and more. Call +1-877-238-0219 now." />
        <link rel="canonical" href="https://www.flyofair.com/" />
    </Head>
    <DefaultLayout>
        <section class="bannersection">
            <div class="bannerbgsec">
                <img src="images/banner.png" alt="" />
            </div>

            <div class="flight-texture">
                <img src="images/about-loaction.png" alt="" />
            </div>
            <div class="container">
                <div class="row justify-content-start align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-box">
                            <h1 class="bannertitle">The sky isn't the limit, <span> it's just the beginning.</span>
                            </h1>
                            <div class="banner-para">
                                <p>With FlyOFair, take your dreams to the sky and bring back moments that will stay in
                                    your heart forever!</p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="banner-image text-center">
                            <img src="images/hero-man.webp" alt="banner image" />
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
                                    <form @submit="handleFormSubmit" class="row g-3 align-items-end flight-form-fields">
                                        <input type="hidden" name="tripType" value="oneway" />
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Email</label>
                                            <input type="text" class="form-control flight-input"
                                                placeholder="Enter email" />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Phone</label>
                                            <div class="input-group">
                                                <select v-model="selectedCountryCode" class="form-select" style="max-width: 100px;">
                                                    <option v-for="country in countryCodes" :key="country.country + country.code" :value="country.code">
                                                        {{ country.flag }} {{ country.code }}
                                                    </option>
                                                </select>
                                                <input type="tel" class="form-control" placeholder="Phone Number"
                                                    name="phone" />
                                            </div>
                                        </div>
                                        <div ref="fromWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">From</label>
                                            <input v-model="searchQuery" @input="onFromInput" @keydown="onFromKeydown"
                                                @focus="showSuggestions = true" @blur="handleBlur" type="text"
                                                class="form-control flight-input" placeholder="Add departure"
                                                id="flight-search-from" autocomplete="off">

                                            <!-- Suggestions dropdown -->
                                            <ul v-if="showSuggestions && results.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in results" :key="index"
                                                    class="list-group-item" style="cursor:pointer;"
                                                    @mousedown.prevent="selectAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> —
                                                    {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div ref="toWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">To</label>
                                            <input v-model="toQuery" @input="onToInput" @keydown="onToKeydown"
                                                @focus="showToSuggestions = true" @blur="handleToBlur" type="text"
                                                class="form-control flight-input" placeholder="Add destination"
                                                id="flight-search-to" autocomplete="off">

                                            <!-- To Suggestions dropdown -->
                                            <ul v-if="showToSuggestions && toResults.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in toResults" :key="index"
                                                    class="list-group-item" style="cursor:pointer;"
                                                    @mousedown.prevent="selectToAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> —
                                                    {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Departure date</label>
                                            <input id="Departure1" type="text" class="date-input flight-input"
                                                placeholder="Departure date" readonly />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Guests</label>
                                            <input readonly class="form-control flight-guest-input flight-input"
                                                placeholder="1 passenger ECONOMY" id="travelerInput" />
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
                                                                data-target="adult">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="adult">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Children (2-12 Yrs)</span>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="child">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="childCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="child">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center">
                                                        <span class="boldtext">Infants (0-2 Yrs)</span>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="infant">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="infant">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Class Selection -->
                                                <div class="mb-3 traveler-section">
                                                    <label class="fw-semibold d-block mb-2">Class</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="eco" value="Economy" checked />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="eco">Economy</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="prem" value="Premium Economy" />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="prem">Premium Economy</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="bus" value="Business" />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="bus">Business</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="first" value="First Class" />
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
                                        <div class="col-lg-2 d-grid col-12">
                                            <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Round Trip -->
                                <div class="tab-pane fade" id="round-pane" role="tabpanel">
                                    <form @submit="handleFormSubmit" class="row g-3 align-items-end flight-form-fields">
                                        <input type="hidden" name="tripType" value="round" />
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Email</label>
                                            <input type="text" class="form-control flight-input"
                                                placeholder="Enter email" />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Phone</label>
                                            <div class="input-group">
                                                <select v-model="selectedCountryCode" class="form-select" style="max-width: 100px;">
                                                    <option v-for="country in countryCodes" :key="country.country + country.code" :value="country.code">
                                                        {{ country.flag }} {{ country.code }} {{ country.name }}
                                                    </option>
                                                </select>
                                                <input type="tel" class="form-control" placeholder="Phone Number"
                                                    name="phone" />
                                            </div>
                                        </div>
                                        <div ref="roundFromWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">From</label>
                                            <input v-model="roundFromQuery" @input="onRoundFromInput"
                                                @keydown="onRoundFromKeydown" @focus="showRoundFromSuggestions = true"
                                                @blur="handleRoundFromBlur" type="text"
                                                class="form-control flight-input" placeholder="Add departure"
                                                autocomplete="off" />
                                            <ul v-if="showRoundFromSuggestions && roundFromResults.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in roundFromResults" :key="index"
                                                    class="list-group-item" style="cursor:pointer;"
                                                    @mousedown.prevent="selectRoundFromAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> —
                                                    {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div ref="roundToWrapper" class="col-lg-3 col-md-6 col-12"
                                            style="position: relative;">
                                            <label class="form-label search-label">To</label>
                                            <input v-model="roundToQuery" @input="onRoundToInput"
                                                @keydown="onRoundToKeydown" @focus="showRoundToSuggestions = true"
                                                @blur="handleRoundToBlur" type="text" class="form-control flight-input"
                                                placeholder="Add arrival" autocomplete="off" />
                                            <ul v-if="showRoundToSuggestions && roundToResults.length > 0"
                                                class="list-group position-absolute shadow"
                                                style="width:100%; max-height:220px; z-index:1050;">
                                                <li v-for="(airport, index) in roundToResults" :key="index"
                                                    class="list-group-item" style="cursor:pointer;"
                                                    @mousedown.prevent="selectRoundToAirport(airport)">
                                                    <strong>{{ airport.airport_code }}</strong> —
                                                    {{ airport.airport_name }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Departure date</label>
                                            <input id="Departure" type="text" class="date-input flight-input"
                                                placeholder="Departure date" readonly />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Return date</label>
                                            <input id="Return" type="text" class="date-input flight-input"
                                                placeholder="Return date" readonly />
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label search-label">Guests</label>
                                            <input type="text" readonly
                                                class="form-control flight-guest-input flight-input"
                                                placeholder="1 passenger ECONOMY" id="travelerInput" />
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
                                                                data-target="adult">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="adultCount" class="mx-2 common-numtext">1</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="adult">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center mb-2">
                                                        <span class="boldtext">Children (2-12 Yrs)</span>
                                                        <div class="d-flex">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="child">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="childCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="child">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="traveler-row d-flex justify-content-between align-items-center">
                                                        <span class="boldtext">Infants (0-2 Yrs)</span>
                                                        <div class="d-flex">
                                                            <button class="btn btn-light btn-sm traveler-minus"
                                                                data-target="infant">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <span id="infantCount" class="mx-2 common-numtext">0</span>
                                                            <button class="btn btn-light btn-sm traveler-plus"
                                                                data-target="infant">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Class Selection -->
                                                <div class="mb-3 traveler-section">
                                                    <label class="fw-semibold d-block mb-2">Class</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="eco" value="Economy" checked />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="eco">Economy</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="prem" value="Premium Economy" />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="prem">Premium Economy</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="bus" value="Business" />
                                                        <label class="form-check-label custome-form-check-label"
                                                            for="bus">Business</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input travel-class" type="radio"
                                                            name="travelClass" id="first" value="First Class" />
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
                                        <div class="col-lg-2 d-grid col-12">
                                            <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Multi-City -->
                                <div class="tab-pane fade" id="multi-pane" role="tabpanel">
                                    <form @submit="handleFormSubmit" class="">
                                        <input type="hidden" name="tripType" value="multi" />
                                        <div class="row g-3 align-items-end flight-form-fields">
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Email</label>
                                                <input type="text" class="form-control flight-input"
                                                    placeholder="Enter email" />
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Phone</label>
                                                <div class="input-group">
                                                    <select v-model="selectedCountryCode" class="form-select" style="max-width: 100px;">
                                                        <option v-for="country in countryCodes" :key="country.country + country.code" :value="country.code">
                                                            {{ country.flag }} {{ country.code }} {{ country.name }}
                                                        </option>
                                                    </select>
                                                    <input type="tel" class="form-control" placeholder="Phone Number"
                                                        name="phone" />
                                                </div>
                                            </div>
                                            <div ref="multiFromWrapper" class="col-lg-3 col-md-6 col-12"
                                                style="position: relative;">
                                                <label class="form-label search-label">From</label>
                                                <input v-model="multiFromQuery" @input="onMultiFromInput"
                                                    @keydown="onMultiFromKeydown"
                                                    @focus="showMultiFromSuggestions = true" @blur="handleMultiFromBlur"
                                                    type="text" class="form-control flight-input"
                                                    placeholder="Add departure" autocomplete="off" />
                                                <ul v-if="showMultiFromSuggestions && multiFromResults.length > 0"
                                                    class="list-group position-absolute shadow"
                                                    style="width:100%; max-height:220px; z-index:1050;">
                                                    <li v-for="(airport, index) in multiFromResults" :key="index"
                                                        class="list-group-item" style="cursor:pointer;"
                                                        @mousedown.prevent="selectMultiFromAirport(airport)">
                                                        <strong>{{ airport.airport_code }}</strong> —
                                                        {{ airport.airport_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div ref="multiToWrapper" class="col-lg-3 col-md-6 col-12"
                                                style="position: relative;">
                                                <label class="form-label search-label">To</label>
                                                <input v-model="multiToQuery" @input="onMultiToInput"
                                                    @keydown="onMultiToKeydown" @focus="showMultiToSuggestions = true"
                                                    @blur="handleMultiToBlur" type="text"
                                                    class="form-control flight-input" placeholder="Add arrival"
                                                    autocomplete="off" />
                                                <ul v-if="showMultiToSuggestions && multiToResults.length > 0"
                                                    class="list-group position-absolute shadow"
                                                    style="width:100%; max-height:220px; z-index:1050;">
                                                    <li v-for="(airport, index) in multiToResults" :key="index"
                                                        class="list-group-item" style="cursor:pointer;"
                                                        @mousedown.prevent="selectMultiToAirport(airport)">
                                                        <strong>{{ airport.airport_code }}</strong> —
                                                        {{ airport.airport_name }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Departure date</label>
                                                <input id="Departure1" type="text" class="date-input flight-input"
                                                    placeholder="Departure date" readonly />
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="form-label search-label">Guests</label>
                                                <input type="text" readonly
                                                    class="form-control flight-guest-input flight-input"
                                                    placeholder="1 passenger ECONOMY" id="travelerInput" />
                                            </div>
                                            <div class="col-lg-2 d-grid mobsearchbtn col-12">
                                                <button type="submit" class="btn flight-search-btn">GET A QUOTE</button>
                                            </div>
                                        </div>
                                        <div class="addflightbtnbox">
                                            <a href="" class="linkbtn applyBtn applyBtnnew"> <i
                                                    class="fa-solid fa-plus"></i> Add Flight</a>
                                            <a href="" class="linkbtn cancelBtnnew cancelBtn" style="display: none">
                                                <i class="fa-solid fa-xmark"></i> Clear All</a>
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
                <img src="images/home/h1-img-9.png" alt="" />
            </div>
            <div class="textureimageleft">
                <img src="images/about-4-1.webp" alt="" />
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
                                        <p>FlyOFair will guide you and suggest tailor-made flight options.
                                        </p>
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
                                        <p>Always stay informed with real-time flight updates and notifications.
                                        </p>
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
                                        <p>Get the benefits of modifying your booking, including cancellations and
                                            changes.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-5">
                        <div class="tg-chose-right">
                            <img src="images/home/advance.png" alt="image" />
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

                            <!-- Accordion Item 3 -->
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

                            <!-- Accordion Item 2 -->
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

                            <!-- Accordion Item 4 -->
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

                            <!-- Accordion Item 5 -->
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

                            <!-- Accordion Item 1 -->
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
        <section class="common-section NewsLettert-section d-none">
            <div class="container">
                <div class="NewsLettert-InnConBox">
                    <div class="NewsLettert-bg">
                        <img src="images/home/header-image-2-1.jpg" alt="" class="img-fluid" />
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-10 col-md-12 col-sm-12 col-12">
                            <div class="common-box NewsLettert-TitleBox">
                                <span class="common-SubTitle">stay in the loop</span>
                                <div class="section-header text-center">
                                    <h2 class="mb-2">
                                        sign up to receive our
                                        <span class="text-primary text-primarysec text-decoration-underline">emails and
                                            enjoy 15% off</span> your
                                        first order.
                                    </h2>
                                </div>
                                <form action="" class="NewsLettert-form">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Your email here" />
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
                    <!-- Testimonial 1 -->
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

                    <!-- Testimonial 2 -->
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

                    <!-- Testimonial 3 -->
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

                    <!-- Testimonial 4 -->
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
    </DefaultLayout>
</template>
