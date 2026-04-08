<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionTeam;
use Illuminate\Http\Request;

class SectionTeamController extends Controller
{
    public function index()
    {
        $teams = SectionTeam::latest()->paginate(10);

        return view('backend.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('backend.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:2048',
            'status' => 'required|in:active,inactive',
            'link_profile_1' => 'nullable|url|max:255',
            'link_profile_2' => 'nullable|url|max:255',
            'link_profile_3' => 'nullable|url|max:255',
            'link_profile_4' => 'nullable|url|max:255',
        ]);

        SectionTeam::create($validated);

        return redirect()->route('backend.teams.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(SectionTeam $team)
    {
        return view('backend.teams.edit', compact('team'));
    }

    public function update(Request $request, SectionTeam $team)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:2048',
            'status' => 'required|in:active,inactive',
            'link_profile_1' => 'nullable|url|max:255',
            'link_profile_2' => 'nullable|url|max:255',
            'link_profile_3' => 'nullable|url|max:255',
            'link_profile_4' => 'nullable|url|max:255',
        ]);

        $team->update($validated);

        return redirect()->route('backend.teams.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(SectionTeam $team)
    {
        $team->delete();

        return redirect()->route('backend.teams.index')
            ->with('success', 'Team member deleted successfully.');
    }
}
