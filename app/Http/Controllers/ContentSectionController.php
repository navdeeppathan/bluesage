<?php

namespace App\Http\Controllers;

use App\Models\ContentSection;
use Illuminate\Http\Request;

class ContentSectionController extends Controller
{
    public function index()
    {
        $section = ContentSection::first();
        return view('admin.content-sections.index', compact('section'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        ContentSection::updateOrCreate(
            ['id' => 1], // single record
            [
                'title' => $request->title,
                'content' => $request->content,
                'status' => $request->status ? 1 : 0
            ]
        );

        return back()->with('success', 'Content saved successfully');
    }
}