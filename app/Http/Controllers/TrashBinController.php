<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Carbon\Carbon;

class TrashBinController extends Controller
{
    public function recycle()
    {
        Carbon::setLocale('id');
        $users = User::onlyTrashed()->paginate(10);

        return view('pages.user.recycle', [
            'title' => 'Recycle Bin',
            'users' => $users
        ]);
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();

        return response()->json(['message' => 'User permanently deleted.']);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return response()->json([
            'message' => 'User successfully restore.'
        ], Response::HTTP_OK);
    }
}
