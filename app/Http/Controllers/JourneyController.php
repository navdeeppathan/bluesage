<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function index()
    {
        $journeys = Journey::latest()->get();
        return view('admin.journeys.index', compact('journeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'period' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Journey::create([
            'period' => $request->period,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Journey added successfully');
    }

    public function update(Request $request, $id)
    {
        $journey = Journey::findOrFail($id);

        $request->validate([
            'period' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $journey->update([
            'period' => $request->period,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Journey updated successfully');
    }

    public function destroy($id)
    {
        Journey::findOrFail($id)->delete();

        return back()->with('success','Journey deleted successfully');
    }
}