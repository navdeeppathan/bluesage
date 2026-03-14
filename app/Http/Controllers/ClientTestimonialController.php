<?php

namespace App\Http\Controllers;

use App\Models\ClientTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ClientTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = ClientTestimonial::latest()->get();
        return view('admin.client-testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/testimonials'), $name);
            $imagePath = 'uploads/testimonials/'.$name;
        }

        ClientTestimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'message' => $request->message,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Testimonial added successfully');
    }

    public function update(Request $request, $id)
    {
        $testimonial = ClientTestimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
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
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Testimonial updated successfully');
    }

    public function destroy($id)
    {
        $testimonial = ClientTestimonial::findOrFail($id);

        if ($testimonial->image && File::exists(public_path($testimonial->image))) {
            File::delete(public_path($testimonial->image));
        }

        $testimonial->delete();

        return back()->with('success','Testimonial deleted successfully');
    }
}