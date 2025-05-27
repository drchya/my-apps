<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Preparation;
use App\Models\Transportation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function index($slug)
    {
        Carbon::setLocale('id');

        $preparation = Preparation::with(['user', 'mountain', 'transportations'])
                                    ->where('slug', $slug)
                                    ->where('user_id', auth()->id())
                                    ->firstOrFail();

        if ($preparation->departure_date && $preparation->return_date) {
            $preparation->total_days = Carbon::parse($preparation->departure_date)->diffInDays(Carbon::parse($preparation->return_date));
        } else {
            $preparation->total_days = 1;
        }

        $preparation_id = $preparation->id;

        return view('pages.transportation.index', [
            'title' => "Transportation to Mt. " . $preparation->mountain->name,
            'preparation' => $preparation,
        ]);
    }

    public function store(Request $request, $slug)
    {
        $preparation = Preparation::where('slug', $slug)
                                    ->firstOrFail();

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'departure_location' => 'required|string|max:255',
            'arrival_location' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after_or_equal:departure_time',
            'price' => 'nullable|min:0',
            'type_trip' => 'required|in:personal,with_friends,open_trip',
            'status' => 'nullable',
            'notes' => 'nullable'
        ]);

        $status = $validated['status'] ?? 'available';
        $checked = ($status === 'booked') ? true : false;

        Transportation::create([
            'preparation_id'        => $preparation->id,
            'type'                  => $validated['type'],
            'departure_location'    => $validated['departure_location'],
            'arrival_location'      => $validated['arrival_location'],
            'departure_time'        => $validated['departure_time'],
            'arrival_time'          => $validated['arrival_time'],
            'price'                 => $validated['price'] ?? 0,
            'trip_type'             => $validated['type_trip'] ?? 'personal',
            'status'                => $status,
            'notes'                 => $validated['notes'],
            'checked'               => $checked,
        ]);

        return redirect()->back()->with('message', 'Transportation has been created.');
    }

    public function update(Request $request, $slug)
    {
        $items = $request->input('transport', []);
        $action = $request->input('action');

        if ($action === 'delete') {
            foreach ($items as $id => $item) {
                if (!empty($item['selected'])) {
                    Transportation::where('id', $id)->delete();
                }
            }

            return redirect()->back()->with('error', 'Selected transportation have been deleted.');
        }

        foreach ($items as $id => $item) {
            $data = Transportation::find($id);

            $updateData = [];

            if (isset($item['departure_time'])) {
                $updateData['departure_time'] = $item['departure_time'];
            }

            if (isset($item['arrival_time'])) {
                $updateData['arrival_time'] = $item['arrival_time'];
            }

            if (isset($item['price'])) {
                $updateData['price'] = $item['price'];
            }

            if (isset($item['type_trip'])) {
                $updateData['trip_type'] = $item['type_trip'];
            }

            if (isset($item['checked']) && $item['checked'] == 0) {
                if ($item['status'] === 'booked') {
                    $updateData['status'] = 'available';
                } else {
                    $updateData['status'] = $item['status'];
                }
                $updateData['checked'] = false;
            } elseif (isset($item['checked']) && $item['checked'] == 1) {
                $updateData['status'] = 'booked';
                $updateData['checked'] = true;
            } else {
                return redirect()->back()->with('message', "There's nothing to update.");
            }

            // if (isset($item['checked']) && $item['checked'] == 1) {
            //     $updateData['status'] = 'booked';
            //     $updateData['checked'] = true;
            // } else {
            //     if (isset($item['status'])) {
            //         $updateData['status'] = $item['status'];
            //         $updateData['checked'] = ($item['status'] === 'booked') ? true : false;
            //     } elseif (isset($item['checked'])) {
            //         $updateData['checked'] = false;
            //     }
            // }

            if (isset($item['notes'])) {
                $updateData['notes'] = $item['notes'];
            }

            $data->update($updateData);
        }

        return redirect()->back()->with('message', 'Transportation has been updated.');
    }
}
