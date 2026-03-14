<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/testimonials'), $name);
            $imagePath = 'uploads/testimonials/'.$name;
        }

        Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'message' => $request->message,
            'rating' => $request->rating ?? 5,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Testimonial added successfully');
    }

    public function update(Request $request,$id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $testimonial->image;

        if ($request->hasFile('image')) {

            if ($testimonial->image && File::exists(public_path($testimonial->image))) {
                File::delete(public_path($testimonial->image));
            }

            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/testimonials'), $name);
            $imagePath = 'uploads/testimonials/'.$name;
        }

        $testimonial->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'message' => $request->message,
            'rating' => $request->rating,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Testimonial updated successfully');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image && File::exists(public_path($testimonial->image))) {
            File::delete(public_path($testimonial->image));
        }

        $testimonial->delete();

        return back()->with('success','Testimonial deleted successfully');
    }
}