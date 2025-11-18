// Home page functionality
(function() {
    'use strict';

    const API_BASE_URL = 'https://development.theinfinitytravel.com/api/v1/all/airport-list?input=';

    // Country codes data
    const countryCodes = [
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
    ];

    let selectedCountryCode = '+1';

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Initialize country code selectors
    function initCountryCodeSelectors() {
        document.querySelectorAll('.country-code-select').forEach(select => {
            select.innerHTML = '';
            countryCodes.forEach(country => {
                const option = document.createElement('option');
                option.value = country.code;
                option.textContent = `${country.flag} ${country.code}`;
                if (country.code === selectedCountryCode) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            select.addEventListener('change', function() {
                selectedCountryCode = this.value;
            });
        });
    }

    // Detect country by IP
    async function detectCountryByIP() {
        try {
            const response = await axios.get('https://ipapi.co/json/');
            const countryCode = response.data.country_code;
            const country = countryCodes.find(c => c.country === countryCode);
            if (country) {
                selectedCountryCode = country.code;
                initCountryCodeSelectors();
            }
        } catch (error) {
            console.error('Error detecting country:', error);
        }
    }

    // Airport search function
    async function searchAirports(query) {
        if (!query) return [];

        try {
            const url = API_BASE_URL + encodeURIComponent(query);
            const res = await axios.get(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                withCredentials: false,
            });
            return res.data.data || res.data || [];
        } catch (error) {
            console.error('Error fetching airports:', error);
            return [];
        }
    }

    // Setup airport autocomplete for an input
    function setupAirportAutocomplete(inputElement) {
        const suggestionsContainer = inputElement.nextElementSibling;
        if (!suggestionsContainer || !suggestionsContainer.classList.contains('airport-suggestions')) {
            console.error('Suggestions container not found for', inputElement);
            return;
        }

        let currentResults = [];
        let highlightedIndex = -1;

        const debouncedSearch = debounce(async function(query) {
            if (!query || query.length < 2) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            currentResults = await searchAirports(query);
            if (currentResults.length > 0) {
                suggestionsContainer.innerHTML = '';
                currentResults.forEach((airport, index) => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.style.cursor = 'pointer';
                    li.innerHTML = `<strong>${airport.airport_code}</strong> — ${airport.airport_name}`;
                    li.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        selectAirport(airport);
                    });
                    suggestionsContainer.appendChild(li);
                });
                suggestionsContainer.style.display = 'block';
            } else {
                suggestionsContainer.style.display = 'none';
            }
        }, 400);

        function selectAirport(airport) {
            inputElement.value = `${airport.airport_code} — ${airport.airport_name}`;
            suggestionsContainer.style.display = 'none';
            currentResults = [];
            highlightedIndex = -1;
        }

        inputElement.addEventListener('input', function() {
            debouncedSearch(this.value);
            highlightedIndex = -1;
        });

        inputElement.addEventListener('focus', function() {
            if (currentResults.length > 0) {
                suggestionsContainer.style.display = 'block';
            }
        });

        inputElement.addEventListener('blur', function() {
            setTimeout(() => {
                suggestionsContainer.style.display = 'none';
            }, 200);
        });

        inputElement.addEventListener('keydown', function(e) {
            const items = suggestionsContainer.querySelectorAll('.list-group-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightedIndex = Math.min(highlightedIndex + 1, items.length - 1);
                updateHighlight(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightedIndex = Math.max(highlightedIndex - 1, -1);
                updateHighlight(items);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (highlightedIndex >= 0 && currentResults[highlightedIndex]) {
                    selectAirport(currentResults[highlightedIndex]);
                } else if (currentResults.length === 1) {
                    selectAirport(currentResults[0]);
                }
            } else if (e.key === 'Escape') {
                suggestionsContainer.style.display = 'none';
            }
        });

        function updateHighlight(items) {
            items.forEach((item, index) => {
                if (index === highlightedIndex) {
                    item.style.backgroundColor = '#e9ecef';
                } else {
                    item.style.backgroundColor = '';
                }
            });
            if (highlightedIndex >= 0 && items[highlightedIndex]) {
                items[highlightedIndex].scrollIntoView({ block: 'nearest' });
            }
        }
    }

    // Initialize Flatpickr date pickers
    function initDatePickers() {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Oneway departure
        if (document.getElementById('oneway-departure')) {
            flatpickr('#oneway-departure', {
                minDate: today,
                dateFormat: 'Y-m-d',
                disableMobile: true
            });
        }

        // Round trip dates
        if (document.getElementById('round-departure')) {
            const roundDeparture = flatpickr('#round-departure', {
                minDate: today,
                dateFormat: 'Y-m-d',
                disableMobile: true,
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        roundReturn.set('minDate', selectedDates[0]);
                    }
                }
            });

            const roundReturn = flatpickr('#round-return', {
                minDate: today,
                dateFormat: 'Y-m-d',
                disableMobile: true
            });
        }

        // Multi-city departure
        if (document.getElementById('multi-departure')) {
            flatpickr('#multi-departure', {
                minDate: today,
                dateFormat: 'Y-m-d',
                disableMobile: true
            });
        }
    }

    // Traveler selection functionality
    function initTravelerSelection() {
        document.querySelectorAll('.flight-guest-input').forEach(guestInput => {
            const travelerCard = guestInput.nextElementSibling;
            if (!travelerCard || !travelerCard.classList.contains('traveler-card')) return;

            const adultCount = travelerCard.querySelector('.adult-count');
            const childCount = travelerCard.querySelector('.child-count');
            const infantCount = travelerCard.querySelector('.infant-count');
            const cancelBtn = travelerCard.querySelector('.cancelBtn');
            const applyBtn = travelerCard.querySelector('.applyBtn');

            let adults = 1, children = 0, infants = 0;
            let selectedClass = 'Economy';

            function updateDisplay() {
                adultCount.textContent = adults;
                childCount.textContent = children;
                infantCount.textContent = infants;
            }

            function updateInput() {
                const total = adults + children + infants;
                const passengerText = total === 1 ? 'passenger' : 'passengers';
                guestInput.value = `${total} ${passengerText} ${selectedClass}`;
            }

            guestInput.addEventListener('click', function(e) {
                e.stopPropagation();
                travelerCard.style.display = travelerCard.style.display === 'block' ? 'none' : 'block';
            });

            travelerCard.querySelectorAll('.traveler-minus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const target = this.dataset.target;
                    if (target === 'adult' && adults > 1) adults--;
                    if (target === 'child' && children > 0) children--;
                    if (target === 'infant' && infants > 0) infants--;
                    updateDisplay();
                });
            });

            travelerCard.querySelectorAll('.traveler-plus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const target = this.dataset.target;
                    if (target === 'adult' && adults < 9) adults++;
                    if (target === 'child' && children < 9) children++;
                    if (target === 'infant' && infants < 9) infants++;
                    updateDisplay();
                });
            });

            travelerCard.querySelectorAll('.travel-class').forEach(radio => {
                radio.addEventListener('change', function() {
                    selectedClass = this.value;
                });
            });

            cancelBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                adults = 1;
                children = 0;
                infants = 0;
                selectedClass = 'Economy';
                travelerCard.querySelector('input[value="Economy"]').checked = true;
                updateDisplay();
                updateInput();
                travelerCard.style.display = 'none';
            });

            applyBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                updateInput();
                travelerCard.style.display = 'none';
            });

            // Close on click outside
            document.addEventListener('click', function(e) {
                if (!travelerCard.contains(e.target) && e.target !== guestInput) {
                    travelerCard.style.display = 'none';
                }
            });

            updateDisplay();
            updateInput();
        });
    }

    // Form submission handling
    function initFormSubmission() {
        document.querySelectorAll('.flight-booking-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const tripType = formData.get('tripType');
                const data = {
                    tripType: tripType,
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    from: formData.get('from'),
                    to: formData.get('to'),
                    departureDate: formData.get('departureDate'),
                };

                if (tripType === 'round') {
                    data.returnDate = formData.get('returnDate');
                }

                console.log('Form data:', data);

                await Swal.fire({
                    icon: 'success',
                    title: 'Quote Request Submitted',
                    text: 'We will contact you shortly with the best flight options!',
                    confirmButtonText: 'OK'
                });

                // Optionally, send to backend
                // try {
                //     const response = await axios.post('/api/get-quote', data);
                //     await Swal.fire({
                //         icon: 'success',
                //         title: 'Quote Request Submitted',
                //         text: response.data.message
                //     });
                // } catch (error) {
                //     await Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'Something went wrong. Please try again.'
                //     });
                // }
            });
        });
    }

    // Initialize Owl Carousel
    function initCarousels() {
        if (typeof $.fn.owlCarousel !== 'undefined') {
            $('.tour-slider').owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    992: { items: 4 },
                    1200: { items: 5 }
                }
            });

            $('.custom-testimonial-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 }
                }
            });
        }
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initCountryCodeSelectors();
        detectCountryByIP();

        // Setup airport autocomplete for all inputs
        document.querySelectorAll('.airport-from-input, .airport-to-input').forEach(input => {
            setupAirportAutocomplete(input);
        });

        initDatePickers();
        initTravelerSelection();
        initFormSubmission();
        initCarousels();
    });

})();
