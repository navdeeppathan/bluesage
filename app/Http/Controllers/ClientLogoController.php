<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ClientLogoController extends Controller
{
    public function index()
    {
        $logos = ClientLogo::latest()->get();
        return view('admin.client-logos.index', compact('logos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $name = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/client-logos'), $name);
            $logoPath = 'uploads/client-logos/'.$name;
        }

        ClientLogo::create([
            'logo' => $logoPath,
            'website_url' => $request->website_url,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Client logo added successfully');
    }

    public function update(Request $request, $id)
    {
        $logo = ClientLogo::findOrFail($id);

        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website_url' => 'nullable|url'
        ]);

        $logoPath = $logo->logo;

        if ($request->hasFile('logo')) {

            if ($logo->logo && File::exists(public_path($logo->logo))) {
                File::delete(public_path($logo->logo));
            }

            $name = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/client-logos'), $name);
            $logoPath = 'uploads/client-logos/'.$name;
        }

        $logo->update([
            'logo' => $logoPath,
            'website_url' => $request->website_url,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Client logo updated successfully');
    }

    public function destroy($id)
    {
        $logo = ClientLogo::findOrFail($id);

        if ($logo->logo && File::exists(public_path($logo->logo))) {
            File::delete(public_path($logo->logo));
        }

        $logo->delete();

        return back()->with('success','Client logo deleted successfully');
    }
}