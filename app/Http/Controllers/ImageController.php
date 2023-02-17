<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\ImageStorage;

class ImageController extends Controller
{
    public function index()
    {
        \Log::info('yes');
        $images = ImageStorage::latest()->paginate(5);

        return view('index',compact('images'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        // echo '<pre>';
        // print_r($input);

        if ($image = $request->file('image')) {
            // $path = $request->file('image')->storeAs(
            //     'storage', $input['name']
            // );
            Storage::putFileAs('files', $image);
        }

        ImageStorage::create($input);
        return redirect()->route('images.index')->with('success','Product created successfully.');
    }


    public function show(ImageStorage $image)
    {
        return view('show',compact('image'));
    }

    public function edit(ImageStorage $image)
    {
        return view('edit',compact('image'));
    }


    public function update(Request $request, ImageStorage $image)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required'
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $path = $request->file('image')->storeAs(
                'storage', $input['name']
            );
            Storage::put(public_path('storage'), $path);
        }else{
            unset($input['image']);
        }

        $image->update($input);

        return redirect()->route('images.index')->with('success','Product updated successfully');
    }


    public function destroy(ImageStorage $image)
    {
        $image->delete();

        return redirect()->route('images.index')->with('success','Product deleted successfully');
    }
}
