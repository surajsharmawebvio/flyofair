<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('published', true)->latest()->get()->map(function ($blog) {
            $blog->image = asset('storage/' . $blog->image);
            return $blog;
        });
        return Inertia::render('Blog', ['blogs' => $blogs]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('published', true)->firstOrFail();
        $blog->image = asset('storage/' . $blog->image);
        
        return Inertia::render('BlogDetail', ['blog' => $blog]);
    }
}
