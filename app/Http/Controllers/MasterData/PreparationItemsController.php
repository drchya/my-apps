<?php

namespace App\Http\Controllers\MasterData;

use App\Enums\StyleTrip;
use App\Enums\TypeTrip;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gear;
use App\Models\Mountain;
use App\Models\Preparation;
use App\Models\PreparationItems;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PreparationItemsController extends Controller
{
    public function store(Request $request)
    {
        $gears = $request->input('gear', []);

        // Pastikan data gear tidak kosong
        if (empty($gears)) {
            return back()->with('error', 'No gear data provided.');
        }

        foreach ($gears as $gear) {
            // Ambil data dengan aman
            $category_gear = json_encode($gear['category_gear'] ?? ['tracking']);
            $status_gear = strtolower(str_replace(' ', '_', $gear['status_gear'] ?? ''));
            $urgency_gear = strtolower(str_replace(' ', '_', $gear['urgency'] ?? ''));

            $price = is_numeric($gear['price'] ?? null) ? $gear['price'] : 0;
            $quantity = is_numeric($gear['quantity'] ?? null) ? $gear['quantity'] : 0;
            $is_group = isset($gear['is_group']) ? $gear['is_group'] : 0;
            $is_selected = isset($gear['selected']) ? $gear['selected'] : 0;
            $type_id = $gear['type_id'];

            $category_id = Type::select('category_id')
                            ->where('id', $type_id)
                            ->firstOrFail()
                            ->category_id;

            PreparationItems::create([
                'preparation_id' => $request->preparation_id,
                'type_id' => $type_id,
                'category_id' => $category_id,
                'quantity' => $quantity,
                'category_gear' => $category_gear,
                'status_gear' => $status_gear,
                'urgency' => $urgency_gear,
                'price' => $price,
                'is_group' => $is_group,
                'is_selected' => $is_selected,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return back()->with('message', 'Gear preparation added successfully!');
    }

    public function update(Request $request, string $preparation_id)
    {
        dd($request);
    }
}
