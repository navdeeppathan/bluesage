<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
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
            $request->icon_img->move(public_path('uploads/services'), $name);
            $iconPath = 'uploads/services/'.$name;
        }

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon_img' => $iconPath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Service added successfully');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_img' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048'
        ]);

        $iconPath = $service->icon_img;

        if ($request->hasFile('icon_img')) {

            if ($service->icon_img && File::exists(public_path($service->icon_img))) {
                File::delete(public_path($service->icon_img));
            }

            $name = time().'_'.$request->icon_img->getClientOriginalName();
            $request->icon_img->move(public_path('uploads/services'), $name);
            $iconPath = 'uploads/services/'.$name;
        }

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon_img' => $iconPath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Service updated successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->icon_img && File::exists(public_path($service->icon_img))) {
            File::delete(public_path($service->icon_img));
        }

        $service->delete();

        return back()->with('success','Service deleted successfully');
    }
}