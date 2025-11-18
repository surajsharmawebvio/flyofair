<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        return view('author');
    }

    public function indexEs(): View
    {
        return view('autor');
    }
}
