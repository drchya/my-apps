<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gear;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;

class GearsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gears = Gear::with(['category', 'type', 'status'])
                ->where('user_id', auth()->id())
                ->orderBy('brand', 'asc')
                ->get();

        return view('pages.gear.index', [
            'title' => "Your Gear",
            'gears' => $gears
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        $statuses = Status::all();

        return view('pages.gear.form', [
            'title' => 'Form add Gear',
            'categories' => $categories,
            'types' => $types,
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'type_id'       => 'required|exists:types,id',
            'category_id'   => 'required|exists:categories,id',
            'brand'         => 'required|string|max:100',
            'link_product'  => 'nullable|url|max:255',
            'price'         => 'nullable|numeric|min:0',
            'status_id'     => 'required|exists:statuses,id',
        ]);

        Gear::create($validated);

        return redirect()->route('gear.index')->with('message', "Gear has been added!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $gear = Gear::where('slug', $slug)->first();
        $categories = Category::all();
        $types = Type::all();
        $statuses = Status::all();

        if (!$gear) {
            return redirect()->route('gear.index')->with('message', "Slug Gear Not Found.");
        }

        return view('pages.gear.form', [
            'title' => "Form Edit for " . $gear->brand,
            'gear' => $gear,
            'categories' => $categories,
            'types' => $types,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $gear = Gear::where('slug', $slug)->firstOrFail();

        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'type_id'       => 'required|exists:types,id',
            'category_id'   => 'required|exists:categories,id',
            'brand'         => 'required|string|max:100|unique:gears,brand,' . $gear->id,
            'link_product'  => 'nullable|url|max:255',
            'price'         => 'nullable|numeric|min:0',
            'status_id'     => 'required|exists:statuses,id',
        ]);

        $gear->update([
            'user_id' => $request->user_id,
            'type_id' => $request->type_id,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'price' => $request->price ?? null,
            'link_product' => $request->link_product ?? null,
            'status_id' => $request->status_id
        ]);

        return redirect()->route('gear.index')->with('message', "Gear has been updated.");
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
        $gear = Gear::findOrFail($id);

        $gear->forceDelete();
        return response()->json(['message' => "Data has been deleted."]);
    }
}
