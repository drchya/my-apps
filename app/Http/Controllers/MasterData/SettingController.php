<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index_type()
    {
        $type = Type::select('types.*')
                    ->join('categories', 'types.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', 'asc')
                    ->orderBy('types.name', 'asc')
                    ->with('category')
                    ->get();
        return view('pages/admin/type/index', [
            'title' => 'Data Type',
            'types' => $type
        ]);
    }
    public function create_type()
    {
        $category = Category::all();

        return view('pages/admin/type/form', [
            'title' => 'Form Insert Type',
            'categories' => $category
        ]);
    }
    public function store_type(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:types,name',
            'category' => 'required|exists:categories,id'
        ]);

        $slug = Str::slug($request->name);

        Type::create([
            'category_id'   => $validated['category'],
            'name'          => $validated['name'],
            'slug'          => $slug,
        ]);

        return redirect()->route('setting.type.index')->with('message', 'Type created successfully!');
    }
    public function edit_type($slug)
    {
        $type = Type::where('slug', $slug)->firstOrFail();
        $category = Category::all();

        return view('pages/admin/type/edit', [
            'title' => 'Form Edit Type',
            'categories' => $category,
            'type' => $type
        ]);
    }
    public function update_type(Request $request, $slug)
    {
        $type = Type::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id'
        ]);

        $new_slug = Str::slug($validated['name']);
        $checkChanges =
            $validated['name'] === $type->name &&
            (int) $validated['category'] === (int) $type->category_id;

        if ($checkChanges) {
            return redirect()->back()->with('warning', "There is nothing to change!");
        }

        if ($validated['name'] !== $type->name) {
            $request->validate([
                'name' => 'unique:types,name'
            ]);
        }

        $type->update([
            'name' => $validated['name'],
            'slug' => $new_slug,
            'category_id' => $validated['category']
        ]);

        return redirect()->route('setting.type.index')->with('message', "Data has been updated!");
    }
    public function destroy_type($slug)
    {
        $type = Type::where('slug', $slug)->firstOrFail();

        $usedInGears = $type->gears()->exists();
        $usedInPreparationItems = $type->preparationItems()->exists();

        if ($usedInGears || $usedInPreparationItems) {
            return redirect()->back()->with('warning', "Cannot delete this Item because it is used in another table.");
        }

        $type->delete();

        return redirect()->route('setting.type.index')->with('message', "Type has been deleted!");
    }

    public function index_category()
    {
        $category = Category::select('*')
                            ->orderBy('name')
                            ->get();
        return view('pages/admin/categories/index', [
            'title' => 'Data Category Item',
            'categories' => $category
        ]);
    }
    public function create_category()
    {
        return view('pages/admin/categories/form', [
            'title' => 'Form Input Category'
        ]);
    }
    public function store_category(Request $request)
    {
        $exists = Category::where('name', $request->name)->exists();
        if ($exists) {
            return redirect()->back()->with('delete', "The Category already exists in the Table.");
        }

        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $slug = Str::slug($request->name);
        $name = ucwords(strtolower($validated['name']));

        Category::create([
            'slug' => $slug,
            'name' => $name
        ]);

        return redirect()->route('setting.category.index')->with('message', 'Category created successfully!');
    }
    public function edit_category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('pages/admin/categories/edit', [
            'title' => 'Form Edit Category',
            'category' => $category
        ]);
    }
    public function update_category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $exists = Category::where('name', $request->name)->exists();
        if ($exists) {
            return redirect()->back()->with('warning', "The Category already exists in the Table.");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $new_slug = Str::slug($validated['name']);
        $checkChanges = $validated['name'] === $category->name;
        if ($checkChanges) {
            return redirect()->back()->with('warning', "There is nothing to change!");
        }

        if ($validated['name'] !== $category->name) {
            $request->validate([
                'name' => 'unique:categories,name'
            ]);
        }

        $name = ucwords(strtolower($validated['name']));

        $category->update([
            'slug' => $new_slug,
            'name' => $name,
        ]);

        return redirect()->route('setting.category.index')->with('message', "Data has been updated!");
    }
    public function destroy_category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $usedInType = $category->types()->exists();

        if ($usedInType) {
            return redirect()->back()->with('warning', "Cannot delete this Category because it is used in another table.");
        }

        $category->delete();

        return redirect()->route('setting.category.index')->with('message', "Category has been deleted!");
    }

    public function index_statuses()
    {
        $status = Status::select('*')
                    ->orderBy('name')
                    ->get();
        return view('pages/admin/statuses/index', [
            'title' => 'Data Status Item',
            'statuses' => $status
        ]);
    }
    public function create_statuses()
    {
        return view('pages/admin/statuses/form', [
            'title' => 'Form Input Status'
        ]);
    }
    public function store_statuses(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $slug = Str::slug($request->name);
        $name = ucwords(strtolower($validated['name']));
        $exists = Status::where('name', $name)->exists();
        if ($exists) {
            return redirect()->back()->with('delete', "The Status already exists in the Table.");
        }

        Status::create([
            'name' => $name,
            'slug' => $slug
        ]);

        return redirect()->route('setting.status.index')->with('message', "Status created successfully!");
    }
    public function edit_statuses($slug)
    {
        $status = Status::where('slug', $slug)->firstOrFail();
        return view('pages/admin/statuses/edit', [
            'title' => 'Form Edit Status',
            'status' => $status
        ]);
    }
    public function update_statuses(Request $request, $slug)
    {
        $status = Status::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $new_slug = Str::slug($validated['name']);
        $checkChanges = $validated['name'] === $status->name;
        if ($checkChanges) {
            return redirect()->back()->with('warning', "There is nothing to change!");
        }

        if ($validated['name'] !== $status->name) {
            $request->validate([
                'name' => 'unique:statuses,name'
            ]);
        }

        $name = ucwords(strtolower($validated['name']));

        $exists = Status::where('name', $name)->exists();
        if ($exists) {
            return redirect()->back()->with('warning', "The Status already exists in the Table.");
        }

        $status->update([
            'name' => $name,
            'slug' => $new_slug,
        ]);

        return redirect()->route('setting.status.index')->with('message', "Data has been updated!");
    }
    public function destroy_statuses($slug)
    {
        $status = Status::where('slug', $slug)->firstOrFail();
        $usedInGears = $status->gears()->exists();

        if ($usedInGears) {
            return redirect()->back()->with('warning', "Cannot delete this Status because it is used in another table.");
        }

        $status->delete();

        return redirect()->route('setting.status.index')->with('message', "Status has been deleted!");
    }
}
