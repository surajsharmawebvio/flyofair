<!-- Popup card -->
<div class="traveler-card shadow p-3 rounded-3 mt-2" style="display: none;">
    <h6 class="mb-3 fw-bold">Select Travelers & Class</h6>

    <!-- Travelers Count -->
    <div class="mb-3 traveler-section">
        <div class="traveler-row d-flex justify-content-between align-items-center mb-2">
            <span class="boldtext">Adults (12+ Yrs)</span>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-light btn-sm traveler-minus" data-target="adult">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="adult-count mx-2 common-numtext">1</span>
                <button type="button" class="btn btn-light btn-sm traveler-plus" data-target="adult">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="traveler-row d-flex justify-content-between align-items-center mb-2">
            <span class="boldtext">Children (2-12 Yrs)</span>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-light btn-sm traveler-minus" data-target="child">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="child-count mx-2 common-numtext">0</span>
                <button type="button" class="btn btn-light btn-sm traveler-plus" data-target="child">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="traveler-row d-flex justify-content-between align-items-center">
            <span class="boldtext">Infants (0-2 Yrs)</span>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-light btn-sm traveler-minus" data-target="infant">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="infant-count mx-2 common-numtext">0</span>
                <button type="button" class="btn btn-light btn-sm traveler-plus" data-target="infant">
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
                name="travelClass" value="Economy" checked />
            <label class="form-check-label custome-form-check-label">Economy</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input travel-class" type="radio"
                name="travelClass" value="Premium Economy" />
            <label class="form-check-label custome-form-check-label">Premium Economy</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input travel-class" type="radio"
                name="travelClass" value="Business" />
            <label class="form-check-label custome-form-check-label">Business</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input travel-class" type="radio"
                name="travelClass" value="First Class" />
            <label class="form-check-label custome-form-check-label">First Class</label>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-end">
        <button type="button" class="btn cancelBtn me-2">Cancel</button>
        <button type="button" class="btn applyBtn">Apply</button>
    </div>
</div>
