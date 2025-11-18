@extends('app')

@section('title', 'FlyOFair | Disclaimer')

@section('meta')
    <meta name="description" content="Read FlyOFair's disclaimer to understand the terms and conditions of using our flight booking services and website." />
    <link rel="canonical" href="{{ url('/disclaimer') }}/" />
@endsection

@section('content')
<section class="innerbanner-section">
    <div class="innerbannerbg">
        <img src="/images/banner/author-banner.jpg" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="inner-bannerbox">
                    <h1 class="innercommon-heading">Disclaimer</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="innerdefaultpage-contentbox">
                    <p>FlyOFair ("Company," "we," "our," "us") helps you search and book flights and related packages. We do not own or have an alliance with any airlines or their subsidiaries. All bookings are therefore made directly between you and those service providers. We encourage you to read it carefully prior to booking or using our website.</p>

                    <h2>Errors and Omissions</h2>

                    <p>We make every effort to provide the most accurate and updated information. However, be advised that details such as prices, flight schedules, seat availability, or other policies are constantly changing. Information can change without prior notice, and FlyOFair cannot be held liable for errors, cancellations, delays, or changes made by airlines or travel partners.</p>

                    <h3>Accountability</h3>

                    <p>Prices may vary depending on availability, and all prices shown on our website are provided by our suppliers. Additional taxes and charges may apply. Surcharges may be applied to the price. For example, there may be a luggage fee or a service charge.</p>

                    <p>FlyOFair shall not be liable for any loss, injury, or damage resulting from delays, cancellations, weather, or other conditions beyond our control. It is the passenger's responsibility to check visa requirements, travel restrictions, and health or safety conditions before departure.</p>

                    <h3>Terms of Assurance</h3>

                    <p>By using FlyOFair, you agree that we are not liable for any loss or damage arising out of your use of our website or services. We advise you to review all booking details carefully before confirming your trip. Please contact our customer care team before completing your purchase if you have any questions or need assistance with your booking.</p>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/default.css') }}">
@endpush