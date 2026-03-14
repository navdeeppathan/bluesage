<?php

namespace App\Http\Controllers;

use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::latest()->get();
        return view('admin.highlights.index', compact('highlights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/highlights'), $name);
            $imagePath = 'uploads/highlights/'.$name;
        }

        Highlight::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Highlight added successfully');
    }

    public function update(Request $request, $id)
    {
        $highlight = Highlight::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $highlight->image;

        if ($request->hasFile('image')) {

            if ($highlight->image && File::exists(public_path($highlight->image))) {
                File::delete(public_path($highlight->image));
            }

            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/highlights'), $name);
            $imagePath = 'uploads/highlights/'.$name;
        }

        $highlight->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Highlight updated successfully');
    }

    public function destroy($id)
    {
        $highlight = Highlight::findOrFail($id);

        if ($highlight->image && File::exists(public_path($highlight->image))) {
            File::delete(public_path($highlight->image));
        }

        $highlight->delete();

        return back()->with('success','Highlight deleted successfully');
    }
}