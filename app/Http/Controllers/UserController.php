<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as ResourcesCategory;
use App\Http\Resources\Image as ResourcesImage;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function Index(Request $request)
    {
        $images = Image::latest()->paginate(10);
        $categories = Category::all();

        return Inertia::render('User/Index', [
            'images' => ResourcesImage::collection($images),
            'filters' => $request->only(['category']),
            'categories' => ResourcesCategory::collection($categories)
        ]);
    }
}
