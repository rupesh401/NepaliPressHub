<?php

namespace App\Http\Controllers;

use App\League;
use App\Table;
use App\TableLeg;
use App\Team;
use App\TeamLeg;
use App\TeamTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    public function updateTable(Request $request)
    {
        DB::beginTransaction();
        try {
            $updateTable =  Table::find($request->id);
                $updateTable->p = $request->p;
                $updateTable->w = $request->w;
                $updateTable->d = $request->d;
                $updateTable->l = $request->l;
                $updateTable->pts = $request->pts;
            if ($updateTable->update()) {
                DB::commit();
                return response()->json(['data' => $updateTable, 'status' => 'success', 'status_code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function getTeams()
    {
        $teams = Team::with(['league'])->orderBy('created_at', 'DESC')->get();

        if (!empty($teams)) {
            return response()->json(['data' => $teams, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteTeam(Request $request)
    {
        $delTeam = Team::find($request->id);
        if (!$delTeam) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            TeamLeg::where('team_id', $request->id)->delete();
            $delTeam->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $updateTeam =  Team::find($request->id);
            if (empty($request->status)) {
                $updateTeam->team = $request->team;
                $teamLeague = ['league_id' => $request->league, 'team_id' => $request->id];
                TeamLeg::where('team_id', $request->id)->delete();
                TeamLeg::insert($teamLeague);
            } else {
                $updateTeam->status = $request->status;
            }
            if ($updateTeam->update()) {
                DB::commit();
                return response()->json(['data' => $updateTeam, 'status' => 'success', 'status_code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function addNewTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $newTeam = new Team();
            $newTeam->user_id = Auth::user()->id;
            $newTeam->team = $request->team;
            if ($newTeam->save()) {
                $teamLeague = ['league_id' => $request->league, 'team_id' => $newTeam->id];
                TeamLeg::insert($teamLeague);
                $table = new Table();
                $table->user_id = Auth::user()->id;
                $table->p=0; $table->w=0; $table->d=0; $table->l=0; $table->pts=0;
                if ($table->save()) {
                    $leagueTable = ['league_id' => $request->league, 'table_id' => $table->id];
                    TableLeg::insert($leagueTable);
                    $teamTable = ['team_id' => $newTeam->id, 'table_id' => $table->id];
                    TeamTable::insert($teamTable);
                    DB::commit();
                    return response()->json(['data' => $newTeam, 'status' => 'success', 'status_code' => 201]);
                }
              
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }
   
   
    public function getLeagues()
    {
        $leagues = League::with(['team' => function($query) { $query->with(['table' => function($query) { $query->orderBy('pts', 'DESC');}]);}])->get();
        if (!empty($leagues)) {
            return response()->json(['data' => $leagues, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteLeague(Request $request)
    {
        $delLeague = League::find($request->id);
        if (!$delLeague) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $deleteLeague = TeamLeg::where('league_id', $request->id)->get();
            foreach ($deleteLeague as $team) {
                $teamId = $team->team_id;
                Team::where('id', $teamId)->delete(); 
                $team->delete(); 
            }
            $delLeague->delete();
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
