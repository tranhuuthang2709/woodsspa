<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Language;
use App\Models\Service;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $banners = Banner::where('active', 1)->get();
        $categories = Category::with(['translations.language'])
            ->where('status', 1)
            ->get()
            ->map(function ($category) use ($locale) {
                $translation = $category->translations
                    ->firstWhere('language.code', $locale);
                $category->translated_name = $translation->name ?? '';
                return $category;
            });
        $services = Service::with(['translations.language', 'options'])
            ->where('status', 1)
            ->get()
            ->map(function ($service) use ($locale) {
                $translation = $service->translations->firstWhere('language.code', $locale);
                $service->translated_name = $translation ? $translation->name : $service->name;
                $option = $service->options->first();
                $service->duration = $option->duration ?? null;
                if ($locale === 'vi') {
                    $service->price = $option->price_vnd ?? null;
                    $service->sale_price = $option->sale_price_vnd ?? null;
                } else {
                    $service->price = $option->price_usd ?? null;
                    $service->sale_price = $option->sale_price_usd ?? null;
                }

                    $service->category_name = $service->category->translated_name ?? 'Other'; 
                return $service;
            });
        return view('home', compact('categories','services','banners'));
    }
}
