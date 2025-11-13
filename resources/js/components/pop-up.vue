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
                        <a href="tel:+1234567890" class="pop-up-btn">call now</a>
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
                            <p>Quick Support from <strong>Our Experts</strong></p>
                        </div>
                        <div>
                            <img src="/images/popup/34.png" alt="popup image">
                            <p>Quick Support from <strong>Our Experts</strong></p>
                        </div>
                        <div>
                            <img src="/images/popup/37.png" alt="popup image">
                            <p>Quick Support from <strong>Our Experts</strong></p>
                        </div>
                    </div>
                    <div class="btn-contact" style="margin-top: 20px; text-align: center;">
                        <a href="#" class="pop-up-btn">Contact a Travel Expert</a>
                    </div>
                    <div class="subscribe">
                      <label for="subscribe">Stay Updated:</label>
                      <div>
                        <input type="email" id="subscribe" placeholder="Enter your email">
                        <a href="#" class="pop-up-btn-2">Subscribe</a>
                      </div>
                    </div>
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
                    <a href="https://www.facebook.com" target="_blank" class="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://x.com" target="_blank" class="twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="linkedin">
                        <i class="fab fa-linkedin-in"></i>
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

    .social-icons a.youtube {
        background-color: #ff0000;
    }

    .social-icons a.linkedin {
        background-color: #0077b5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .popup-footer {
            flex-direction: column;
            gap: 15px;
        }

        .brand-icons {
            justify-content: center;
        }

        .brand-icons img {
            max-width: 60px;
        }
    }

    @media (max-width: 480px) {
        .popup-overlay {
            padding: 10px;
        }

        .brand-icons img {
            max-width: 50px;
        }

        .social-icons a {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
    }

</style>
