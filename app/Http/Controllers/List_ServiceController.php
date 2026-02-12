<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class List_ServiceController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $categories = Category::with(['translations.language'])
            ->where('status', 1)
            ->get()
            ->map(function ($category) use ($locale) {
                $translation = $category->translations->firstWhere('language.code', $locale);
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

        return view('list', compact('categories', 'services'));
    }
    public function show($id)
    {
        $locale = app()->getLocale();
        $service = Service::with(['translations.language', 'options'])
            ->where('status', 1)
            ->where('id', $id)
            ->firstOrFail();
            
        $translation = $service->translations->firstWhere('language.code', $locale);
        $service->translated_name = $translation ? $translation->name : $service->name;
        $options = $service->options;
        
        $option = $service->options->first(); 
        
        $service->duration = $option->duration ?? null;
        $service->price = $locale === 'vi' ? $option->price_vnd : $option->price_usd;
        $service->sale_price = $locale === 'vi' ? $option->sale_price_vnd : $option->sale_price_usd;
        $service->category_name = $service->category->translated_name ?? 'Other';
        $service->translated_description = $translation ? $translation->description : $service->description;

        $services_related  = Service::with(['translations.language', 'options'])
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
        return view('detail', compact('service', 'options','services_related'));
    }

}
