<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function aboutus(){
        return view('pages.staticpages.aboutus');
    }

    public function mainfeatures(){
        return view('pages.staticpages.mainfeatures');
    }

    public function contacts(){
        return view('pages.staticpages.contacts');
    }
}
