<?php

namespace App\Http\Controllers\MasterData\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breadcrumb;
use Illuminate\Http\Request;

class BreadcrumbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumb::all();

        return view('pages.admin.breadcrumb.index', [
            'title' => 'Data Breadcrumb',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.breadcrumb.form', [
            'title' => 'Form Pages'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'route_name' => 'required',
            'url' => 'nullable',
            'order' => 'nullable|integer'
        ]);

        Breadcrumb::create($validated);

        return redirect()->route('setting.breadcrumb.index')->with('message', 'Breadcrumb has been created!');
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
        $breadcrumb = Breadcrumb::where('slug', $slug)->firstOrFail();

        return view('pages/admin/breadcrumb.edit', [
            'title' => 'Form Edit Pages',
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $breadcrumb = Breadcrumb::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'label' => 'required',
            'route_name' => 'required',
            'url' => 'nullable',
            'order' => 'nullable|integer'
        ]);

        $checkChanges = $validated['label'] === $breadcrumb->label;
        if ($checkChanges) {
            return redirect()->back()->with('warning', "There is nothing to change!");
        }

        $breadcrumb->update([
            'label' => $validated['label'],
            'route_name' => $validated['route_name'],
            'url' => $validated['url'],
            'order' => $validated['order']
        ]);

        return redirect()->route('setting.breadcrumb.index')->with('message', "Data has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $breadcrumbs = Breadcrumb::where('slug', $slug)->firstOrFail();
        $breadcrumbs->delete();

        return redirect()->route('setting.breadcrumb.index')->with('message', "Breadcrumb has been deleted!");
    }
}
