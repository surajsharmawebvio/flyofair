$(function () {
  // ===============================
  // Template for flight row (divider only for first row)
  // ===============================
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
      <div class="col-lg-3 col-md-4 col-12">
        <label class="form-label search-label">Departure from</label>
        <input type="text" class="form-control flight-input" placeholder="Add departure">
      </div>
      <div class="col-lg-3 col-md-4 col-12">
        <label class="form-label search-label">Arrive at</label>
        <input type="text" class="form-control flight-input" placeholder="Add arrival">
      </div>
      <div class="col-lg-2 col-md-3 col-12">
        <label class="form-label search-label">Departure date</label>
        <input type="text" class="form-control date-input flight-input" placeholder="Departure date" readonly>
      </div>
      <div class="col-lg-1 col-md-1">
        <a href="#" class="linkbtn cancelthisBtnnew cancelBtn">
          <i class="fa-solid fa-trash-can"></i>
        </a>
      </div>
    </div>`;

  // ===============================
  // Show/hide Clear All button
  // ===============================
  function toggleClearButton() {
    $(".tab-pane").each(function () {
      const pane = $(this);
      const rowCount = pane.find(".flight-form-fields .flight-row").length;
      // Show Clear All only if more than 1 row exists
      pane.find(".cancelBtnnew").toggle(rowCount > 1);
    });
  }

  // ===============================
  // Flatpickr initialization
  // ===============================
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

  // ===============================
  // Add new row (max 5)
  // ===============================
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
    toggleClearButton();
  });

  // ===============================
  // Remove individual flight row
  // ===============================
  $(document).on("click", ".cancelthisBtnnew", function (e) {
    e.preventDefault();
    $(this).closest(".flight-row").remove();
    toggleClearButton();
  });

  // ===============================
  // Clear All - remove only .flight-row elements
  // ===============================
  $(document).on("click", ".cancelBtnnew", function (e) {
    e.preventDefault();
    const currentTab = $(this).closest(".tab-pane");
    const formFields = currentTab.find(".flight-form-fields");

    // ✅ Remove only .flight-row elements, keep other content (like divider)
    formFields.find(".flight-row").remove();

    toggleClearButton();
    $("html, body").animate({ scrollTop: 0 }, 600);
  });

  // ===============================
  // Initialize Flatpickr on page load
  // ===============================
  initFlatpickr($("body"));
});

// form inside modal js

// Initialize traveler form functionality only if all required elements exist
(function initializeTravelerForm() {
  const input = document.getElementById("travelerInput");
  const card = document.getElementById("travelerCard");
  const applyBtn = document.getElementById("applyBtn");
  const cancelBtn = document.getElementById("cancelBtn");

  // Only proceed if all required elements are present
  if (!input || !card || !applyBtn || !cancelBtn) {
    return; // Exit if any required element is missing
  }

  const counts = { adult: 1, child: 0, infant: 0 };

// store the last applied state
let lastAppliedCounts = { ...counts };
let lastAppliedClass =
  document.querySelector('input[name="travelClass"]:checked')?.value || "";

function updateCounts() {
  const adultEl = document.getElementById("adultCount");
  const childEl = document.getElementById("childCount");
  const infantEl = document.getElementById("infantCount");

  if (adultEl) adultEl.textContent = counts.adult;
  if (childEl) childEl.textContent = counts.child;
  if (infantEl) infantEl.textContent = counts.infant;

  const total = counts.adult + counts.child + counts.infant;
  const travelClassInput = document.querySelector(
    'input[name="travelClass"]:checked'
  );
  const travelClass = travelClassInput
    ? travelClassInput.value.toUpperCase()
    : "";
  if (input) input.value = `${total} passenger${total > 1 ? "s" : ""} ${travelClass}`;
}
updateCounts();

// Open card on click → snapshot current applied state
input.addEventListener("click", (e) => {
  e.stopPropagation();
  card.style.display = "block";

  // snapshot current applied values before editing
  lastAppliedCounts = { ...counts };
  lastAppliedClass =
    document.querySelector('input[name="travelClass"]:checked')?.value || "";
});

card.addEventListener("click", (e) => e.stopPropagation());

// Increment / decrement
document.querySelectorAll(".traveler-plus").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    counts[btn.dataset.target]++;
    updateCounts();
  });
});
document.querySelectorAll(".traveler-minus").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    if (counts[btn.dataset.target] > 0) {
      counts[btn.dataset.target]--;
      updateCounts();
    }
  });
});

// Update when radio changes
document.querySelectorAll('input[name="travelClass"]').forEach((radio) => {
  radio.addEventListener("change", () => updateCounts());
});

// ✅ Apply → save current as last applied
applyBtn.addEventListener("click", (e) => {
  e.preventDefault();
  lastAppliedCounts = { ...counts };
  const checked = document.querySelector('input[name="travelClass"]:checked');
  lastAppliedClass = checked ? checked.value : "";
  card.style.display = "none";
});

// ✅ Cancel → restore last applied values
cancelBtn.addEventListener("click", (e) => {
  e.preventDefault();
  // revert counts
  Object.assign(counts, lastAppliedCounts);
  // revert radio selection
  if (lastAppliedClass) {
    const oldRadio = document.querySelector(
      `input[name="travelClass"][value="${lastAppliedClass}"]`
    );
    if (oldRadio) oldRadio.checked = true;
  }
  updateCounts(); // refresh UI & input
  card.style.display = "none";
});

// Close when clicking outside
document.addEventListener("click", () => {
    card.style.display = "none";
  });
})();
