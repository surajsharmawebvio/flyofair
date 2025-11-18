<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('about');
    }

    public function indexEs(): View
    {
        return view('sobre-nosotros');
    }
}
