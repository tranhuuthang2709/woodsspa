<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $banners = Banner::where('active', 1)->get();
        return view('about',compact('banners'));
    }
    public function contact() 
    {
        
        $banners = Banner::where('active', 1)->get();
        return view('contact',compact('banners'));
    }
}
