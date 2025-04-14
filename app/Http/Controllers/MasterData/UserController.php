<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $users = User::oldest()->whereNull('deleted_at')->get();

        return view('pages/user/index', [
            'title' => 'Data User',
            'users' => $users
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
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ]);

        $password = Str::random(10);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($password)
        ]);

        Mail::to($user->email)->send(new UserCreatedMail($user, $password));

        return response()->json([
            'message' => 'User has been created! Sending password to Email.',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'created_at' => $user->created_at->format('d M Y'),
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        return view('pages.user.profile', [
            'title' => 'Profile User',
            'user' => $user
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
    public function update(Request $request, string $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if ($request->has('username')) {
            $user->username = $request->input('username');
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('message', "Profile updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully!'
        ]);
    }
}
