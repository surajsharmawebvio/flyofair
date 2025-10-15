$(".tour-slider").owlCarousel({
  loop: true,
  margin: 15,
  nav: true,
  dots: false,
  responsive: {
    0: { items: 1 },
    600: { items: 2 },
    1000: { items: 3 },
    1200: { items: 4 },
  },
});

$(".blog-slider").owlCarousel({
  loop: true,
  margin: 15,
  nav: true,
  dots: false,
  responsive: {
    0: { items: 1 },
    600: { items: 1 },
    700: { items: 2 },
    1000: { items: 3 },
    1200: { items: 3 },
  },
});

// $(".client-slider").owlCarousel({
//   loop: true,
//   margin: 20,
//   autoplay: true,
//   autoplayTimeout: 2000,
//   autoplayHoverPause: true,
//   responsive: {
//     0: { items: 2 },
//     600: { items: 4 },
//     1000: { items: 6 },
//   },
// });

// $(".Partnered-slider").owlCarousel({
//   loop: true,
//   margin: 20,
//   autoplay: true,
//   autoplayTimeout: 2000,
//   autoplayHoverPause: true,
//   responsive: {
//     0: { items: 2 },
//     600: { items: 4 },
//     1000: { items: 6 },
//   },
// });

$(".custom-testimonial-carousel").owlCarousel({
  loop: true,
  margin: 30,
  nav: true,
  dots: false,
  navText: [
    '<i class="fa-solid fa-angle-left"></i>',
    '<i class="fa-solid fa-angle-right"></i>',
  ],
  responsive: {
    0: { items: 1 },
    768: { items: 2 },
    1024: { items: 3 },
  },
});

// accodion js

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
