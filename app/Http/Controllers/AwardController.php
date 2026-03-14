<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::latest()->get();
        return view('admin.awards.index', compact('awards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/awards'), $name);
            $imagePath = 'uploads/awards/'.$name;
        }

        Award::create([
            'title' => $request->title,
            'year' => $request->year,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Award added successfully');
    }

    public function update(Request $request, $id)
    {
        $award = Award::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $award->image;

        if ($request->hasFile('image')) {

            if ($award->image && File::exists(public_path($award->image))) {
                File::delete(public_path($award->image));
            }

            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/awards'), $name);
            $imagePath = 'uploads/awards/'.$name;
        }

        $award->update([
            'title' => $request->title,
            'year' => $request->year,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Award updated successfully');
    }

    public function destroy($id)
    {
        $award = Award::findOrFail($id);

        if ($award->image && File::exists(public_path($award->image))) {
            File::delete(public_path($award->image));
        }

        $award->delete();

        return back()->with('success','Award deleted successfully');
    }
}