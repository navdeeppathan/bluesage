<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::latest()->get();
        return view('admin.team-members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/team'), $name);
            $imagePath = 'uploads/team/'.$name;
        }

        TeamMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Team member added successfully');
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = $member->image;

        if ($request->hasFile('image')) {

            if ($member->image && File::exists(public_path($member->image))) {
                File::delete(public_path($member->image));
            }

            $name = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/team'), $name);
            $imagePath = 'uploads/team/'.$name;
        }

        $member->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with('success','Team member updated successfully');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);

        if ($member->image && File::exists(public_path($member->image))) {
            File::delete(public_path($member->image));
        }

        $member->delete();

        return back()->with('success','Team member deleted successfully');
    }
}