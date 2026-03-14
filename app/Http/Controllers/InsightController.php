<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InsightController extends Controller
{
    public function index()
    {
        $insights = Insight::latest()->get();
        return view('admin.insights.index', compact('insights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'media_type' => 'required|in:image,video',
            'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:20480'
        ]);

        $filePath = null;

        if ($request->hasFile('media')) {
            $name = time().'_'.$request->file('media')->getClientOriginalName();
            $request->file('media')->move(public_path('uploads/insights'), $name);
            $filePath = 'uploads/insights/'.$name;
        }

        Insight::create([
            'media_type' => $request->media_type,
            'media_url' => $filePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Insight added successfully');
    }

    public function update(Request $request,$id)
    {
        $insight = Insight::findOrFail($id);

        $request->validate([
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:20480'
        ]);

        $filePath = $insight->media_url;

        if ($request->hasFile('media')) {

            if ($insight->media_url && File::exists(public_path($insight->media_url))) {
                File::delete(public_path($insight->media_url));
            }

            $name = time().'_'.$request->file('media')->getClientOriginalName();
            $request->file('media')->move(public_path('uploads/insights'), $name);
            $filePath = 'uploads/insights/'.$name;
        }

        $insight->update([
            'media_type' => $request->media_type,
            'media_url' => $filePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Insight updated successfully');
    }

    public function destroy($id)
    {
        $insight = Insight::findOrFail($id);

        if ($insight->media_url && File::exists(public_path($insight->media_url))) {
            File::delete(public_path($insight->media_url));
        }

        $insight->delete();

        return back()->with('success','Insight deleted successfully');
    }
}