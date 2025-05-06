<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class QuoteController extends Controller
{
    public function index(): View|Application|Factory
    {
        return view('pages.quote');
    }
}
