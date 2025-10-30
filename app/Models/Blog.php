<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'faqs',
        'lang',
    ];

    protected $casts = [
        'published' => 'boolean',
        'faqs' => 'array',
    ];
}
