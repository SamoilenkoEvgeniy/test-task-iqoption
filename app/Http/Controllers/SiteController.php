<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return response()->view('welcome');
    }

    public function stats()
    {
        $users = \App\Models\User::all();
        return response()->view('stats', compact('users'));
    }

    public function statsReset()
    {
        \DB::table('users')->update([
            'balance' => 0
        ]);
        \DB::table('operations')->truncate();
        return response()->redirectTo('/stats');
    }

    public function addUser()
    {
        $user = new \App\Models\User([
            'external_id' => 1,
            'balance' => 1
        ]);
        $user->save();
        return response()->redirectTo('/');
    }

    public function getOperations(Request $request)
    {
        $user_id = $request->input('user_id');
        if (!$user_id) {
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'operations' => Operation::whereUserId($user_id)->get()
        ]);
    }

}
