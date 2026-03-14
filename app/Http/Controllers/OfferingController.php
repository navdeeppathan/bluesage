<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OfferingController extends Controller
{
    public function index()
    {
        $offerings = Offering::latest()->get();
        return view('admin.offerings.index', compact('offerings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_img' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048'
        ]);

        $iconPath = null;

        if ($request->hasFile('icon_img')) {
            $name = time().'_'.$request->icon_img->getClientOriginalName();
            $request->icon_img->move(public_path('uploads/offerings'), $name);
            $iconPath = 'uploads/offerings/'.$name;
        }

        Offering::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon_img' => $iconPath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Offering added successfully');
    }

    public function update(Request $request, $id)
    {
        $offering = Offering::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_img' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048'
        ]);

        $iconPath = $offering->icon_img;

        if ($request->hasFile('icon_img')) {

            if ($offering->icon_img && File::exists(public_path($offering->icon_img))) {
                File::delete(public_path($offering->icon_img));
            }

            $name = time().'_'.$request->icon_img->getClientOriginalName();
            $request->icon_img->move(public_path('uploads/offerings'), $name);
            $iconPath = 'uploads/offerings/'.$name;
        }

        $offering->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon_img' => $iconPath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Offering updated successfully');
    }

    public function destroy($id)
    {
        $offering = Offering::findOrFail($id);

        if ($offering->icon_img && File::exists(public_path($offering->icon_img))) {
            File::delete(public_path($offering->icon_img));
        }

        $offering->delete();

        return back()->with('success','Offering deleted successfully');
    }
}