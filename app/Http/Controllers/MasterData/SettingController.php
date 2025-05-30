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

    public function index_category()
    {
        $category = Category::all();
        return view('pages/admin/categories/index', [
            'title' => 'Data Category Item',
            'categories' => $category
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
}
