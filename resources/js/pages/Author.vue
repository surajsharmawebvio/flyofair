<!-- make author component -->
<script setup>
    import "./../../css/author.css";
    import DefaultLayout from '@/layouts/DefaultLayout.vue'
</script>

<template>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="images/banner/author-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading">author</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="common-section author-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-12">
                        <div class="author-card">
                            <div class="author-img">
                                <img src="images/author.jpg" alt="">
                            </div>
                            <div class="author-name">
                                <h3>Joanna Lobo</h3>
                            </div>
                            <div class="addressbox">
                                <i class="bi bi-geo-alt"></i>
                                kolkata,India
                            </div>
                            <ul class="sociallist">
                                <li> <a href="javascript:void(0)" target="_blank"><i
                                            class="fa-brands fa-square-facebook"></i></a></li>
                                <li><a href="javascript:void(0)" target="_blank"><i
                                            class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="javascript:void(0)" target="_blank"><i
                                            class="fa-brands fa-youtube"></i></a></li>
                                <li><a href="javascript:void(0)" target="_blank"><i class="bi bi-twitter-x"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="authorabout-contentbox">
                            <div class="author-text-title">
                                <h3>About Joanna</h3>
                            </div>
                            <div class="author-para">
                                <p>
                                    I am an independent journalist and editor from Goa, India. Travel is a big part of
                                    my life and one of the few things that brings me absolute joy, especially exploring
                                    a destination through its food (mainly) and its weird museums, cemeteries and even
                                    myths and legends. I am currently on a mission to explore and document the different
                                    aspects of my home, with a focus on its cuisine. My work can be found scattered
                                    across India's leading publications, and many international ones. I am currently an
                                    editor at a beloved Indian food magazine, and run a Twitter/X account dedicated to
                                    freelancing. Aside from work, I enjoy the experience (and titles) of being a dog
                                    mom, and a godmother.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-12">
                        <div class="related-posts-list">
                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">How to Travel on a Budget: Affordable
                                        Destinations &amp; Tips</h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Top 10 Hidden Gems in Europe You Must Visit
                                    </h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Essential Travel Gear for Your Next Adventure
                                    </h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">How to Travel on a Budget: Affordable
                                        Destinations &amp; Tips</h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Top 10 Hidden Gems in Europe You Must Visit
                                    </h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Essential Travel Gear for Your Next Adventure
                                    </h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">How to Travel on a Budget: Affordable
                                        Destinations &amp; Tips</h4>
                                    <div class="related-post-meta">
                                        <span class="related-post-author">
                                            <i class="far fa-clock"></i>
                                            9 min read
                                        </span>
                                        ||
                                        <span class="related-post-date">
                                            <i class="far fa-calendar"></i>
                                            14 May 2025
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>
<style scoped>
</style>