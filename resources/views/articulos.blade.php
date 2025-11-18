@extends('app')

@section('title', 'FlyOFair | Artículos')

@section('meta')
    <meta name="description" content="Lee los últimos artículos sobre viajes, consejos de vuelo y destinos turísticos en FlyOFair." />
    <link rel="canonical" href="https://www.flyofair.com/es/articulos/" />
@endsection

@section('content')
<section class="innerbanner-section">
    <div class="innerbannerbg">
        <img src="{{ asset('images/blogbanner.jpg') }}" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="inner-bannerbox">
                    <h1 class="innercommon-heading">Artículos</h1>
                    <div class="breadcrumb-box">
                        <a href="/es" class="breadcrumb-home">
                            <i class="fa fa-home"></i>
                            <span class="ms-1">Inicio</span>
                        </a>
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
        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-12">
                    <article class="blog-card-item">
                        <div class="blog-card-image">
                            <img src="{{ $blog->image }}" alt="Artículo">
                        </div>
                        <div class="blog-card-content">
                            <h3 class="blog-card-title">{{ $blog->title }}</h3>
                            <div class="blog-card-footer">
                                <a href="/es/articulos/{{ $blog->slug }}" class="blog-card-read-more">
                                    Leer Más <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<style>
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
@endpush