// Initialize owl carousel function
function initOwlCarousels() {
    if ($('.owl-carousel').length) {
        // Tour Slider
        if ($('.tour-slider').length) {
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
        }

        // Blog Slider
        if ($('.blog-slider').length) {
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
        }

        // Testimonial Carousel
        if ($('.custom-testimonial-carousel').length) {
            $('.custom-testimonial-carousel').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                items: 1
            });
        }
    }
}

$(document).ready(function () {
    // Initialize carousels
    initOwlCarousels();

    // $(window).scroll(function () {
    //   if ($(window).scrollTop() >= 10) {
    //     $(".navbar").addClass("header-fixed");
    //   } else {
    //     $(".navbar").removeClass("header-fixed");
    //   }
    // });

    // Check if any element with class 'date-input' exists
    if ($(".date-input").length) {
        // Initialize Flatpickr
        flatpickr(".date-input", {
            altInput: true, // nice formatted text
            altFormat: "F j, Y", // e.g., Oct 21, 2024
            dateFormat: "Y-m-d", // value sent to backend
            minDate: "today", // disable past dates
            disableMobile: true, // always use custom calendar
        });
    }
});

function togglePassword(inputId, toggleIcon) {
    const passwordInput = document.getElementById(inputId);
    const isPassword = passwordInput.type === "password";

    passwordInput.type = isPassword ? "text" : "password";
    toggleIcon.classList.toggle("bi-eye");
    toggleIcon.classList.toggle("bi-eye-slash");
}

// Create scroll to top button HTML and inject into page
(function () {
    // Create button HTML
    const scrollTopHTML = `
        <div class="topscroll-button-container">
            <button class="topscroll-main-button" id="topscrollBtn" aria-label="Scroll to top">
                <i class="fas fa-arrow-up topscroll-icon"></i>
            </button>
        </div>
    `;

    // Create styles
    const scrollTopStyles = `
        <style>
            .topscroll-button-container {
                position: fixed;
                bottom: 86px;
                right: 25px;
                z-index: 1000;
            }

            .topscroll-main-button {
                width: 40px;
                height: 40px;
                background: rgba(var(--main-color), 1);
                border: none;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 4px 16px rgba(var(--white-color), 0.5);
                transition: all 0.3s ease;
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px);
            }

            .topscroll-main-button.topscroll-visible {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .topscroll-main-button:hover {
                background: rgba(var(--main-color), 0.9);
                transform: translateY(-4px);
                box-shadow: 0 6px 24px  rgba(var(--white-color), 0.5);
            }

            .topscroll-main-button:active {
                transform: translateY(-2px);
            }

            .topscroll-icon {
                color: #ffffff;
                font-size: 15px;
            }

            @media (max-width: 768px) {
                .topscroll-button-container {
                    bottom: 80px;
                    right: 20px;
                }

                .topscroll-main-button {
                    width: 40px;
                    height: 40px;
                }

                .topscroll-icon {
                    font-size: 15px;
                }
            }
        </style>
    `;

    // Inject styles into head
    document.head.insertAdjacentHTML("beforeend", scrollTopStyles);

    // Inject button into body
    document.body.insertAdjacentHTML("beforeend", scrollTopHTML);

    // Get the button element
    const topscrollBtn = document.getElementById("topscrollBtn");

    // Show/hide button based on scroll position
    window.addEventListener("scroll", function () {
        if (window.pageYOffset > 300) {
            topscrollBtn.classList.add("topscroll-visible");
        } else {
            topscrollBtn.classList.remove("topscroll-visible");
        }
    });

    // Smooth scroll to top when button is clicked
    topscrollBtn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
})();

