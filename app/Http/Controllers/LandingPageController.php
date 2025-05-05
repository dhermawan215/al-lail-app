<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    //
    public function index(): View
    {
        return \view('landing-page');
    }
}
