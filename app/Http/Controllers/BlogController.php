<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where(['published' => true, 'lang' => 'en'])->latest()->get()->map(function ($blog) {
            $blog->image = asset('storage/' . $blog->image);
            return $blog;
        });
        return Inertia::render('Blog', ['blogs' => $blogs]);
    }

    public function articulos()
    {
        $blogs = Blog::where(['published' => true, 'lang' => 'es'])->latest()->get()->map(function ($blog) {
            $blog->image = asset('storage/' . $blog->image);
            return $blog;
        });
        return Inertia::render('Blog', ['blogs' => $blogs]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('published', true)->firstOrFail();
        $blog->image = asset('storage/' . $blog->image);

        // Prepare SEO data
        $seo = [
            'title' => $blog->meta_title ?? $blog->title,
            'description' => $blog->meta_description ?? substr(strip_tags($blog->content), 0, 160),
            'keywords' => $blog->meta_keywords,
            'canonical' => $blog->canonical_url ?? url("/blog/{$blog->slug}"),
            'ogImage' => $blog->image,
        ];

        return Inertia::render('BlogDetail', ['blog' => $blog, 'seo' => $seo]);
    }

    // Spanish specific functions
    public function articulosEs()
    {
        $blogs = Blog::where(['published' => true, 'lang' => 'es'])->latest()->get()->map(function ($blog) {
            $blog->image = asset('storage/' . $blog->image);
            return $blog;
        });
        return Inertia::render('Articulos', ['blogs' => $blogs]);
    }

    public function showEs($slug)
    {
        $blog = Blog::where('slug', $slug)->where('published', true)->where('lang', 'es')->firstOrFail();
        $blog->image = asset('storage/' . $blog->image);

        // Prepare SEO data
        $seo = [
            'title' => $blog->meta_title ?? $blog->title,
            'description' => $blog->meta_description ?? substr(strip_tags($blog->content), 0, 160),
            'keywords' => $blog->meta_keywords,
            'canonical' => $blog->canonical_url ?? url("/articulos/{$blog->slug}"),
            'ogImage' => $blog->image,
        ];

        return Inertia::render('ArticulosDetail', ['blog' => $blog, 'seo' => $seo]);
    }
}
    