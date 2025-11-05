<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index()
    {
        return Inertia::render('Author');
    }

    public function indexEs()
    {
        return Inertia::render('Autor');
    }
}
