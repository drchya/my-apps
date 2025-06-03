<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;
use App\Models\Status;

class SettingController extends Controller
{
    public function index_type()
    {
        $type = Type::all();
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
    public function update_type()
    {
    }

    public function index_category()
    {
        $category = Category::all();
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
    public function edit_category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('pages/admin/categories/edit', [
            'title' => 'Form Edit Category',
            'category' => $category
        ]);
    }

    public function index_statuses()
    {
        $status = Status::all();
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
    public function edit_statuses($slug)
    {
        $status = Status::where('slug', $slug)->firstOrFail();
        return view('pages/admin/statuses/edit', [
            'title' => 'Form Edit Status',
            'status' => $status
        ]);
    }
}
