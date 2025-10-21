<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContectController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact');
    }
}
