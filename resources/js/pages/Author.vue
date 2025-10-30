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
        
        <section class="authorbio-section common-section">
            <div class="container">
                <div class="authorbio-card p-4">
                    <div class="row align-items-center difcolor">
                        <!-- Author Image -->
                        <div class="col-md-3 text-center">
                            <img src="https://avatars.mds.yandex.net/i?id=348ec891cb9b141194a6f6c5252ddaf6468600fb-10805306-images-thumbs&n=13" alt="Author"
                                class="authorbio-image rounded-circle">
                        </div>

                        <!-- Author Name -->
                        <div class="col-md-9 text-md-start text-center">
                            <h3 class="authorbio-name mb-3">ALICE WALKER</h3>
                        </div>
                    </div>

                    <!-- About Author -->
                    <div class="authorbio-content mt-4">
                        <h5 class="authorbio-title">ABOUT AUTHOR</h5>
                        <p class="authorbio-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin euismod lacus nec purus
                            dignissim, in tincidunt nulla consequat. Sed porttitor, eros a convallis consequat, ligula
                            augue posuere mi, sed congue nunc nibh nec lectus. Suspendisse tempor justo ut mi cursus,
                            sed consequat risus interdum. Nulla facilisi. Integer luctus, justo a malesuada gravida, mi
                            neque imperdiet nisl, ac consequat nulla velit a justo. Aenean nec ex non lorem venenatis
                            volutpat. Curabitur suscipit ante sit amet cursus facilisis. Nam lacinia, ligula a faucibus
                            feugiat, risus nulla fermentum turpis, ut suscipit lorem libero in orci. Etiam gravida, diam
                            nec egestas pharetra, sem elit porta leo, nec dapibus libero dolor ut est. Vestibulum eget
                            metus nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                            turpis egestas. Ut viverra lectus eu eros varius, in sodales nulla egestas. Phasellus at
                            lacus vitae ex tincidunt lacinia. Donec at facilisis orci. Integer interdum, lorem at
                            bibendum eleifend, ex eros suscipit odio, et tincidunt ante urna sed nisl. Sed eu nisl non
                            elit porta tincidunt ac nec justo Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Proin euismod lacus nec purus dignissim, in tincidunt nulla consequat. Sed porttitor, eros a
                            convallis consequat, ligula augue posuere mi, sed congue nunc nibh nec lectus. Suspendisse
                            tempor justo ut mi cursus, sed consequat risus interdum. Nulla facilisi. Integer luctus,
                            justo a malesuada gravida, mi neque imperdiet nisl, ac consequat nulla velit a justo. Aenean
                            nec ex non lorem venenatis volutpat. Curabitur suscipit ante sit amet cursus facilisis. Nam
                            lacinia, ligula a faucibus feugiat, risus nulla fermentum turpis, ut suscipit lorem libero
                            in orci. Etiam gravida, diam nec egestas pharetra, sem elit porta leo, nec dapibus libero
                            dolor ut est. Vestibulum eget metus nunc.
                        </p>
                    </div>

                    <!-- Social Links -->
                    <div class="authorbio-social mt-4 text-md-start text-center">
                        <h6 class="mb-3 fw-bold">CONNECT WITH ALICE</h6>
                        <a href="#" class="authorbio-social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="authorbio-social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="authorbio-social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="authorbio-social-link"><i class="bi bi-linkedin"></i></a>
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
 
</style>