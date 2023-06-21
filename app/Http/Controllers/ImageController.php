<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\WritableImageDownloadRequest;
use App\Http\Requests\WritableImageUploadRequest;
use App\Http\Resources\Category as ResourcesCategory;
use App\Http\Resources\Image as ResourcesImage;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ImageController extends Controller
{
    public function index(WritableImageDownloadRequest $request)
    {
        $filters = $request->only(['categoryIds','page']);
        
        $images = Image::latest()->filter($filters)->paginate(10);
        $categories = Category::all();
        
        return Inertia::render('User/Index', [
            'user' => Auth::user(),
            'images' => ResourcesImage::collection($images),
            'filters' => $request->only(['categoryIds','page']),
            'categories' => ResourcesCategory::collection($categories),
        ]);
    }

    public function contributorSpecificList(WritableImageUploadRequest $request)
    {
        $images = Image::ofUser(Auth::id())->latest()->paginate(10);

        return Inertia::render('Upload/Index', [
            'images' => ResourcesImage::collection($images),
        ]);
    }

    public function create(WritableImageUploadRequest $request)
    {
        $categories = Category::all();

        return Inertia::render('Upload/Create', [
            'categories' => ResourcesCategory::collection($categories),
        ]);

    }

    public function store(ImageUploadRequest $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();

            if ($request->hasFile('path')) {
                $image = $request->file('path');
                $fileName = time().'.'.$image->getClientOriginalName();
                $image->storeAs('images', $fileName);
                $input['path'] = $fileName;
            }
            Image::create($input);

            return redirect()->route('images.list');

        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'error' => true];
        }
    }

    public function download(WritableImageDownloadRequest $request, Image $image)
    {
        $image->downloadCount();

        return redirect()->back();
    }
}
