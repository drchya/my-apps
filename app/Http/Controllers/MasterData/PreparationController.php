<?php

namespace App\Http\Controllers\MasterData;

use App\Enums\StyleTrip;
use App\Enums\TypeTrip;
use App\Http\Controllers\Controller;
use App\Models\Gear;
use App\Models\Mountain;
use App\Models\Preparation;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;

class PreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preparations = Preparation::with('mountain')->get();

        foreach ($preparations as $preparation) {
            if ($preparation->departure_date && $preparation->return_date) {
                // Menghitung total hari antara departure_date dan return_date
                $preparation->total_days = Carbon::parse($preparation->departure_date)->diffInDays(Carbon::parse($preparation->return_date));
            } else {
                $preparation->total_days = 1;
            }
        }

        return view('pages.preparation.index', [
            'title' => "Preparation For Your Journey",
            'preparations' => $preparations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mountains = Mountain::all();

        return view('pages.preparation.form', [
            'title' => "Form Prepared",
            'mountains' => $mountains,
            'typeTrips' => TypeTrip::cases(),
            'styleTrips' => StyleTrip::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'mountain_id'       => 'required|exists:mountains,id',
            'via'               => 'required|string|max:255',
            'departure_date'    => 'required|date',
            'return_date'       => 'nullable|date|after_or_equal:departure_date',
            'type_trip'         => ['required', Rule::in(array_column(TypeTrip::cases(), 'value'))],
            'style_trip'        => ['required', Rule::in(array_column(StyleTrip::cases(), 'value'))],
            'budget_estimate'   => 'nullable|numeric',
            'status'            => 'nullable|string',
            'note'              => 'nullable|max:500',
        ]);

        $preparation = Preparation::create([
            'user_id'           => $validated['user_id'],
            'mountain_id'       => $validated['mountain_id'],
            'via'               => $validated['via'],
            'departure_date'    => $validated['departure_date'],
            'return_date'       => $validated['return_date'],
            'type_trip'         => TypeTrip::from($validated['type_trip']),
            'style_trip'        => StyleTrip::from($validated['style_trip']),
            'budget_estimate'   => $validated['budget_estimate'],
            'status'            => $validated['status'] ?? 'plannig',
            'note'              => $validated['note'],
        ]);

        return redirect()->route('preparation.show', $preparation)->with('message', "Preparation created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        Carbon::setLocale('id');

        $preparation = Preparation::with('mountain')
                                    ->where('slug', $slug)
                                    ->firstOrFail();

        if ($preparation->departure_date && $preparation->return_date) {
            // Menghitung total hari antara departure_date dan return_date
            $preparation->total_days = Carbon::parse($preparation->departure_date)->diffInDays(Carbon::parse($preparation->return_date));
        } else {
            $preparation->total_days = 1;
        }

        $types = Type::all();
        $categories = Category::all();

        return view('pages.preparation.show', [
            'title' => 'Detail Journey',
            'preparation' => $preparation,
            'types' => $types,
            'categories' => $categories
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $preparation = Preparation::findOrFail($id);
        $preparation->delete();

        return response()->json([
            'message' => 'User deleted successfully!'
        ]);
    }
}
