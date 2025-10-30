<!-- create about component using default layout -->
<script setup>
    import "./../../css/about.css";
    import DefaultLayout from '@/layouts/DefaultLayout.vue'

</script>

<template>
    <DefaultLayout>

        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="/images/blogbanner.jpg" alt="about banner">
            </div>
        </section>

        <section class="common-section abouttext-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="section-header text-start">
                            <div class="subspan">
                                About Us
                            </div>
                            <h2 class="mb-2">Helping businesses
                                deliver <span class="text-primary text-primarysec text-decoration-underline">buyer
                                    experiences.</span>
                                Your Travel</h2>
                            <p class="sub-title">Vidyard is the leading video messaging and asynchronous
                                communications platform for go-to-market teams. Millions of sales
                                professionals and more than 250,000 go-to-market teams use Vidyard’s
                                AI-powered video messaging, video hosting, and digital sales rooms to
                                connect with more prospects and generate more revenue.</p>
                            <a href="#" class="btn common-bgBtn">Get the latest updates</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="adventure-experience">
                            <img src="/images/about/about-image-1.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ai-section common-section">
            <div class="backtexbox">
                <!-- <img src="images/group-doodle.png" alt=""> -->
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <!-- Left Text -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <h2 class="ai-title">
                            Built for go-to-market teams, powered by AI
                        </h2>
                    </div>

                    <!-- Right Box -->
                    <div class="col-md-6">
                        <div class="ai-box">
                            <p>
                                We believe in the power of video to foster human connections and empower
                                go-to-market professionals to deliver trusted and productive buyer experiences.
                            </p>
                            <p>
                                We also believe in the power of AI to help sales and marketing teams unlock
                                their creativity and connect with more prospects than ever before.
                            </p>
                            <p>
                                We’re committed to helping our customers grow their revenue faster by
                                unleashing the potential of video and AI.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>
<style scoped>
    /* <<<<<< ************* ABOUT TEXT SECTION CSS START **************** >>>>>> */
    .abouttext-section {
        background-color: rgba(var(--black-color), 0.03);
    }

    /* Main container */
    .adventure-experience {
        display: flex;
        gap: 20px;
        justify-content: end;
    }

    /* Left column */
    .adventure-left {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Info box */
    .adventure-info-box {
        background-color: rgba(var(--second-color), 1);
        color: rgba(var(--black-color), 1);
        padding: 40px 20px;
        border-top-left-radius: 50px;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
    }

    .adventure-info-box p {
        margin-bottom: 0;
    }

    /* Sailing image */
    .adventure-sailing-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom-left-radius: 50px;
    }

    /* Right column */
    .adventure-right {
        flex: 1;
    }

    /* Kayaking image */
    .adventure-kayaking-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
    }

    .about-list1 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin: 0px;
        padding: 0px;
        list-style: none;
    }

    .about-list1 li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 5px;
        margin-right: 15px;
        font-size: 14px;
        color: rgba(var(--black-color), 1);
        font-weight: 500;
    }

    .about-list1 li::before {
        content: "";
        width: 6px;
        height: 6px;
        background-color: rgba(var(--second-color), 1);
        position: absolute;
        left: 5px;
        top: 10px;
        outline: 5px solid rgba(var(--second-color), 0.4);
        border-radius: 50%;
    }

    /* <<<<<< ************* ABOUT TEXT SECTION CSS END  **************** >>>>>> */
    .ai-section {
        background-color: #f7f9fc;
    }

    .ai-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1c1f26;
        line-height: 1.3;
    }

    .ai-box {
        border: 1px solid #222;
        border-radius: 10px;
        background: #fff;
        padding: 25px 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        font-size: 0.95rem;
        line-height: 1.6;
        color: #333;
    }

    .ai-box p:not(:last-child) {
        margin-bottom: 10px;
    }

    @media (max-width: 1366px) {
        .custom-counter-box {
            min-height: 186px;
        }
    }

    @media (max-width: 1024px) {
        .benefit-title {
            font-size: 16px;
        }

        .benefit-text {
            font-size: 13px;
        }
    }

    @media (max-width: 991px) {
        .adventure-sailing-img {
            height: 150px;
        }

        .adventure-info-box {
            padding: 20px;
        }

        .adventure-experience {
            gap: 12px;
            margin-bottom: 24px;
        }

        .section-header {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 767px) {
        .custom-counter-number {
            font-size: 30px;
        }

        .custom-counter-box {
            min-height: 100%;
        }

        .custom-accordion .accordion-button {
            font-size: 14px;
        }
    }

    @media (max-width: 580px) {
        .about-list1 li {
            font-size: 12px;
            line-height: normal;
        }

        .common-section {
            padding: 30px 0px;
        }

        .adventure-info-box {
            font-size: 14px;
        }

        .custom-counter-desc {
            font-size: 13px;
        }

        .custom-counter-box p {
            font-size: 13px;
        }

        .custom-counter-number {
            font-size: 24px;
        }

        .custom-counter-box {
            padding: 10px;
        }

        .adventure-left {
            gap: 10px;
        }
    }

    @media (max-width: 380px) {
        .custom-accordion .accordion-button {
            font-size: 13px;
        }
    }

    .backtexbox {
        position: absolute;
        width: 30%;
        height: 200%;
        left: 0;
        top: 0px;
    }

    .backtexbox img {
        object-fit: contain;
        height: 405px;
    }

</style>
