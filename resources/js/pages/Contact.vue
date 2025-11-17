<!-- create contact component -->
<template>
    <Head>
        <title>FlyOFair | Contact Us</title>
        <meta name="description" content="Passengers worldwide can connect with FlyOFair at +1-877-238-0219 and receive full-proff assistance from expert travel agents 24/7." />
        <link rel="canonical" href="https://www.flyofair.com/contact-us/" />
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
                            <h1 class="innercommon-heading" data-text="CONTACT US">Contact Us</h1>
                            <div class="breadcrumb-box">
                                <Link href="/" class="breadcrumb-home">
                                <i class="fa fa-home"></i>
                                <span class="ms-1">Home</span>
                                </Link>
                                <span class="breadcrumb-sep">&gt;</span>
                                <span class="breadcrumb-current">Contact Us</span>
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
                        How can you <span>connect with us?</span>
                    </h2>
                    <p class="contactus-subtext mb-5">
                        You can reach out to us by phone, website, mail, or other means.
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
                            <form @submit.prevent="submitForm" class="custom-contact-form">
                                <h3 class="contactus-heading mb-2">
                                    Write Your <span>Thoughts Here!</span>
                                </h3>
                                <p class="contactus-subtext text-start mb-3" style="max-width: 100%;">
                                    Do you have any queries or suggestions? Here you can write to us. Our FlyOFair team will connect with you.
                                </p>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input v-model="form.name" type="text" class="form-control custom-input" placeholder="Your Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input v-model="form.email" type="email" class="form-control custom-input" placeholder="Your Email" required>
                                    </div>
                                    <div class="col-6">
                                        <input v-model="form.phone" type="text" class="form-control custom-input" placeholder="Your Phone">
                                    </div>
                                    <div class="col-md-6">
                                        <input v-model="form.subject" type="text" class="form-control custom-input" placeholder="Your Subject" required>
                                    </div>
                                    <div class="col-12">
                                        <textarea v-model="form.message" class="form-control custom-input custom-textarea"
                                            placeholder="Your Message(optional)"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn common-bgBtn" :disabled="loading">
                                            <span v-if="!loading">Submit</span>
                                            <span v-else>Please wait...</span>
                                        </button>
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
    import {
        ref
    } from 'vue';
    import {
        Link,
        Head
    } from '@inertiajs/vue3';
    import axios from 'axios';
    import Swal from 'sweetalert2';

    // Configure axios defaults
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.withCredentials = true;

    // Get CSRF token from meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }

    const form = ref({
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
    });

    const loading = ref(false);

    const submitForm = async () => {
        // Validate required fields
        if (!form.value.name || !form.value.email || !form.value.subject) {
            await Swal.fire({
                icon: 'warning',
                title: 'Required Fields',
                text: 'Please fill in all required fields (Name, Email, Subject).'
            });
            return;
        }

        loading.value = true;
        try {
            const response = await axios.post('/api/contact/submit', form.value, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            await Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: response.data.message || 'Thank you for contacting us. We will get back to you soon.',
                confirmButtonText: 'OK'
            });

            // Reset form
            form.value = {
                name: '',
                email: '',
                phone: '',
                subject: '',
                message: ''
            };

        } catch (error) {
            console.error('Error submitting contact form:', error);
            let errMsg = 'Failed to send message. Please try again.';
            if (error.response && error.response.status === 422 && error.response.data.errors) {
                const firstKey = Object.keys(error.response.data.errors)[0];
                const firstMsg = error.response.data.errors[firstKey][0];
                errMsg = firstMsg;
            } else if (error.response && error.response.data && error.response.data.message) {
                errMsg = error.response.data.message;
            }
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errMsg,
                confirmButtonText: 'OK'
            });
        } finally {
            loading.value = false;
        }
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
