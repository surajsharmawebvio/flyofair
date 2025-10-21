<!-- create about component using default layout -->
<script setup>
    import "./../../css/about.css";
    import DefaultLayout from '@/layouts/DefaultLayout.vue'
</script>

<template>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="images/banner/about-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading" data-text="ABOUT US">About Us</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="common-section abouttext-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="adventure-experience">
                            <div class="adventure-left">
                                <div class="adventure-info-box">
                                    <p><strong>15 Years of<br>Experience</strong></p>
                                </div>
                                <img src="images/about/montreal_destination_banner.webp" alt="Sailing Experience"
                                    class="adventure-sailing-img">
                            </div>
                            <div class="adventure-right">
                                <img src="images/about/toure-3.webp" alt="Kayaking Experience"
                                    class="adventure-kayaking-img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="section-header text-start">
                            <h2 class="mb-2">We Are <span
                                    class="text-primary text-primarysec text-decoration-underline"> The Best For</span>
                                Your Travel</h2>
                            <p class="sub-title">Blienum nhaedrum torquatos nec eul, vis detraxit periculis ex, nihil is
                                in mei. Xei an periculaeuripidis, fincartem ei est. Dlienum phaed is in mei. Lei an
                                Hericulaeuripidis, hincartem ei est.</p>

                            <p class="sub-title">Blienum nhaedrum torquatos nec eul, vis detraxit periculis ex, nihil is
                                in mei. Xei an
                                periculaeuripidis, fincartem ei est. Dlienum phaed is in mei. Lei an Hericulaeuripidis,
                                hincartem ei est. Blienum nhaedrum torquatos nec e </p>
                            <ul class="about-list1">
                                <li>Mei an periculaeuripidis.</li>
                                <li>Blienum nhaedrum tortos.</li>
                                <li>torquatos nec euls vis.</li>
                                <li>Lorem ipsum dolor sit am.</li>
                                <li>Dlienum phaed is in meis.</li>
                                <li>peric uripidis, fincartem.</li>
                                <li>pericu laeuri pidis Mei sm.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="common-section offer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="javascript:void(0)" class="card-banner-slide">
                            <div class="card-image"></div>
                            <div class="card-info">
                                <h6>We Make Every<br>Trips Special</h6>
                                <div class="box-button"><button class="btn offerbtn" href="#">View More <i
                                            class="fa-solid fa-arrow-right-long"></i>
                                    </button></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="javascript:void(0)" class="card-banner-slide offercard2">
                            <div class="card-image"></div>
                            <div class="card-info">
                                <h6>We Make Every<br>Trips Special</h6>
                                <div class="box-button"><button class="btn offerbtn" href="#">View More <i
                                            class="fa-solid fa-arrow-right-long"></i>
                                    </button></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="javascript:void(0)" class="card-banner-slide offercard3">
                            <div class="card-image"></div>
                            <div class="card-info">
                                <h6>We Make Every<br>Trips Special</h6>
                                <div class="box-button"><button class="btn offerbtn" href="#">View More <i
                                            class="fa-solid fa-arrow-right-long"></i>
                                    </button></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="custom-counter-section common-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Text Content -->
                    <div class="col-lg-6">
                        <div class="section-header custom-counter-title text-start">
                            <h2>We Are <span class="text-primary text-primarysec text-decoration-underline"> The Best
                                    For</span>
                                Your Travel</h2>
                            <p class="custom-counter-desc mb-1">
                                Leverage the power of an integrated identity management solution. Focus on your business
                                prospects, not on mundane administrative chores. Gain complete control, stay compliant,
                                minimize operational overheads, and herald the age of digital agility.
                            </p>
                            <p class="custom-counter-desc">
                                Leverage the power of an integrated identity management solution. Focus on your business
                                prospects, not on mundane administrative chores. Gain complete control, stay compliant,
                                minimize operational overheads, and herald the age of digital agility.
                            </p>
                            <div class="custom-counter-buttons">
                                <a href="#" class="btn common-bgBtn"> <i class="fa-solid fa-phone"></i> Try the solution
                                    today</a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Counters -->
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="custom-counter-box gradient-orange">
                                    <div class="custom-counter-number" data-target="500" data-unit="k">0</div>
                                    <p>Reduction in identity management</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-counter-box gradient-red">
                                    <div class="custom-counter-number" data-target="980" data-unit="k">0</div>
                                    <p>Improvement in Employee satisfaction</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-counter-box gradient-red">
                                    <div class="custom-counter-number" data-target="970" data-unit="k">0</div>
                                    <p>Fewer security related incidences</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-counter-box gradient-orange">
                                    <div class="custom-counter-number" data-target="300" data-unit="k">0</div>
                                    <p>Lightning fast authentication</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="update-section common-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="update-sec">
                            <div class="section-header text-center">
                                <h2 class="mb-1">Make Your Next Journey The Best One!</h2>
                                <p class="sub-title">Reach out to us for making travelling happen now to some of the
                                    best places
                                    of the globe. </p>
                            </div>
                            <div class="input-group justify-content-center mx-auto">
                                <a href="tel:(844) 933-1926" class="linkbtn">
                                    (844) 933-1926
                                </a>
                            </div>
                            <div class="update-bg">
                                <img src="images/update-bg.png" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="trevana-benefits common-section text-center">
            <div class="textureimage02">
                <img src="images/footer-bg-1-1.png" alt="">
            </div>
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="mb-2">Travel Benefits <span
                            class="text-primary text-primarysec text-decoration-underline">You
                            Can Trust</span>
                    </h2>
                </div>
                <div class="row g-4">

                    <!-- Item 1 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="benefit-item">
                            <img src="images/about/f1.png" alt="24/7 support icon" class="benefit-icon mb-3">
                            <h5 class="benefit-title fw-semibold">Best Price Guarantee</h5>
                            <p class="benefit-text">We offer competitive rates every time</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="benefit-item">
                            <img src="images/about/f2.png" alt="Reward icon" class="benefit-icon mb-3">
                            <h5 class="benefit-title fw-semibold">Trusted by Thousands</h5>
                            <p class="benefit-text">Reliable service you can count on</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="benefit-item">
                            <img src="images/about/f3.png" alt="Reviews icon" class="benefit-icon mb-3">
                            <h5 class="benefit-title fw-semibold">Wide Range of Destinations</h5>
                            <p class="benefit-text">Wide Range of Destinations</p>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="benefit-item">
                            <img src="images/about/f4.png" alt="Plan icon" class="benefit-icon mb-3">
                            <h5 class="benefit-title fw-semibold">Easy Booking Process</h5>
                            <p class="benefit-text">Instant and smooth reservation process</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="common-section faq-section">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="section-header text-center">
                            <h2 class="mb-2">Everything You Wonder <span
                                    class="text-primary text-primarysec text-decoration-underline">About
                                    Cruises:</span>
                                Answered Here</h2>
                        </div>
                        <div class="accordion custom-accordion" id="accordionExample">

                            <!-- Accordion Item 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span>What is included in the cruise package?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Our cruise packages typically include accommodation, meals, entertainment,
                                            and access to onboard activities. Some packages also include shore
                                            excursions and drinks. Check your specific package details.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span>What should I pack for the cruise?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Bring comfortable clothing for daytime activities, formal wear for dinners,
                                            swimwear, toiletries, and any personal items you need. Don’t forget your
                                            travel documents and a hat or sunscreen for sunny days.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <span>What happens if the cruise is cancelled?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            In case of cancellation due to unforeseen circumstances, we offer full
                                            refunds or the option to reschedule your cruise. We will inform you promptly
                                            and assist with your preferred option to ensure a smooth process.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        <span>Do I need a visa to join the cruise?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Visa requirements depend on your nationality and the cruise itinerary. We
                                            recommend checking the visa policies for each port of call and consulting
                                            with your local embassy before booking.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        <span>What safety measures are in place on board?</span>
                                        <i class="icon fas fa-eye-slash ms-auto"></i>
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="sub-title">
                                            Safety is our top priority. We adhere to strict health protocols,
                                            including regular sanitation, safety drills, and trained crew members to
                                            ensure a secure and protected environment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>
<style scoped>
.about-section {
    padding: 40px 0;
    text-align: center;
}
.about-title {
    font-size: 36px;
    margin-bottom: 20px;
}
</style>