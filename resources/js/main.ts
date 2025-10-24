import jQuery from 'jquery';
import 'owl.carousel';
import flatpickr from 'flatpickr';

const $ = jQuery;

// Carousel configurations
const carouselSettings = {
    tourSlider: {
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
    blogSlider: {
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
    testimonialCarousel: {
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        items: 1
    }
};

// Initialize carousels
export function initCarousels() {
    if ($('.owl-carousel').length) {
        if ($('.tour-slider').length) {
            $('.tour-slider').owlCarousel(carouselSettings.tourSlider);
        }
        if ($('.blog-slider').length) {
            $('.blog-slider').owlCarousel(carouselSettings.blogSlider);
        }
        if ($('.custom-testimonial-carousel').length) {
            $('.custom-testimonial-carousel').owlCarousel(carouselSettings.testimonialCarousel);
        }
    }
}

// Initialize datepickers
export function initDatepickers() {
    if ($('.date-input').length) {
        flatpickr('.date-input', {
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            minDate: 'today',
            disableMobile: true
        });
    }
}

// Password toggle functionality
export function togglePassword(inputId: string, toggleIcon: HTMLElement) {
    const passwordInput = document.getElementById(inputId) as HTMLInputElement;
    if (!passwordInput) return;

    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    toggleIcon.classList.toggle('bi-eye');
    toggleIcon.classList.toggle('bi-eye-slash');
}

// Export all initialization functions
export const init = {
    carousels: initCarousels,
    datepickers: initDatepickers,
    togglePassword
};
