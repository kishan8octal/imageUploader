<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as ResourcesCategory;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UploadController extends Controller
{
    public function category(Request $request)
    {
        $categories = Category::all();

        return Inertia::render('Upload/Create', [
            'categories' => ResourcesCategory::make($categories)
        ]);

    }

    public function upload(Request $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = $request->user()->id;

            if ($request->hasFile('file')) {
                $image = $request->file('file');
                // $fileName = time().'.'.$image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $image->storeAs('images', $fileName);
                $input['path'] = $fileName;
            }
            Image::create($input);
            return redirect()->route('report');

        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'error' => true];
        }
    }
}