// Floating Call Button - Pure JavaScript
(function () {
    // Create Font Awesome link
    const faLink = document.createElement("link");
    document.head.appendChild(faLink);

    // Create styles
    const style = document.createElement("style");
    style.textContent = `
        .floating-call-btn {
            position: fixed;
            bottom: 20px;
            right: 25px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff9100ff, #ffa600ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px  rgba(var(--second-color), 1);
            transition: all 0.3s ease;
            z-index: 1000;
            animation: pulse 2s infinite;
            text-decoration: none;
            color:#000;
        }

        .floating-call-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 6px 25px  rgba(var(--second-color), 1);
        }

        .floating-call-btn:active {
            transform: scale(0.9);
        }

        .floating-call-btn i {
            color:  rgba(var(--black-color), 1);
            font-size: 15px;
            animation: shake 3s ease-in-out infinite;
        }

        .floating-call-btn::before,
        .floating-call-btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid  rgba(var(--second-color), 1);
            opacity: 0;
            animation: ripple 2s infinite;
        }

        .floating-call-btn::after {
            animation-delay: 1s;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 4px 15px rgba(var(--second-color), 1);
            }
            50% {
                box-shadow: 0 4px 25px  rgba(var(--second-color), 1);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }
            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: rotate(0deg);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: rotate(-10deg);
            }
            20%, 40%, 60%, 80% {
                transform: rotate(10deg);
            }
        }

        @media (max-width: 768px) {
            .floating-call-btn {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }

            .floating-call-btn i {
                font-size: 20px;
            }
        }
    `;
    document.head.appendChild(style);

    // Create button HTML
    const callBtn = document.createElement("a");
    callBtn.href = "#travelExpertModal"; // Replace with your phone number
    callBtn.className = "floating-call-btn";
    callBtn.setAttribute("data-bs-toggle", "modal");
    callBtn.innerHTML = `
<i class="fa-solid fa-headset"></i>
    `;

    // Add to body when DOM is ready
    if (document.body) {
        document.body.appendChild(callBtn);
    } else {
        document.addEventListener("DOMContentLoaded", function () {
            document.body.appendChild(callBtn);
        });
    }
})();

// ==============================
// JS-ONLY RESPONSIVE LOADER
// ==============================

// Create loader wrapper
const loaderWrapper = document.createElement("div");
loaderWrapper.className = "loader-wrapper";
loaderWrapper.innerHTML = `<div class="loader"></div>`;
document.body.appendChild(loaderWrapper);

// Create and append loader styles
const style = document.createElement("style");
style.textContent = `
  /* =============== LOADER CSS =============== */
  .loader-wrapper {
    position: fixed;
    inset: 0;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.6s ease, visibility 0.6s ease;
  }
  .loader-wrapper.hidden {
    opacity: 0;
    visibility: hidden;
  }

  .loader {
    width: fit-content;
    font-size: 40px;
    font-weight: bold;
    text-transform: uppercase;
    color: transparent;
    -webkit-text-stroke: 1px #000;
    background:
      radial-gradient(0.71em at 50% 1em, #000 99%, #ff8f00 101%) calc(50% - 1em) 1em/2em 200% repeat-x text,
      radial-gradient(0.71em at 50% -0.5em, #ff8f00 99%, #000 101%) 50% 1.5em/2em 200% repeat-x text;
    animation: 
      l10-0 0.8s linear infinite alternate,
      l10-1 4s linear infinite;
  }

  .loader::before {
    content: "Campaign Theme";
  }

  @keyframes l10-0 {
    to { background-position-x: 50%, calc(50% + 1em); }
  }

  @keyframes l10-1 {
    to { background-position-y: -0.5em, 0; }
  }

  @media (max-width: 767px) {
    .loader {
      margin: 0 auto;
      width: fit-content;
      font-size: 28px;
      text-align: center;
      line-height: 1.4;
    }
  }

  @media (max-width: 580px) {
    .loader-wrapper {
      z-index: 998;
    }
  }
`;
document.head.appendChild(style);

// Ensure loader displays immediately before rendering
document.addEventListener("DOMContentLoaded", () => {
    loaderWrapper.style.display = "flex";
});

// Loader visible duration
const loaderDuration = 1500; // 1.5 seconds

// Hide loader after page load + delay
window.addEventListener("load", () => {
    setTimeout(() => {
        loaderWrapper.classList.add("hidden");
        setTimeout(() => loaderWrapper.remove(), 600);
    }, loaderDuration);
});
