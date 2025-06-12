<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Preparation;
use Illuminate\Http\Request;

class MountainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mountains = Mountain::orderby('name', 'asc')
                                ->get();

        return view('pages.mountain.index', [
            'title' => 'Mountains',
            'mountains' => $mountains
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mountain.form', [
            'title' => 'Form Add Mountain'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:mountains,name',
            'location' => ['required', 'regex:/^[a-zA-Z\s]+,\s[a-zA-Z\s]+,\s[a-zA-Z\s]+$/'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'elevation' => 'nullable|numeric'
        ]);

        Mountain::create([
            'name' => $request->name,
            'location' => $request->location ?? null,
            'latitude' => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
            'elevation' => $request->elevation ?? null,
            'description' => $request->description ?? null
        ]);

        return redirect()->route('mountain.index')->with('message', "Mountain has been added successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $mountain = Mountain::where('slug', $slug)->first();

        if (!$mountain) {
            return redirect()->route('mountain.index')->with('error', 'Mountain Not Found.');
        }

        return view('pages.mountain.form', [
            'title' => 'Form Edit Mt. ' . $mountain->name,
            'mountain' => $mountain
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $mountain = Mountain::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:mountains,name,' . $mountain->id,
            'location' => ['required', 'regex:/^[a-zA-Z\s]+,\s[a-zA-Z\s]+,\s[a-zA-Z\s]+$/'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'elevation' => 'nullable|numeric'
        ]);

        $mountain->update([
            'name' => $request->name,
            'location' => $request->location ?? null,
            'latitude' => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
            'elevation' => $request->elevation ?? null,
            'description' => $request->description ?? null
        ]);

        return redirect()->route('mountain.index')->with('message', "Mountain has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function forceDelete($id)
    {
        $mountain = Mountain::findOrFail($id);

        $mountain->forceDelete();
        return response()->json(['message' => 'Data has been deleted.']);
    }
}
