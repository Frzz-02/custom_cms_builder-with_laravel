<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionCompletecount;
use Illuminate\Http\Request;
use App\Models\Setting;

class CompleteCountController extends Controller
{
    public function index()
    {
        $completeCounts = SectionCompletecount::latest()->get();
        $settings = Setting::first();
        return view('backend.complete-count.index', compact('completeCounts', 'settings'));
    }

    public function create()
    {
        $settings = Setting::first();
        return view('backend.complete-count.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'amount' => 'nullable|integer',
            'status' => 'nullable|string|max:255',
        ]);

        SectionCompletecount::create($validated);

        return redirect()->route('backend.complete-count.index')
            ->with('success', 'Complete Count created successfully.');
    }

    public function edit(SectionCompletecount $completeCount)
    {
        $settings = Setting::first();
        return view('backend.complete-count.edit', compact('completeCount', 'settings'));
    }

    public function update(Request $request, SectionCompletecount $completeCount)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'amount' => 'nullable|integer',
            'status' => 'nullable|string|max:255',
        ]);

        $completeCount->update($validated);

        return redirect()->route('backend.complete-count.index')
            ->with('success', 'Complete Count updated successfully.');
    }

    public function destroy(SectionCompletecount $completeCount)
    {
        $completeCount->delete();

        return redirect()->route('backend.complete-count.index')
            ->with('success', 'Complete Count deleted successfully.');
    }
}
