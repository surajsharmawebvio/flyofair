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
        'canonical_url',
        'faqs',
        'lang',
        'robots_index',
        'robots_follow',
    ];

    protected $casts = [
        'lang',
        'published' => 'boolean',
        'faqs' => 'array',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];
}
