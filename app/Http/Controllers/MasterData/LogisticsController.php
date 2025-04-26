<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Logistic;
use App\Models\Preparation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        Carbon::setLocale('id');

        $preparation = Preparation::with(['user', 'mountain'])
                                    ->where('slug', $slug)
                                    ->where('user_id', auth()->id())
                                    ->firstOrFail();

        if ($preparation->departure_date && $preparation->return_date) {
            // Menghitung total hari antara departure_date dan return_date
            $preparation->total_days = Carbon::parse($preparation->departure_date)->diffInDays(Carbon::parse($preparation->return_date));
        } else {
            $preparation->total_days = 1;
        }

        $preparation_id = $preparation->id;

        $logistics = Logistic::with('preparation')
                                ->where('preparation_id', $preparation_id)
                                ->get();

        return view('pages.logistic.index', [
            'title' => "Logistics From Mt. " . $preparation->mountain->name,
            'preparation' => $preparation,
            'logistics' => $logistics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $slug)
    {
        $preparation = Preparation::where('slug', $slug)
                                    ->firstOrFail();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:500',
            'quantity'      => 'required|integer',
            'unit'          => 'required|in:pcs,pack,box,liter,ml,gram,kg',
            'price'         => 'nullable|integer|min:0',
        ]);

        Logistic::create([
            'preparation_id'    => $preparation->id,
            'name'              => $validated['name'],
            'description'       => $validated['description'] ?? null,
            'quantity'          => $validated['quantity'] ?? 1,
            'unit'              => $validated['unit'] ?? 'pcs',
            'price'             => $validated['price'] ?? 0,
            'checked'           => false,
        ]);

        return redirect()->back()->with('message', 'Logistics item added successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preparation $preparation, Logistic $logistic)
    {
        $items = $request->input('logistic', []);
        $action = $request->input('action');

        if ($action === 'delete') {
            foreach ($items as $id => $item) {
                if (!empty($item['selected'])) {
                    Logistic::where('id', $id)->delete();
                }
            }

            return redirect()->back()->with('error', 'Selected logistic items have been deleted.');
        }

        foreach($items as $id => $item) {
            $data = Logistic::find($id);

            $updateData = [];

            if (isset($item['name'])) {
                $updateData['name'] = $item['name'];
            }

            if (isset($item['description'])) {
                $updateData['description'] = $item['description'];
            }

            if (isset($item['quantity'])) {
                $updateData['quantity'] = $item['quantity'] ?? 0;
            }

            if (isset($item['unit'])) {
                $updateData['unit'] = $item['unit'] ?? 'pcs';
            }

            if (isset($item['price'])) {
                $updateData['price'] = $item['price'] ?? 0;
            }

            if (isset($item['checked'])) {
                $updateData['checked'] = !empty($item['checked']) ? 1 : 0;
            }

            if (isset($item['is_group'])) {
                $updateData['is_group'] = !empty($item['is_group']) ? 1 : 0;
            }

            $data->update($updateData);
        }

        return redirect()->back()->with('message', 'Logistic has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
