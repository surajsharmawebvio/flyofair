@extends('app')

@section('title', $seo['title'])

@section('meta')
    <meta name="description" content="{{ $seo['description'] }}">
    @if(isset($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <link rel="canonical" href="{{ $seo['canonical'] }}" />
    
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="{{ $seo['title'] }}" />
    <meta property="og:description" content="{{ $seo['description'] }}" />
    <meta property="og:image" content="{{ $seo['ogImage'] }}" />
    <meta property="og:url" content="{{ $seo['canonical'] }}" />
    <meta property="og:type" content="article" />
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seo['title'] }}" />
    <meta name="twitter:description" content="{{ $seo['description'] }}" />
    <meta name="twitter:image" content="{{ $seo['ogImage'] }}" />
    
    <!-- Robots Meta Tag -->
    @php
        $index = $blog->robots_index ? 'index' : 'noindex';
        $follow = $blog->robots_follow ? 'follow' : 'nofollow';
        $robotsContent = "{$index},{$follow}";
    @endphp
    <meta name="robots" content="{{ $robotsContent }}" />
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<style>
.faq-section {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
}

.accordion-button:not(.collapsed) {
    background-color: #e7f1ff;
    color: #0c63e4;
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}

.accordion-item {
    border: 1px solid rgba(0,0,0,.125);
    margin-bottom: 0.5rem;
}

.accordion-button {
    font-weight: 500;
}

.accordion-body {
    background-color: white;
    padding: 1.25rem;
}
</style>
@endpush

@section('content')
<section class="innerbanner-section">
    <div class="innerbannerbg">
        <img src="/images/blogbanner.jpg" alt="">
    </div>
</section>

<section class="common-section bloglist-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blogtitle-head">
                    <h1 class="blogtitle-heading">{{ $blog->title }}</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-wrap">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                <article class="post-detail-container">
                    <div class="post-featured-image">
                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}">
                    </div>

                    <div class="post-content-wrapper">
                        <div class="post-meta-header">
                            <div class="post-author-info">
                                <a href="#"><img src="/images/tw.png" alt="Twitter"></a>
                                <a href="#"><img src="/images/facebook.png" alt="Facebook"></a>
                                <a href="#"><img src="/images/pint.png" alt="Pinterest"></a>
                                <a href="#"><img src="/images/share.png" alt="Share"></a>
                            </div>
                        </div>

                        <div>
                            {!! $blog->content !!}
                        </div>
                        
                        <!-- Add FAQ Section -->
                        @if($blog->faqs && count($blog->faqs) > 0)
                        <div class="faq-section mt-5">
                            <h2 class="mb-4">Frequently Asked Questions</h2>
                            <div class="accordion" id="blogFaqAccordion">
                                @foreach($blog->faqs as $index => $faq)
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button 
                                            class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#faq-{{ $index }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        >
                                            {{ $faq['question'] }}
                                        </button>
                                    </h3>
                                    <div 
                                        id="faq-{{ $index }}" 
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                        data-bs-parent="#blogFaqAccordion"
                                    >
                                        <div class="accordion-body">
                                            {{ $faq['answer'] }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <hr>

                        <h3>Any thoughts or questions? Comment below!</h3>
                        <form action="#" class="replay-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="Comment">Comment</label>
                                        <textarea class="form-control" rows="5" placeholder="Your Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="submitformbtn"> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </article>
            </div>

            <div class="col-lg-4 col-md-4 col-12">
                <div class="sidebar-widget-wrap">
                    <div class="contact-info-cta-container">
                        <h2 class="cta-main-heading-text">
                            Looking for further inform on airline policies, terms & conditions, etc.
                        </h2>
                        <p class="cta-subheading-description">
                            Call now to know everything in detail.
                        </p>
                        <div class="phone-number-display-box">
                            <p class="contact-phone-number-text">+88(09) 53 33 09</p>
                        </div>
                    </div>
                    <!-- Related Posts Widget -->
                    <div class="sidebar-widget-box">
                        <h3 class="widget-header-title">
                            Recommended blogs
                        </h3>
                        <div class="related-posts-list">
                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="/images/bloglist1.png" alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=200"
                                        alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="/images/bloglist1.png" alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="/images/bloglist1.png" alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="related-post-card">
                                <div class="related-post-thumbnail">
                                    <img src="/images/bloglist1.png" alt="Post thumbnail">
                                </div>
                                <div class="related-post-details">
                                    <h4 class="related-post-title">Step-wise Detailed Guide on Hawaiian
                                        Airlines [..]</h4>
                                    <div class="related-post-meta">
                                        <a href="javascript:void(0)" class="blog-card-read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection