@extends('app')

@section('title', $seo['title'])

@section('meta')
    <meta name="description" content="{{ $seo['description'] }}">
    @if(isset($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <link rel="canonical" href="{{ $seo['canonical'] }}" />
    <meta property="og:image" content="{{ $seo['ogImage'] }}" />
@endsection

@section('content')
    <div class="container mt-5">
        <article>
            <header class="mb-4">
                <h1>{{ $blog->title }}</h1>
                @if($blog->created_at)
                    <p class="text-muted">Publicado el {{ $blog->created_at->format('j \d\e F, Y') }}</p>
                @endif
            </header>

            @if($blog->image)
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid mb-4">
            @endif

            <div class="content">
                {!! $blog->content !!}
            </div>
        </article>

        <div class="mt-5">
            <a href="{{ route('articulos.es') }}" class="btn btn-secondary">← Volver a Artículos</a>
        </div>
    </div>
@endsection