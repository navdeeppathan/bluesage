<?php

namespace App\Http\Controllers;

use App\Models\ContentSection;
use Illuminate\Http\Request;

class ContentSectionController extends Controller
{
    public function index()
    {
        $sections = ContentSection::latest()->get();
        return view('admin.content-sections.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        ContentSection::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success', 'Section added successfully');
    }

    public function update(Request $request, $id)
    {
        $section = ContentSection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $section->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success', 'Section updated successfully');
    }

    public function destroy($id)
    {
        ContentSection::findOrFail($id)->delete();

        return back()->with('success', 'Section deleted successfully');
    }
}