<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;    // Impor model News
use App\Models\User;    // Impor model User
use App\Models\Comment; // Impor model Comment
use App\Models\Media;   // Impor model Media
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $categoriesCount = $categories->count();
        $users = User::all(); // Ini masih diperlukan jika layout utama (main.blade.php) menggunakan $users

        return view('content.categories.index', compact('categories', 'categoriesCount', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika content.categories.create juga menggunakan layout yang membutuhkan $users,
        // Anda perlu mengambil $users di sini juga.
        $users = User::all(); // Tambahkan ini jika dibutuhkan
        return view('content.categories.create', compact('users')); // Dan tambahkan di compact
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Jika content.categories.show juga menggunakan layout yang membutuhkan $users,
        // Anda perlu mengambil $users di sini juga.
        $users = User::all(); // Tambahkan ini jika dibutuhkan
        return view('content.categories.show', compact('category', 'users')); // Dan tambahkan di compact
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Jika content.categories.edit juga menggunakan layout yang membutuhkan $users,
        // Anda perlu mengambil $users di sini juga.
        $users = User::all(); // Tambahkan ini jika dibutuhkan
        return view('content.categories.edit', compact('category', 'users')); // Dan tambahkan di compact
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}