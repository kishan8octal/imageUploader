<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Resources\Category as ResourcesCategory;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UploadController extends Controller
{

    public function Index(Request $request)
    {


    }


    public function create(Request $request)
    {
        $categories = Category::all();
        return Inertia::render('Upload/Create', [
            'categories' => ResourcesCategory::make($categories)
        ]);

    }

    public function store(ImageUploadRequest $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();

            if ($request->hasFile('file')) {
                $image = $request->file('file');
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
}
