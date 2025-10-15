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

// counter js

const counters = document.querySelectorAll(".custom-counter-number");
const duration = 2000;
const frameRate = 60;
const totalFrames = Math.round((duration / 1000) * frameRate);

function animateCounters() {
  counters.forEach((counter) => {
    const target = +counter.getAttribute("data-target");
    const unit = counter.getAttribute("data-unit") || ""; // new: optional unit
    let frame = 0;

    const counterInterval = setInterval(() => {
      frame++;
      const progress = frame / totalFrames;
      const value = Math.round(target * progress);

      counter.textContent = `${value}${unit}`;

      if (frame === totalFrames) {
        clearInterval(counterInterval);
        counter.textContent = `${target}${unit}`;
      }
    }, duration / totalFrames);
  });
}

window.addEventListener("load", animateCounters);
