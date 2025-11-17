<!-- make author component -->
<script setup>
    import "./../../css/author.css";
    import DefaultLayout from '@/layouts/DefaultLayout.vue'
    import {
        Link
    } from '@inertiajs/vue3';

</script>

<template>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="/images/banner/author-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading">author</h1>
                            <div class="breadcrumb-box">
                                <Link href="/" class="breadcrumb-home">
                                <i class="fa fa-home"></i>
                                <span class="ms-1">Home</span>
                                </Link>
                                <span class="breadcrumb-sep">&gt;</span>
                                <span class="breadcrumb-current">Author</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="authorbio-section common-section">
            <div class="container">
                <div class="authorbio-card p-4">
                    <div class="row align-items-center difcolor">
                        <!-- Author Image -->
                        <div class="col-md-3 text-center">
                            <img src="/images/author-profile.jpg"
                                alt="Author" class="authorbio-image rounded-circle">
                        </div>

                        <!-- Author Name -->
                        <div class="col-md-9 text-md-start text-center">
                            <h3 class="authorbio-name mb-3">ALICE WALKER</h3>
                        </div>
                    </div>

                    <!-- About Author -->
                    <div class="authorbio-content mt-4">
                        <p class="authorbio-title">ABOUT AUTHOR</p>
                        <p class="authorbio-text">
                            Hi, I am Alice Walker. I am a solo traveler and share my experiences by writing stories. Well, I have 8 Years
                             of experience as a travel and aviation researcher. With a strong understanding of aviation trends and 
                             traveler behavior ,I’m aiming to simplify complex flight policy and inspire travelers to fly frequently.
                              With my  insightful guide on flight policy,cancellation, changing flight, and how to change the name on 
                              the ticket, etc. You will get each and every detailed information on the aviation industry only at FlyOFair
                               in an easy way without making it complex. Join me for trusted travel tips and honest aviation insights.
                        </p>
                    </div>

                    <!-- Social Links -->
                    <div class="authorbio-social mt-4 text-md-start text-center">
                        <h6 class="mb-3 fw-bold">CONNECT WITH ALICE</h6>
                        <!-- <a href="https://x.com/FlyoFair" target="_blank" class="authorbio-social-link"><i class="fab fa-x-twitter"></i></a> -->
                        <a href="https://www.facebook.com/people/Flyofair/61583235514966/" target="_blank" class="authorbio-social-link"><i class="fab fa-facebook-f"></i></a>
                        <!-- <a href="https://www.instagram.com/flyofair/" target="_blank" class="authorbio-social-link"><i class="fab fa-instagram"></i></a> -->
                        <!-- <a href="https://www.pinterest.com/flyofair/" target="_blank" class="authorbio-social-link"><i class="fab fa-pinterest"></i></a> -->
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>
<style scoped>
    .authorbio-card {
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .authorbio-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    .authorbio-name {
        color: #cc5520;
        font-weight: 700;
        font-size: 50px;
        letter-spacing: 1px;
    }

    .authorbio-title {
        font-weight: 700;
        color: #000;
        border-bottom: 2px solid #ccc;
        display: inline-block;
        font-size: 35px;
        padding-bottom: 3px;
        margin-bottom: 17px;
    }

    .authorbio-text {
        color: #000000;
        font-size: 18px;
        line-height: 1.3;
    }

    .authorbio-social-link {
        display: inline-block;
        font-size: 1.2rem;
        color: #333;
        margin-right: 15px;
        transition: 0.3s;
    }

    .authorbio-social-link:hover {
        color: #cc5520;
        transform: scale(1.1);
    }

    .difcolor {
        background: #d9d9d9;
        padding: 30px 0px;
        border-radius: 20px;
    }

    /* Breadcrumb under banner */
    .breadcrumb-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 12px;
        color: #ffffffcc;
        font-size: 14px;
    }

    .breadcrumb-box .breadcrumb-home {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #ff6b35;
        /* home icon / primary accent */
        font-weight: 600;
        text-decoration: none;
    }

    .breadcrumb-box .breadcrumb-home i {
        font-size: 14px;
        color: #ff6b35;
    }

    .breadcrumb-box .breadcrumb-sep {
        color: #ffffff99;
        font-weight: 600;
    }

    .breadcrumb-box .breadcrumb-current {
        color: #ffffff;
        font-weight: 600;
    }

</style>
