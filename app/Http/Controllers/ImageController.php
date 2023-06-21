<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\WritableImageUploadRequest;
use App\Http\Resources\Category as ResourcesCategory;
use App\Http\Resources\Image as ResourcesImage;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ImageController extends Controller
{
    

    public function index(Request $request)
    {
        $images = Image::latest()->paginate(10);
        $categories = Category::all();

        return Inertia::render('User/Index', [
            'images' => ResourcesImage::collection($images),
            'filters' => $request->only(['category']),
            'categories' => ResourcesCategory::collection($categories)
        ]);
    } 
    
    public function list(Request $request)
    {
        $images = Image::where('user_id',Auth::id())->latest()->paginate(10);

        return Inertia::render('Upload/Index', [
            'images' => ResourcesImage::collection($images)
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return Inertia::render('Upload/Create', [
            'categories' => ResourcesCategory::collection($categories)
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
            return redirect()->route('images.index');

        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'error' => true];
        }
    }

    public function download(Request $request,Image $image)
    {
        $image->downloadCount($image);
        $image_file = storage_path('app/public/images/'.$image->path);
        return response()->download($image_file);
    }


}
