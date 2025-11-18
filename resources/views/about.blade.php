@extends('app')

@section('title', 'FlyOFair | About Us')

@section('meta')
    <meta name="description" content="FlyOFair is an Online Travel Agency that provides the best assistance to its valued passengers and ensures an amazing travel. Call +1-877-238-0219 now." />
    <link rel="canonical" href="{{ url('/about-us') }}" />
@endsection

@section('content')
<section class="innerbanner-section">
    <div class="innerbannerbg">
        <img src="/images/blogbanner.jpg" alt="about banner">
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="inner-bannerbox">
                    <h1 class="innercommon-heading">About Us</h1>
                    <div class="breadcrumb-box">
                        <a href="/" class="breadcrumb-home">
                            <i class="fa fa-home"></i>
                            <span class="ms-1">Home</span>
                        </a>
                        <span class="breadcrumb-sep">&gt;</span>
                        <span class="breadcrumb-current">About Us</span>
                    </div>
                </div>
            </div>
        </div>
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
                    <h2 class="mb-2">
                        Assisting Travelers to Experience the Best Flying Experience 
                    </h2>
                    <p class="sub-title">FlyOFair is an emerging Online Travel Agency (OTA) that offers the best platform for global passengers to book flights, cancel flights, and access other travel services. We assure passengers that we provide 24/7 and 365-day travel assistance. With us, we can guarantee that travelers can find the best deals and discounts. </p>
                    <a href="#" class="btn common-bgBtn">Get the latest updates</a>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <div class="adventure-experience">
                    <img src="/images/about/about-123.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ai-section common-section">
    <div class="backtexbox">
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Left Text -->
            <div class="col-md-5 mb-4 mb-md-0">
                <h2 class="ai-title">
                    Explore your desired destinations without thinking TWICE!
                </h2>
            </div>

            <!-- Right Box -->
            <div class="col-md-6">
                <div class="ai-box">
                    <p>
                        We offer a one-stop solution for all airline travel needs, helping passengers get the best deals and discounts. Not only the deals and discounts, but also 24/7 assistance from our experts can lead to an amazing flying experience. 
                    </p>
                    <p>
                        So, what are you waiting for? Connect with FlyOFair and get your desired flight booked with us in no time. 
                    </p>
                    <p>
                        We will not restrict ourselves to assisting passengers with airlines' queries; we will also guide global passengers with hotel bookings, cruise bookings, car rentals, etc. We will be offering 360-degree assistance to the passengers from the tip to the bottom.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
<style>
    /* Breadcrumb under banner */
    .breadcrumb-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 12px;
        color: #ffffffcc;
        font-size: 14px;
        flex-wrap: wrap;
    }
    .breadcrumb-box .breadcrumb-home {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #ff6b35;
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

    /* About text section */
    .abouttext-section {
        background-color: rgba(var(--black-color), 0.03);
    }

    .adventure-experience {
        display: flex;
        gap: 20px;
        justify-content: center;
        align-items: center;
    }

    .adventure-experience img {
        width: 100%;
        height: auto;
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .adventure-left {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

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

    .adventure-sailing-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom-left-radius: 50px;
    }

    .adventure-right {
        flex: 1;
    }

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

    /* AI section */
    .ai-section {
        background-color: #f7f9fc;
    }

    .ai-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1c1f26;
        line-height: 1.3;
        margin-bottom: 1rem;
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
        margin-bottom: 15px;
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

    /* Responsive styles */
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
        .ai-title {
            font-size: 1.8rem;
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
        .ai-title {
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .ai-box {
            padding: 20px;
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
        .innercommon-heading {
            font-size: 2rem;
        }
        .breadcrumb-box {
            font-size: 12px;
            gap: 8px;
        }
        .section-header h2 {
            font-size: 1.8rem;
            line-height: 1.3;
        }
        .sub-title {
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .btn.common-bgBtn {
            width: 100%;
            padding: 12px 24px;
            font-size: 1rem;
            margin-top: 1rem;
        }
        .ai-section .row {
            flex-direction: column;
            text-align: center;
        }
        .ai-title {
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
        }
        .ai-box {
            padding: 20px 15px;
            font-size: 0.9rem;
        }
        .backtexbox {
            display: none;
        }
        .ai-section {
            position: relative;
        }
        .common-section {
            padding: 40px 0;
        }
        .abouttext-section {
            padding: 50px 0;
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
        .inner-bannerbox {
            text-align: center;
            padding: 20px 15px;
        }
        .innercommon-heading {
            font-size: 1.8rem;
        }
        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .section-header h2 {
            font-size: 1.5rem;
        }
        .sub-title {
            font-size: 0.9rem;
        }
        .adventure-experience img {
            max-width: 100%;
            height: auto;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        .innercommon-heading {
            font-size: 1.6rem;
        }
        .breadcrumb-box {
            font-size: 11px;
            gap: 6px;
        }
        .section-header h2 {
            font-size: 1.3rem;
        }
        .sub-title {
            font-size: 0.85rem;
        }
        .ai-title {
            font-size: 1.2rem;
        }
        .ai-box {
            padding: 15px;
            font-size: 0.85rem;
        }
        .btn.common-bgBtn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .common-section {
            padding: 30px 0;
        }
        .abouttext-section {
            padding: 40px 0;
        }
    }

    @media (max-width: 380px) {
        .custom-accordion .accordion-button {
            font-size: 13px;
        }
        .innercommon-heading {
            font-size: 1.4rem;
        }
        .section-header h2 {
            font-size: 1.2rem;
        }
        .ai-title {
            font-size: 1.1rem;
        }
    }
</style>
@endpush