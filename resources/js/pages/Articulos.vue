<template>
    <Head>
        <title>FlyOFair | Artículos</title>
        <meta name="description" content="Lee los últimos artículos sobre viajes, consejos de vuelo y destinos turísticos en FlyOFair." />
        <link rel="canonical" href="https://www.flyofair.com/es/articulos/" />
    </Head>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="/images/blogbanner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                        <div class="inner-bannerbox">
                            <h1 class="innercommon-heading">Artículos</h1>
                            <div class="breadcrumb-box">
                                <Link href="/es" class="breadcrumb-home">
                                    <i class="fa fa-home"></i>
                                    <span class="ms-1">Inicio</span>
                                </Link>
                                <span class="breadcrumb-sep">&gt;</span>
                                <span class="breadcrumb-current">Artículos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="common-section bloglist-section">
            <div class="container">
                <div class="row" v-if="props.blogs.length">
                    <div class="col-lg-4 col-md-6 col-12" v-for="blog in props.blogs" :key="blog.id">
                        <article class="blog-card-item">
                            <div class="blog-card-image">
                                <img :src="blog.image" alt="Artículo">
                            </div>
                            <div class="blog-card-content">
                                <h3 class="blog-card-title">{{ blog.title }}</h3>
                                <div class="blog-card-footer">
                                    <Link :href="`/articulos/${blog.slug}`" class="blog-card-read-more">
                                        Leer Más <i class="fas fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pagibox">
                        <small>Mostrando 1 a 9 de 127 resultados</small>
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
        </section>
    </DefaultLayout>
</template>

<script setup>
import './../../css/common.css';
import './../../css/blog.css';
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

const props = defineProps({
  blogs: {
    type: Array,
    required: true
  }
})
</script>

<style scoped>
    /* Breadcrumb under banner (same style as About page) */
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
        color: #ff6b35; /* home icon / primary accent */
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