<!-- Banner pop-up component (uses v-model: modelValue for visibility) -->
<template>
    <div class="pop-up" v-if="isVisible" @click="closePopUp">
        <div class="pop-up-content" @click.stop>
            <!-- <button class="close-button" @click="closePopUp" aria-label="Close popup">&times;</button> -->

            <div class="banner">
                <div class="inner-banner">
                    <h2>Hey! We’re here to guide you through your booking journey</h2>
                    <p class="sub">Don’t Let These Deals Fly Away!</p>

                    <a href="tel:+1-877-238-0219" class="phone-box">
                        <img src="https://flagcdn.com/w40/us.png" alt="US Flag">
                        +1-877-238-0219
                    </a>

                    <div class="or">or</div>

                    <Link href="/contact-us" class="call-btn" >
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        Request a Call Back
                    </Link>

                    <br>

                    <!-- pop-up footer image -->
                    <div class="pop-up-footer">
                        <div class="footer col-12 col-md-6">
                            <img src="/images/popup/4.png" alt="IATA">
                            <img src="/images/popup/3.png" alt="CLIA">
                            <img src="/images/popup/2.png" alt="ASTA">
                            <img src="/images/popup/1.png" alt="Trustpilot">
                        </div>

                        <div class="socials col-12 col-md-6">
                            <a href="https://x.com/FlyoFair" target="_blank" aria-label="twitter"><i class="fab fa-x-twitter"></i></a>
                            <a href="https://www.facebook.com/people/Flyofair/61583235514966/" target="_blank" aria-label="facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/flyofair/" target="_blank" aria-label="instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.pinterest.com/flyofair/" target="_blank" aria-label="pinterest"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'PopUp',
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
    /* Modal backdrop */
    .pop-up {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        padding: 20px;
    }

    .pop-up-content {
        position: relative;
        max-width: 800px;
        width: 50%;
    }

    .close-button {
        position: absolute;
        right: 8px;
        top: -8px;
        background: #fff;
        border-radius: 50%;
        border: none;
        width: 40px;
        height: 40px;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* Banner styles adapted from pop-up.html (scoped) */
    .banner {
        background: url('./../../../public/images/popup-background.png') no-repeat center center;
        background-size: cover;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        color: #333;
        padding: 28px 24px;
        text-align: center;
        position: relative;
        padding: 5px;
    }

    .inner-banner{
        border: 3px solid #e69c24;
        border-radius: 14px;
        padding: 4px;
        min-height: 450px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 14px;
        z-index: 1;
    }

    .banner>* {
        position: relative;
        z-index: 2;
    }

    .banner h2 {
        margin: 0 0 8px 0;
        font-size: 22px;
        color: #2f2f2f;
    }

    .banner .sub {
        margin: 0 0 18px 0;
        font-size: 16px;
        color: #e88a13;
        font-weight: 600;
    }

    .phone-box {
        background: #1a73e8;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .phone-box img {
        width: 28px;
        height: 18px;
        border-radius: 3px;
    }

    .or {
        margin: 16px 0;
        font-size: 16px;
        font-weight: 500;
        color: #444;
    }

    .call-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f78c1e;
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .call-btn:hover {
        background: #d67814;
    }

    .call-btn i {
        font-style: normal;
    }

    .footer {
        display: flex;
        justify-content: flex-start;
        gap: 14px;
        align-items: center;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .footer img {
        height: 35px;
    }

    .socials {
        display: flex;
        gap: 12px;
        margin-top: 12px;
        justify-content: flex-end;
    }

    .socials a {
        color: #fff;
        background: #1877f2;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        font-size: 20px;
    }

    .socials a:nth-child(1) {
        background: #000
    }

    .socials a:nth-child(2) {
        background: #1877f2
    }

    .socials a:nth-child(3) {
        background: #e1306c
    }

    .socials a:nth-child(4) {
        background: #bd081c
    }

    /* small responsive tweaks */
    @media (max-width:600px) {
        .banner h2 {
            font-size: 18px
        }

        .phone-box {
            padding: 10px 14px;
            font-size: 16px
        }
    }

.pop-up-footer {
    display: flex;
    position: absolute;
    bottom: 20px;
    width: 90%;
}
</style>
