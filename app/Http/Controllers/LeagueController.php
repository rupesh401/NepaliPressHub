<?php

namespace App\Http\Controllers;

use App\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    
    public function getLeagues()
    {
        $cats = League::orderBy('created_at', 'DESC')->get();

        if (!empty($cats)) {
            return response()->json(['data' => $cats, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteLeague(Request $request)
    {
        $category = League::find($request->id);
        if (!$category) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $category->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editLeague(Request $request)
    {
        $updateLeague =  League::find($request->id);
        $updateLeague->league = $request->league;
        if ($updateLeague->update()) {
            return response()->json(['data' => $updateLeague, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewLeague(Request $request)
    {
        $newLeague = new League();
        $newLeague->user_id = Auth::user()->id;
        $newLeague->league = $request->league;

        if ($newLeague->save()) {
            return response()->json(['data' => $newLeague, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
}
