<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('translations')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('admin.categories.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'image' => 'nullable|image',
            'name' => 'required|array',
        ]);

        $category = new Category();
        $category->status = $request->status;
        $category->image = $this->handleImageUpload($request); 
        $category->save();

        foreach ($request->name as $lang_id => $name) {
            $category->translations()->create([
                'language_id' => $lang_id,
                'name' => $name,
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');
    }

    public function edit($id)
    {
        $category = Category::with('translations')->findOrFail($id);
        $languages = Language::all();
        return view('admin.categories.edit', compact('category', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
            'image' => 'nullable|image',
            'name' => 'required|array',
        ]);

        $category = Category::findOrFail($id);
        $category->status = $request->status;

        if ($request->hasFile('image')) {
            $category->image = $this->handleImageUpload($request, $category);
        }

        $category->save();

        foreach ($request->name as $lang_id => $name) {
            $categoryTranslation = CategoryTranslation::where('category_id', $category->id)
                ->where('language_id', $lang_id)
                ->first();

            if ($categoryTranslation) {
                $categoryTranslation->update([
                    'name' => $name
                ]);
            }
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->translations()->delete(); 
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }

    private function handleImageUpload(Request $request, $category = null)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            if ($category && $category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
        }

        return $imagePath;
    }
}
