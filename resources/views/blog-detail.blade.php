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
                    <p class="text-muted">Published on {{ $blog->created_at->format('F j, Y') }}</p>
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
            <a href="{{ route('blog') }}" class="btn btn-secondary">← Back to Blog</a>
        </div>
    </div>
@endsection