<div class="popup-overlay" id="popup-overlay" style="display: none;">
    <div class="popup-container">
        <!-- popup body -->
        <div class="popup-body">
            <div class="popup-title">
                <div class="p-title">
                    <h3>Need booking Assistance?</h3>
                    <p>Expert Support for Effortless Travel Planning</p>
                </div>
                <div>
                    <a href="tel:+1-877-238-0219" class="pop-up-btn">Call Now</a>
                </div>
            </div>
            <div class="popup-content">
                <div class="child-content-service">
                    <div>
                        <img src="/images/popup/36.png" alt="popup image">
                        <p>Quick Support from <strong>Our Experts</strong></p>
                    </div>
                    <div>
                        <img src="/images/popup/35.png" alt="popup image">
                        <p>Instant <strong>Booking Confirmation</strong></p>
                    </div>
                    <div>
                        <img src="/images/popup/34.png" alt="popup image">
                        <p>Up to 24-hours <strong>Cancellation</strong></p>
                    </div>
                    <div>
                        <img src="/images/popup/37.png" alt="popup image">
                        <p>Payment <strong>Flexibility</strong></p>
                    </div>
                </div>
                <div class="btn-contact" style="margin-top: 20px; text-align: center;">
                    <a href="{{ request()->is('es*') ? '/es/contactanos/' : '/contact-us/' }}" class="pop-up-btn">Contact a Travel Expert</a>
                </div>
                <form id="popup-subscribe-form" class="subscribe">
                    @csrf
                    <label for="popup-subscribe">Stay Updated:</label>
                    <div>
                        <input type="email" id="popup-subscribe" placeholder="Enter your email" required>
                        <button type="submit" class="pop-up-btn-2">
                            <span class="subscribe-text">Subscribe</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- popup footer -->
        <div class="popup-footer">
            <div class="brand-icons">
                <img src="/images/popup/1.png" alt="">
                <img src="/images/popup/2.png" alt="">
                <img src="/images/popup/3.png" alt="">
                <img src="/images/popup/4.png" alt="">
            </div>

            <div class="social-icons">
                <a href="https://x.com/FlyoFair" target="_blank" class="twitter">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a href="https://www.facebook.com/people/Flyofair/61583235514966/" target="_blank" class="facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/flyofair/" target="_blank" class="instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.pinterest.com/flyofair/" target="_blank" class="pinterest">
                    <i class="fab fa-pinterest"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Popup functionality
document.addEventListener('DOMContentLoaded', function() {
    const popupOverlay = document.getElementById('popup-overlay');
    const popupForm = document.getElementById('popup-subscribe-form');
    const popupEmail = document.getElementById('popup-subscribe');
    const subscribeBtn = popupForm.querySelector('.pop-up-btn-2');
    const subscribeText = subscribeBtn.querySelector('.subscribe-text');

    // Show popup after 5 seconds
    setTimeout(function() {
        if (popupOverlay) {
            popupOverlay.style.display = 'flex';
        }
    }, 5000);

    // Close popup when clicking overlay
    popupOverlay.addEventListener('click', function(e) {
        if (e.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });

    // Popup newsletter subscription
    popupForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!popupEmail.value) {
            Swal.fire({ icon: 'warning', title: 'Please enter your email.' });
            return;
        }

        subscribeBtn.disabled = true;
        subscribeText.textContent = 'please wait...';

        try {
            const response = await axios.post('/api/newsletter/subscribe', {
                email: popupEmail.value
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            await Swal.fire({ 
                icon: 'success', 
                title: response.data.message || 'Subscribed successfully' 
            });
            
            popupEmail.value = '';
            popupOverlay.style.display = 'none';
        } catch (error) {
            if (error.response && error.response.status === 422 && error.response.data.errors) {
                const firstKey = Object.keys(error.response.data.errors)[0];
                const firstMsg = error.response.data.errors[firstKey][0];
                await Swal.fire({ icon: 'error', title: firstMsg });
            } else if (error.response && error.response.data && error.response.data.message) {
                await Swal.fire({ icon: 'error', title: error.response.data.message });
            } else {
                await Swal.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
            }
        } finally {
            subscribeBtn.disabled = false;
            subscribeText.textContent = 'Subscribe';
        }
    });
});
</script>
@endpush

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    font-family: Arial, sans-serif;
    z-index: 9999;
}

.popup-container {
    background-image: url('/images/popup/popup-bg.webp');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    max-width: 700px;
    width: 100%;
    text-align: center;
    overflow: hidden;
}

.popup-body {
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    font-weight: bold;
    position: relative;
}

.popup-title {
    position: absolute;
    top: 0;
    font-size: 28px;
    font-weight: bold;
    height: 30%;
    width: 80%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.p-title {
    text-align: left;
}

.p-title h3 {
    font-size: 24px;
    font-weight: bold;
}

.p-title p {
    font-size: 18px;
    font-weight: normal;
    margin-top: 5px;
}

.popup-content {
    position: absolute;
    z-index: 1;
    background-color: #fff;
    bottom: 0;
    width: 80%;
    height: 70%;
    border-radius: 10px 10px 0 0;
    box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.2);
}

.child-content-service {
    display: flex;
}

