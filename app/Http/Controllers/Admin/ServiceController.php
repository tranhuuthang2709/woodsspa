<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceTranslation;
use App\Models\ServiceOption;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['translations', 'options'])->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $languages = Language::all();
        $categories = Category::all();
        return view('admin.services.create', compact('languages', 'categories'));
    }

    public function store(Request $request)
    {
        
        $service = new Service();
        $service->category_id = $request->category_id;
        $service->status = $request->status;
        $service->image = $this->handleImageUpload($request);
        $service->save();

        foreach ($request->name as $lang_id => $name) {
            $service->translations()->create([
                'language_id' => $lang_id,
                'name' => $name,
                'description' => $request->description[$lang_id] ?? null
            ]);
        }

        if ($request->options) {
            foreach ($request->options as $option) {
                $service->options()->create($option);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Service added successfully');
    }

    public function edit($id)
    {
        $service = Service::with(['translations', 'options'])->findOrFail($id);
        $languages = Language::all();
        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'languages', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'image' => 'nullable|image',
            'name' => 'required|array',
        ]);

        $service = Service::findOrFail($id);
        $service->category_id = $request->category_id;
        $service->status = $request->status;

        if ($request->hasFile('image')) {
            $service->image = $this->handleImageUpload($request, $service);
        }
        $service->save();

        foreach ($request->name as $lang_id => $name) {
            $translation = ServiceTranslation::where('service_id', $service->id)
                ->where('language_id', $lang_id)
                ->first();

            if ($translation) {
                $translation->update([
                    'name' => $name,
                    'description' => $request->description[$lang_id] ?? null
                ]);
            }
        }

        $service->options()->delete();
        if ($request->options) {
            foreach ($request->options as $option) {
                $service->options()->create($option);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
        $service->translations()->delete();
        $service->options()->delete();
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully');
    }

    private function handleImageUpload(Request $request, $service = null)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            if ($service && $service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('services', $imageName, 'public');
        }

        return $imagePath;
    }
}
