<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use SEOTools;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // The SEO Stuff
        $this->seo()->setDescription('An instagram clone app developed with Laravel and Vuejs');
        
        return redirect('/');
    }
}
