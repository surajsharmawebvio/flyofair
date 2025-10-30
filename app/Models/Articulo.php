<?php

namespace App\Models;

use App\Models\Blog;

/**
 * Articulo model.
 *
 * This class is a lightweight alias of the Blog model that points to the same
 * database table. It lets you register a separate Filament resource for
 * "Articulos" while reusing the existing Blog table and behaviour.
 */
class Articulo extends Blog
{
    protected $table = 'blogs';
}
