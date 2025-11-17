<!-- create contact component -->
<template>
    <Head>
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    <DefaultLayout>
        <section class="innerbanner-section">
            <div class="innerbannerbg">
                <img src="/images/banner/contact-banner.jpg" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-12">
                                        <div class="inner-bannerbox">
                                            <h1 class="innercommon-heading" data-text="CONTÁCTANOS">Contáctanos</h1>
                                            <div class="breadcrumb-box">
                                                <Link href="/es" class="breadcrumb-home">
                                                    <i class="fa fa-home"></i>
                                                    <span class="ms-1">Inicio</span>
                                                </Link>
                                                <span class="breadcrumb-sep">&gt;</span>
                                                <span class="breadcrumb-current">Contáctanos</span>
                                            </div>
                                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main>
            <section class="contactus-section py-5">
                <div class="container text-center">
                    <h2 class="contactus-heading mb-2">
                        Cómo puede ponerse en <span>contacto con nosotros?</span> 
                    </h2>
                    <p class="contactus-subtext mb-5">
                        Puede comunicarse con nosotros por teléfono, sitio web, correo postal u otros medios.
                    </p>

                    <div class="row justify-content-center g-4">
                        <!-- Location -->
                        <div class="col-md-4">
                            <div class="contactus-card">
                                <div class="contactus-icon">
                                    <img src="/images/location.png" alt="">
                                </div>
                                <p class="contactus-title">Location</p>
                                <p class="contactus-info">
                                    17875 Von Karman Ave, Suite 150 & 250, Irvine, California, 92614,       United States of America
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <div class="contactus-card">
                                <div class="contactus-icon">
                                    <img src="/images/phone.png" alt="">
                                </div>
                                <p class="contactus-title">Phone</p>
                                <p class="contactus-info">
                                    <a href="tel:+1-877-238-0219">+1-877-238-0219</a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="contactus-card">
                                <div class="contactus-icon">
                                    <img src="/images/email.png" alt="">
                                </div>
                                <p class="contactus-title">Email</p>
                                <p class="contactus-info">
                                    <a href="mailto:contact@flyofair.com">contact@flyofair.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="custom-section common-section">
                <div class="container">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-5">
                            <div class="contact-img-box">
                                <img src="/images/contact-us image.png" alt="" class="img-fluid">
                            </div>
                        </div>
                        <!-- Contact Form -->
                        <div class="col-lg-7">
                            <form class="custom-contact-form">
                                <h2 class="contactus-heading mb-2">
                                    Escriba aquí <span>sus comentarios!</span> 
                                </h2>
                                <p class="contactus-subtext text-start mb-3" style="max-width: 100%;">
                                    Tiene alguna pregunta o sugerencia? Aquí puede escribirnos. Nuestro equipo de FlyOFair se pondrá en contacto con usted.
                                </p>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <input type="text" class="form-control custom-input" placeholder="Tu Nombre">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control custom-input" placeholder="Tu Email">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control custom-input" placeholder="Tu Asunto">
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control custom-input custom-textarea"
                                            placeholder="Tu Mensaje (opcional)"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn common-bgBtn">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Newsletter Box -->


                    </div>
                </div>
            </section>
        </main>
    </DefaultLayout>
</template>

<script setup>
    import DefaultLayout from '@/layouts/DefaultLayout.vue';
    import './../../css/common.css';
    import './../../css/contact.css';
    import { ref } from 'vue';
    import { Link, Head } from '@inertiajs/vue3';

    const form = ref({
        name: '',
        email: '',
        message: ''
    });

    const submitForm = () => {
        // Handle form submission
        console.log('Form submitted:', form.value);
    };

</script>

<style scoped>
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

.contact-section {
  padding: 60px 0;
}

/* Contact form */
.custom-contact-form .custom-input {
    background: rgb(255 255 255);
    border: 1px solid rgb(172 172 172 / 69%);
    border-radius: 10px;
    padding: 10px 12px;
    color: rgba(var(--black-color), 1);
}

.custom-contact-form .custom-textarea {
  height: 140px;
  resize: none;
}

.contactus-section {
  background-color: #f2f8ff;
}

.contactus-heading {
  font-size: 1.8rem;
  font-weight: 700;
  color: #1d2433;
}

.contactus-heading span {
  color: #f39c12;
}

.contactus-subtext {
  color: #4b5563;
  font-size: 0.95rem;
  max-width: 600px;
  margin: 0 auto;
}

.contactus-card {
  background: #fff;
  border-radius: 10px;
  padding: 30px 20px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
  border-bottom: 3px solid transparent;
  transition: all 0.3s ease;
  height: 100%;
}

.contactus-card:hover {
  border-bottom: 3px solid #212529;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.contactus-icon {
  font-size: 2rem;
  color: #007bff;
  margin-bottom: 15px;
}

.contactus-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1d2433;
  margin-bottom: 10px;
}

.contactus-info {
  color: #555;
  font-size: 0.95rem;
  margin: 0;
}
 
</style>