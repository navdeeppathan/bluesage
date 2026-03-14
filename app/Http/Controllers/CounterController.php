<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::latest()->get();
        return view('admin.counters.index', compact('counters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'subtitle' => 'required|string|max:255'
        ]);

        Counter::create([
            'number' => $request->number,
            'subtitle' => $request->subtitle,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Counter added successfully');
    }

    public function update(Request $request, $id)
    {
        $counter = Counter::findOrFail($id);

        $request->validate([
            'number' => 'required',
            'subtitle' => 'required|string|max:255'
        ]);

        $counter->update([
            'number' => $request->number,
            'subtitle' => $request->subtitle,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Counter updated successfully');
    }

    public function destroy($id)
    {
        Counter::findOrFail($id)->delete();

        return back()->with('success','Counter deleted successfully');
    }
}