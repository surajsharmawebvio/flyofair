<!-- Banner pop-up component (uses v-model: modelValue for visibility) -->
<template>
    <div class="popup-overlay" v-if="isVisible" @click="closePopUp">
        <div class="popup-container">
            <!-- Close button -->
            <button class="popup-close" @click="closePopUp" aria-label="Close popup">
                <i class="fas fa-times"></i>
            </button>

            <!-- Left Side -->
            <div class="popup-left">
                <div class="logo-box">
                    <div class="iata-container">
                        <div class="globe-wings">
                            <div class="wing wing-left"></div>
                            <div class="globe">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div class="wing wing-right"></div>
                        </div>
                        <div class="iata-text">IATA</div>
                    </div>
                </div>

                <div class="clia-box">
                    <div class="clia-text">CLIA</div>
                </div>

                <div class="asta-box">
                    <div class="asta-text">asta</div>
                </div>

                <div class="trustpilot-box">
                    <div class="trustpilot-title">
                        <i class="bi bi-star-fill"></i>
                        <span>Trustpilot</span>
                    </div>
                    <div class="trustpilot-stars">
                        ★★★★★
                    </div>
                </div>
            </div>

            <!-- Middle Section -->
            <div class="popup-middle">
                <div class="brand-header">
                    <i class="bi bi-airplane-fill brand-icon"></i>
                    <span class="brand-name">FlyerFair</span>
                </div>

                <h2>YOUR JOURNEY<br>STARTS HERE</h2>
                <p class="subtitle">Lets us handle the details</p>

                <div class="buttons-container">
                    <button class="call-btn">
                        <span class="icon-circle">
                            <i class="bi bi-telephone-fill"></i>
                        </span>
                        <span>Call an agent</span>
                    </button>

                    <button class="call-btn btn-flights">
                        <span class="icon-circle">
                            <i class="bi bi-search"></i>
                        </span>
                        <span>Find Flights</span>
                    </button>

                    <button class="call-btn">
                        <span class="icon-circle">
                            <i class="bi bi-telephone-fill"></i>
                        </span>
                        <span>Call an agent</span>
                    </button>
                </div>

                <Link href="/contact-us" class="request-btn" @click="closePopUp">
                    <span>Request a call back</span>
                    <i class="bi bi-arrow-right"></i>
                </Link>
            </div>

            <!-- Right Section -->
            <div class="popup-right">
                <h4>UNLOCK YOUR ADVENTURE</h4>
                <p class="subtitle">Lorem ipsum dolor sit amet, consectetur</p>

                <div class="icon-grid">
                    <div class="icon-box">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-credit-card-fill"></i>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/vue3';

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
      max-width: 700px;
      width: 100%;
      background: #fff;
      border-radius: 0;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
      display: flex;
      height: auto;
      position: relative;
    }

    /* Close Button */
    .popup-close {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #fff;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .popup-close:hover {
      background: #f8f9fa;
      transform: scale(1.1);
    }

    .popup-close i {
      color: #6c757d;
      font-size: 16px;
    }

    /* Left Orange Section */
    .popup-left {
      background: linear-gradient(180deg, #ff9d2e 0%, #ff8c1a 100%);
      width: 120px;
      min-width: 120px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 10px;
      gap: 18px;
    }

    .logo-box {
      background: white;
      padding: 12px 10px;
      border-radius: 8px;
      width: 100%;
      text-align: center;
    }

    .iata-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px;
    }

    .globe-wings {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0;
      margin-bottom: 3px;
    }

    .wing {
      width: 32px;
      height: 2.5px;
      background: #003d7a;
    }

    .wing-left {
      transform: rotate(-12deg);
      margin-right: -8px;
    }

    .wing-right {
      transform: rotate(12deg);
      margin-left: -8px;
    }

    .globe {
      width: 42px;
      height: 42px;
      background: #003d7a;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .globe i {
      color: white;
      font-size: 20px;
    }

    .iata-text {
      font-size: 28px;
      font-weight: 900;
      color: #003d7a;
      letter-spacing: 1px;
      line-height: 1;
    }

    .clia-box {
      background: #2d2d3a;
      padding: 10px 15px;
      border-radius: 6px;
      width: 100%;
      text-align: center;
    }

    .clia-text {
      color: white;
      font-size: 24px;
      font-weight: 900;
      font-style: italic;
      line-height: 1;
    }

    .asta-box {
      background: #0098d8;
      padding: 10px 15px;
      border-radius: 6px;
      width: 100%;
      text-align: center;
    }

    .asta-text {
      color: white;
      font-size: 22px;
      font-weight: 700;
      line-height: 1;
    }

    .trustpilot-box {
      text-align: center;
      color: white;
      margin-top: auto;
      padding-top: 10px;
    }

    .trustpilot-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .trustpilot-stars {
      color: #00b67a;
      font-size: 18px;
      letter-spacing: 1px;
    }

    /* Middle Section */
    .popup-middle {
      flex: 1;
      padding: 24px 20px;
      background: white;
      display: flex;
      flex-direction: column;
    }

    .brand-header {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 18px;
    }

    .brand-icon {
      color: #dc3545;
      font-size: 26px;
      transform: rotate(-45deg);
    }

    .brand-name {
      font-size: 18px;
      font-weight: 700;
      color: #333;
    }

    .popup-middle h2 {
      font-weight: 900;
      font-size: 24px;
      line-height: 1.15;
      margin-bottom: 3px;
      color: #1a1a2e;
      letter-spacing: -0.5px;
    }

    .popup-middle > .subtitle {
      color: #777;
      margin-bottom: 20px;
      font-size: 13px;
    }

    .buttons-container {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 15px;
    }

    .call-btn {
      background: linear-gradient(135deg, #ffb84d 0%, #ff9d2e 100%);
      color: #000;
      border-radius: 50px;
      padding: 13px 18px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
      border: none;
      box-shadow: 0 2px 6px rgba(255, 140, 0, 0.25);
      width: 100%;
      justify-content: flex-start;
      transition: all 0.2s ease;
      cursor: pointer;
      font-size: 15px;
    }

    .call-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(255, 140, 0, 0.35);
    }

    .call-btn .icon-circle {
      background-color: white;
      color: #ff8c1a;
      border-radius: 50%;
      padding: 0;
      font-size: 18px;
      width: 36px;
      height: 36px;
      min-width: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .call-btn.btn-flights {
      background: white;
      border: 2px solid #e8e8e8;
      color: #333;
      box-shadow: none;
    }

    .call-btn.btn-flights:hover {
      border-color: #ff9d2e;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .call-btn.btn-flights .icon-circle {
      background: linear-gradient(135deg, #ffb84d 0%, #ff9d2e 100%);
      color: white;
    }

    .request-btn {
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 13px 18px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: #333;
      background: #fff;
      text-decoration: none;
      margin-top: 8px;
      transition: all 0.2s ease;
      font-size: 15px;
    }

    .request-btn:hover {
      border-color: #ff9d2e;
      color: #ff9d2e;
    }

    .request-btn i {
      color: #ff9d2e;
      font-size: 20px;
      font-weight: bold;
    }

    /* Right Section */
    .popup-right {
      width: 220px;
      min-width: 220px;
      background: linear-gradient(180deg, #fff9f0 0%, #fff5e6 100%);
      padding: 24px 18px;
      display: flex;
      flex-direction: column;
    }

    .popup-right h4 {
      font-weight: 900;
      font-size: 18px;
      margin-bottom: 5px;
      color: #1a1a2e;
      letter-spacing: -0.3px;
    }

    .popup-right > .subtitle {
      color: #999;
      margin-bottom: 22px;
      font-size: 12px;
      line-height: 1.4;
    }

    .icon-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }

    .icon-box {
      border: 2px solid #ffe8cc;
      border-radius: 10px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 60px;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .icon-box:hover {
      border-color: #ff9d2e;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 157, 46, 0.15);
    }

    .icon-box i {
      font-size: 24px;
      color: #1a1a2e;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .popup-container {
        flex-direction: column;
        max-width: 400px;
      }

      .popup-left {
        width: 100%;
        flex-direction: row;
        padding: 15px;
        justify-content: space-around;
        gap: 10px;
      }

      .popup-right {
        width: 100%;
      }

      .logo-box,
      .clia-box,
      .asta-box {
        width: auto;
        min-width: 60px;
      }

      .trustpilot-box {
        margin-top: 0;
        padding-top: 0;
      }

      .popup-middle h2 {
        font-size: 20px;
      }

      .brand-name {
        font-size: 16px;
      }
    }

    @media (max-width: 480px) {
      .popup-overlay {
        padding: 10px;
      }

      .popup-container {
        max-width: 95vw;
      }

      .popup-middle {
        padding: 20px 15px;
      }

      .popup-right {
        padding: 20px 15px;
      }

      .popup-middle h2 {
        font-size: 18px;
      }

      .buttons-container {
        gap: 8px;
      }

      .call-btn {
        padding: 10px 15px;
        font-size: 14px;
      }

      .request-btn {
        padding: 10px 15px;
        font-size: 14px;
      }
    }
</style>