.child-content-service>div {
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.child-content-service img {
    width: 80px;
    height: 80px;
}

.child-content-service p {
    font-size: 14px;
    color: #333;
}

.child-content-service p strong {
    font-weight: 800 !important;
    color: #000000;
    font-size: 15px;
}

.subscribe {
    text-align: left;
    width: 80%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.subscribe div {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    max-width: 400px;
}

.subscribe input {
    flex: 1;
    padding: 5px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.subscribe label {
    color: #1255FF;
    font-weight: 400;
    font-size: 18px;
    display: none;
}

.popup-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    background-color: #fff;
    gap: 20px;
    padding: 0 15px;
}

.pop-up-btn {
    color: #fff;
    background-color: #FF9600;
    border-radius: 25px;
    padding: 10px 20px;
    text-decoration: none;
    display: inline-block;
    white-space: nowrap;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pop-up-btn:hover {
    background-color: #e68600;
    transform: scale(1.05);
}

.pop-up-btn-2 {
    color: #fff;
    background-color: #FF9600;
    border-radius: 2px;
    padding: 5px 15px;
    text-decoration: none;
    display: inline-block;
    white-space: nowrap;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.brand-icons {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.brand-icons img {
    max-width: 80px;
    height: auto;
    object-fit: contain;
}

.social-icons {
    display: flex;
    align-items: center;
    gap: 12px;
    border: #1e1e1e solid 1px;
    border-radius: 5px;
    padding: 5px;
}

.social-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #fff;
    font-size: 16px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-icons a:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.social-icons a.facebook {
    background-color: #1877f2;
}

.social-icons a.instagram {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.social-icons a.twitter {
    background-color: #000000;
}

.social-icons a.pinterest {
    background-color: #e60023;
}

/* Responsive */
@media (max-width: 768px) {
    .popup-overlay {
        padding: 15px;
    }

    .popup-container {
        max-width: 95vw;
        position: relative;
    }

    .popup-body {
        min-height: 350px;
    }

    .popup-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
        height: auto;
        margin-top: 20px;
    }

    .p-title h3 {
        font-size: 20px;
    }

    .p-title p {
        font-size: 16px;
    }

    .popup-content {
        width: 90%;
        height: 75%;
    }

    .child-content-service {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }

    .child-content-service > div {
        flex: 0 0 calc(50% - 15px);
        min-width: 120px;
    }

    .child-content-service img {
        width: 60px;
        height: 60px;
    }

    .child-content-service p {
        font-size: 12px;
        text-align: center;
    }

    .btn-contact {
        margin-top: 15px;
    }

    .subscribe {
        width: 90%;
        gap: 8px;
    }

    .subscribe label {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .subscribe div {
        max-width: none;
        flex-direction: column;
        gap: 8px;
        align-items: stretch;
    }

    .subscribe input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .pop-up-btn-2 {
        align-self: flex-start;
        padding: 10px 16px;
        font-size: 14px;
        border-radius: 6px;
    }

    .popup-footer {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
        position: absolute;
        bottom: 0;
    }

    .brand-icons {
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .brand-icons img {
        max-width: 60px;
        height: auto;
        object-fit: contain;
    }

    .social-icons {
        justify-content: center;
        gap: 8px;
    }

    .social-icons a {
        width: 34px;
        height: 34px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .popup-overlay {
        padding: 10px;
    }

    .popup-container {
        max-width: 100vw;
        border-radius: 8px;
        height: 80vh;
        display: flex;
        flex-direction: column;
    }

    .popup-body {
        flex: 1;
        min-height: 0;
    }

    .popup-title {
        width: 90%;
        margin-top: 15px;
    }

    .p-title h3 {
        font-size: 18px;
    }

    .p-title p {
        font-size: 14px;
    }

    .popup-content {
        width: 95%;
        height: 73%;
    }

    .child-content-service {
        gap: 10px;
    }

    .child-content-service > div {
        flex: 0 0 calc(50% - 10px);
        min-width: 100px;
    }

    .child-content-service img {
        width: 50px;
        height: 50px;
    }

    .child-content-service p {
        font-size: 11px;
    }

    .child-content-service p strong {
        font-size: 12px;
    }

    .btn-contact {
        margin-top: 10px;
    }

    .subscribe {
        width: 95%;
        gap: 5px;
    }

    .subscribe label {
        font-size: 14px;
        margin-bottom: 3px;
    }

    .subscribe div {
        gap: 6px;
    }

    .subscribe input {
        padding: 8px 10px;
        font-size: 13px;
        border-radius: 4px;
    }

    .pop-up-btn-2 {
        padding: 8px 12px;
        font-size: 13px;
        border-radius: 4px;
    }

    .popup-footer {
        position: relative;
        padding: 12px;
        gap: 12px;
        flex-shrink: 0;
        width: 95%;
        margin: 0 auto;
    }

    .brand-icons {
        gap: 6px;
    }

    .brand-icons img {
        max-width: 60px;
    }

    .social-icons {
        gap: 6px;
    }

    .social-icons a {
        width: 50px;
        height: 50px;
        font-size: 16px;
    }

    .pop-up-btn {
        padding: 8px 16px;
        font-size: 14px;
    }
}

@media (max-width: 400px) {
    .subscribe div {
        flex-direction: row;
    }
}

@media (max-width: 380px) {
    .popup-container {
        height: 90vh;
    }
    .popup-content {
        height: 70%;
    }

    .p-title h3 {
        font-size: 16px;
    }

    .p-title p {
        font-size: 12px;
    }

    .child-content-service p {
        font-size: 10px;
    }

    .child-content-service p strong {
        font-size: 11px;
    }

    .subscribe label {
        font-size: 12px;
    }

    .subscribe input {
        font-size: 12px;
    }

    .pop-up-btn-2 {
        font-size: 12px;
    }

    .social-icons a {
        font-size: 14px;
        width: 45px;
        height: 45px;
    }

    .pop-up-btn {
        font-size: 12px;
    }

    .brand-icons img {
        max-width: 50px;
    }
}
</style>
