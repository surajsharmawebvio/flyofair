<!-- Banner pop-up component (uses v-model: modelValue for visibility) -->
<template>
    <div class="popup-overlay" v-if="isVisible" @click="closePopUp">
        <div class="popup-container" @click.stop>
            <!-- popup body -->
            <div class="popup-body">
                <div class="popup-title">
                    <div class="p-title">
                        <h3>Need booking Assistance?</h3>
                        <p>Expert Support for Effortless Travel Planning</p>
                    </div>
                    <div>
                        <a href="tel:+1234567890" class="pop-up-btn">Call Now</a>
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
                            <p>Payment <strong>Flaxibility</strong></p>
                        </div>
                    </div>
                    <div class="btn-contact" style="margin-top: 20px; text-align: center;">
                        <Link href="/contact-us" class="pop-up-btn">Contact a Travel Expert</Link>
                    </div>
                    <form @submit.prevent="subscribe" class="subscribe">
                      <label for="subscribe">Stay Updated:</label>
                      <div>
                        <input v-model="email" type="email" id="subscribe" placeholder="Enter your email" required>
                        <a :disabled="loading" type="submit" class="pop-up-btn-2">
                          <span v-if="!loading">Subscribe</span>
                          <span v-else>please wait...</span>
                        </a>
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
</template>

<script>
    import {
        Link
    } from '@inertiajs/vue3';
    import axios from 'axios';
    import Swal from 'sweetalert2';

    // Configure axios defaults
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.withCredentials = true;

    // Get CSRF token from meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }

    export default {
        name: 'PopUp',
        components: {
            Link
        },
        props: {
            // Use v-model:modelValue on the component to control visibility
            modelValue: {
                type: Boolean,
                default: false
            }
        },
        emits: ['update:modelValue', 'request-call'],
        data() {
            return {
                email: '',
                loading: false
            };
        },
        computed: {
            isVisible: {
                get() {
                    return this.modelValue;
                },
                set(val) {
                    this.$emit('update:modelValue', val);
                }
            }
        },
        methods: {
            closePopUp() {
                this.isVisible = false;
            },
            async subscribe(event) {
                // form submit prevented by @submit.prevent
                if (!this.email) {
                    await Swal.fire({ icon: 'warning', title: 'Please enter your email.' });
                    return;
                }

                this.loading = true;
                try {
                    const res = await axios.post('/api/newsletter/subscribe', { email: this.email }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        withCredentials: false,
                    });

                    await Swal.fire({ icon: 'success', title: res.data.message || 'Subscribed successfully' });
                    this.email = '';
                    this.isVisible = false; // Hide popup on success
                } catch (err) {
                    if (err.response && err.response.status === 422 && err.response.data.errors) {
                        // validation errors
                        const firstKey = Object.keys(err.response.data.errors)[0];
                        const firstMsg = err.response.data.errors[firstKey][0];
                        await Swal.fire({ icon: 'error', title: firstMsg });
                    } else if (err.response && err.response.data && err.response.data.message) {
                        await Swal.fire({ icon: 'error', title: err.response.data.message });
                    } else {
                        await Swal.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
                    }
                } finally {
                    this.loading = false;
                }
            }
        }
    };

</script>

<style scoped>
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
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 700px;
        width: 100%;
        text-align: center;
        overflow: hidden;
    }

    .popup-body {
        background-image: url('/images/popup-background.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
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
      /* align-items: center; */
      gap: 10px;
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
    }

    .btn-contact button {
        width: 499px;
        height: 86px;
        border-radius: 45px;
        /* angle: 0 deg; */
        opacity: 1;
        top: 669px;
        left: 710px;
        background-color: #FF9600;
        color: white
    }

    .popup-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        background-color: #fff;
        gap: 20px;
        /* padding left and right only */
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
        }

        .popup-body {
            min-height: 300px;
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
            height: 80%;
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
            padding: 12px;
            gap: 12px;
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
            width: 45px;
            height: 45px;
            font-size: 13px;
        }

        .pop-up-btn {
            padding: 8px 16px;
            font-size: 14px;
        }
    }

</style>
