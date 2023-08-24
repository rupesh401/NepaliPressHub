<?php

namespace App\Http\Controllers;

use App\About;
use App\Ads;
use App\Contact;
use App\Game;
use App\League;
use App\Matchs;
use App\MySite;
use App\Post;
use App\Province;
use App\Result;
use App\Table;
use App\TableLeg;
use App\Tag;
use App\Team;
use App\TeamLeg;
use App\TeamTable;
use App\Video;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{   

     /**
     * This function returns single match page view
     * @package sportsNews
     * @return previewMatch view
     */
    public function previewMatch(Request $request, $home, $away, $link)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();
        $tags = Tag::orderBy('id', 'ASC')->get();
        $contact = Contact::where('id', 1)->get();
       
        $latestPost = Post::with(['tag', 'cat', 'prov', 'usr'])->latest('created_at')->where('status', 'Published')->take(3)->get();

        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $recaptchaKey = config('services.recaptcha.key');
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.single.match', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'tags' => $tags,
            'provinces' => $provinces,
            'lang' => $lang,
            'leagues' => $leagues,
            'about' => $about,
            'contact' => $contact,
            'latestPost' => $latestPost,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'recaptchaKey' => $recaptchaKey
        ]);
    }

    public function uploadLeagueLogo(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/league/logo';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }
    
    public function uploadTeamLogo(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/team/logo';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }
    public function deleteMatch(Request $request)
    {
        DB::beginTransaction();
        try {
            $delGame = Game::find($request->id);
            if (!$delGame) {
                return response()->json(['status' => 'failed', 'status_code' => 404]);
            } else {
                $delGame->result()->delete();
                $delGame->delete();
                DB::commit();
                return response()->json(['status' => 'success', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => $th, 'status' => 'error', 'status_code' => 500
            ]);
        }
    }
    
    public function editMatch(Request $request)
    {
        DB::beginTransaction();
        try {

            $game = Game::find($request->id);
            $game->team_home_id =  $request->home_team;
            $game->team_away_id =  $request->away_team;
            if ($game->update()) {

                // Update and save the result
                $result = Result::find($request->resultId);
                $result->home_score = $request->home_score;
                $result->away_score = $request->away_score;
                $result->home_scorer = $request->home_scorer;
                $result->away_scorer = $request->away_scorer;
                $result->time = $request->time;
                // $randomSlug = Str::random(10);
                // $result->link = $randomSlug;
                $result->minutes = $request->minutes;
                $result->date = date('Y-m-d', strtotime($request->date));
                if ($request->status != '') {
                    $result->status = $request->status;
                }
                if ($result->update()) {
                    DB::commit();
                    return response()->json(['data' => $game, 'status' => 'success', 'status_code' => 200]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => $th, 'status' => 'error', 'status_code' => 500
            ]);
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(['message' => $th, 'status' => 'error', 'status_code' => 500]);
        }
    }

    public function getMatches()
    {
        $games = Game::with(['home', 'away', 'result'])->orderBy('created_at', 'DESC')->get();

        if (!empty($games)) {
            return response()->json(['data' => $games, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewMatch(Request $request)
    {
        DB::beginTransaction();
        try {

            $game = new Game();
            $game->team_home_id =  $request->home_team;
            $game->team_away_id =  $request->away_team;
            if ($game->save()) {

                // Create and save the result
                $result = new Result();
                $result->user_id = Auth::user()->id;
                $result->home_score = $request->home_score;
                $result->away_score = $request->away_score;
                $result->home_scorer = $request->home_scorer;
                $result->away_scorer = $request->away_scorer;
                $result->time = $request->time;
                $randomSlug = Str::random(10);
                $result->link = $randomSlug;
                $result->link = $request->link;
                $result->minutes = $request->minutes;
                $result->date = date('Y-m-d', strtotime($request->date));
                if ($request->status != '') {
                    $result->status = $request->status;
                }
                $result->game_id = $game->id;
                if ($result->save()) {
                    DB::commit();
                    return response()->json(['data' => $game, 'status' => 'success', 'status_code' => 201]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => $th, 'status' => 'error', 'status_code' => 500
            ]);
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(['message' => $th, 'status' => 'error', 'status_code' => 500]);
        }
    }
   

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
                $updateTeam->logo = $request->logo;
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
            $newTeam->logo = $request->logo;
            if ($newTeam->save()) {
                $teamLeague = ['league_id' => $request->league, 'team_id' => $newTeam->id];
                TeamLeg::insert($teamLeague);
                $table = new Table();
                $table->user_id = Auth::user()->id;
                $table->p = 0;
                $table->w = 0;
                $table->d = 0;
                $table->l = 0;
                $table->pts = 0;
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
        $leagues = League::with(['team' => function ($query) {
            $query->with(['table' => function ($query) {
                $query->orderBy('pts', 'DESC');
            }]);
        }])->get();
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
        $updateLeague->logo = $request->logo;
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
        $newLeague->logo = $request->logo;
        if ($newLeague->save()) {
            return response()->json(['data' => $newLeague, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
}
