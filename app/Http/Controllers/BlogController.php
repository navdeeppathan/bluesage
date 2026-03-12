<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function apiIndex()
    {
        try {

            $blogs = Blog::latest()->paginate(6);

            return response()->json([
                'data' => $blogs->items(),
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        }
    }
    
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogs'), $name);
            $imagePath = 'uploads/blogs/'.$name;
        }

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'author' => $request->author,
            'category' => $request->category,
            'published_date' => $request->published_date,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return back()->with('success','Blog created successfully');
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $blog->image;

        if ($request->hasFile('image')) {

            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }

            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogs'), $name);
            $imagePath = 'uploads/blogs/'.$name;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'author' => $request->author,
            'category' => $request->category,
            'published_date' => $request->published_date,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return back()->with('success','Blog updated successfully');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }

        $blog->delete();

        return back()->with('success','Blog deleted successfully');
    }
}