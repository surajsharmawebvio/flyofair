<template>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="images/banner/blog-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading" data-text="ABOUT US">Blog</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="common-section bloglist-section">
            <div class="container">
                <div class="row mainrowsec">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-12">
                                <article class="blog-card-item">
                                    <div class="blog-card-image">
                                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600"
                                            alt="Blog post">
                                    </div>
                                    <Link href="/blog/xyzc" class="blog-card-content">
                                        <div class="blog-card-meta">
                                            <!-- <span class="blog-card-date">
                                                <i class="far fa-calendar"></i>
                                                Oct 5, 2025
                                            </span> -->
                                            <span class="blog-card-read-time">
                                                <i class="far fa-clock"></i>
                                                5 min read
                                            </span>
                                        </div>
                                        <h3 class="blog-card-title">The Future of Web Development in 2025</h3>
                                        <p class="blog-card-description">
                                            Explore the latest trends and technologies shaping the future of web
                                            development.
                                            From AI integration to advanced frameworks, discover what's next.
                                        </p>
                                        <div class="blog-card-footer">
                                            <div class="blog-card-author">
                                            </div>
                                            <button class="blog-card-read-more">
                                                Read More <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </Link>
                                </article>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12">
                                <article class="blog-card-item">
                                    <div class="blog-card-image">
                                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600"
                                            alt="Blog post">
                                    </div>
                                    <Link href="/blog/xyzc" class="blog-card-content">
                                        <div class="blog-card-meta">
                                            <span class="blog-card-date">
                                                <i class="far fa-calendar"></i>
                                                Oct 3, 2025
                                            </span>
                                        </div>
                                        <h3 class="blog-card-title">UI/UX Design Principles Every Designer Should Know
                                        </h3>
                                        <p class="blog-card-description">
                                            Master the essential design principles that create intuitive and beautiful
                                            user
                                            experiences. Learn from industry experts and real-world examples.
                                        </p>
                                        <div class="blog-card-footer">
                                            <div class="blog-card-author">
                                            </div>
                                            <button class="blog-card-read-more">
                                                Read More <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </Link>
                                </article>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12">
                                <article class="blog-card-item">
                                    <div class="blog-card-image">
                                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600"
                                            alt="Blog post">
                                    </div>
                                    <Link href="/blog/xyzc" class="blog-card-content">
                                        <div class="blog-card-meta">
                                            <span class="blog-card-date">
                                                <i class="far fa-calendar"></i>
                                                Oct 3, 2025
                                            </span>
                                        </div>
                                        <h3 class="blog-card-title">The Future of Web Development in 2025</h3>
                                        <p class="blog-card-description">
                                            Explore the latest trends and technologies shaping the future of web
                                            development.
                                            From AI integration to advanced frameworks, discover what's next.
                                        </p>
                                        <div class="blog-card-footer">
                                            <div class="blog-card-author">
                                            </div>
                                            <button class="blog-card-read-more">
                                                Read More <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </Link>
                                </article>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12">
                                <article class="blog-card-item">
                                    <div class="blog-card-image">
                                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600"
                                            alt="Blog post">
                                    </div>
                                    <Link href="/blog/xyzc" class="blog-card-content">
                                        <div class="blog-card-meta">
                                            <span class="blog-card-date">
                                                <i class="far fa-calendar"></i>
                                                Oct 3, 2025
                                            </span>
                                        </div>
                                        <h3 class="blog-card-title">The Future of Web Development in 2025</h3>
                                        <p class="blog-card-description">
                                            Explore the latest trends and technologies shaping the future of web
                                            development.
                                            From AI integration to advanced frameworks, discover what's next.
                                        </p>
                                        <div class="blog-card-footer">
                                            <div class="blog-card-author">
                                            </div>
                                            <button class="blog-card-read-more">
                                                Read More <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </Link>
                                </article>
                            </div>
                            <div class="pagination-wrapper">
                                <button class="pagination-arrow" id="prevBtn">
                                    <i class="fas fa-chevron-left"></i>
                                </button>

                                <button class="pagination-btn">1</button>
                                <button class="pagination-btn">2</button>
                                <button class="pagination-btn">3</button>
                                <button class="pagination-btn pagination-active">4</button>
                                <button class="pagination-btn">5</button>

                                <button class="pagination-arrow" id="nextBtn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup>
import './../../css/common.css';
import './../../css/blog.css';
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  blog: {
    type: Object,
    required: true
  }
})
</script>

<style scoped>
    .innerbannerbg img {
        width: 100%;
        height: 200px;
    }
</style>
