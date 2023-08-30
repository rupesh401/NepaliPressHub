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
use Facade\Ignition\Tabs\Tab;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    public function getTodayMatches(Request $request)
    {
        $football = $request->query('football');
        $date = $request->query('date');

        $results = Result::with(['match.home.league', 'match.away'])
            ->whereHas('match.home.league', function ($query) use ($football) {
                $query->where('league', $football);
            })
            ->whereDate('date', $date) 
            ->orderBy('date', 'desc')
            ->get();

        return response()->json(['results' => $results]);
    }

    /**
     * This function returns single match page view
     * @package sportsNews
     * @return previewMatch view
     */
    public function previewMatch(Request $request, $league, $home, $away, $link)
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
        $games = Game::whereHas('result', function ($query) use ($link) {
            $query->where('link', $link);
        })->with(['home.league', 'away.league'])->first();
        $table = Table::whereHas('team.league', function ($query) use ($league) {
            $query->where('league', $league);
        })->with(['team'])->orderBy('pts', 'DESC')->get();

        $keywords = ['sports', 'football', 'soccer', 'players', 'worldcup'];
        $sportsNews = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->where(function ($query) use ($keywords) {
                $query->whereHas('tag', function ($query) use ($keywords) {
                    $query->whereIn('tag', $keywords);
                })
                    ->orWhereHas('cat', function ($query) use ($keywords) {
                        $query->whereIn('category', $keywords);
                    });
            })->orderBy('created_at', 'DESC')->take(12)->get();

            $lastFiveHomeTeam = Team::where('team', $home)->with([
            'matchesAsTeamHome.result' => function ($query) {
                $query->addSelect('id', 'game_id', 'home_score', 'away_score', 'time', 'date', 'status', 'created_at', 'updated_at')->orderByDesc('updated_at')->take(5);
            },
            'matchesAsTeamAway.result' => function ($query) {
                $query->addSelect('id', 'game_id', 'home_score', 'away_score', 'time', 'date', 'status', 'created_at', 'updated_at')
                    ->orderByDesc('updated_at')->take(5);
            }
        ])->select('id', 'team')->first();

        if ($lastFiveHomeTeam) {
            $homeMatches = collect([])->merge($lastFiveHomeTeam->matchesAsTeamHome->map(function ($match) {
                $match->relation = 'home_team';
                return $match;
            }))->merge($lastFiveHomeTeam->matchesAsTeamAway->map(function ($match) {
                $match->relation = 'away_team';
                return $match;
            }))->sortByDesc(function ($match) {
                return $match->result->updated_at;
            })->take(5);

            foreach ($homeMatches as $match) {
                $matchType = $match->relation;
                $matchResult = $match->result;
            }
        }

        $lastFiveAwayTeam = Team::where('team', $away)->with([
            'matchesAsTeamHome.result' => function ($query) {
                $query->addSelect('id', 'game_id', 'home_score', 'away_score', 'time', 'date', 'status', 'created_at', 'updated_at')->orderByDesc('updated_at')->take(5);
            },
            'matchesAsTeamAway.result' => function ($query) {
                $query->addSelect('id', 'game_id', 'home_score', 'away_score', 'time', 'date', 'status', 'created_at', 'updated_at')
                    ->orderByDesc('updated_at')->take(5);
            }
        ])->select('id', 'team')->first();

        if ($lastFiveAwayTeam) {
            $awayMatches = collect([])->merge($lastFiveAwayTeam->matchesAsTeamHome->map(function ($match) {
                $match->relation = 'home_team';
                return $match;
            }))->merge($lastFiveAwayTeam->matchesAsTeamAway->map(function ($match) {
                $match->relation = 'away_team';
                return $match;
            }))->sortByDesc(function ($match) {
                return $match->result->updated_at;
            })->take(5);

            foreach ($awayMatches as $match) {
                $matchType = $match->relation;
                $matchResult = $match->result;
            }
        }

        // Retrieve team IDs based on team names
        $homeTeam = Team::where('team', $home)->value('id');
        $awayTeam = Team::where('team', $away)->value('id');

        // Retrieve head-to-head matches between the two teams
        $headToHeadMatches = Game::where(function ($query) use ($homeTeam, $awayTeam) {
            $query->where([
                ['team_home_id', '=', $homeTeam],
                ['team_away_id', '=', $awayTeam],
            ])->orWhere([
                ['team_home_id', '=', $awayTeam],
                ['team_away_id', '=', $homeTeam],
            ]);
        })
            ->whereHas('result', function ($query) {
                $query->where('status', '<>', 'Not Started');
            })
            ->with('result')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        // Initialize counts for home and away teams
        $homeWinCount = 0;
        $awayWinCount = 0;
        $drawCount = 0;

        foreach ($headToHeadMatches as $match) {
            $result = $match->result;
            $homeScore = (int)$result->home_score;
            $awayScore = (int)$result->away_score;

            if ($homeScore > $awayScore) {
                if ($match->team_home_id === $homeTeam) {
                    $homeWinCount++;
                } else {
                    $awayWinCount++;
                }
            } elseif ($homeScore < $awayScore) {
                if ($match->team_home_id === $homeTeam) {
                    $awayWinCount++;
                } else {
                    $homeWinCount++;
                }
            } else {
                $drawCount++;
            }
        }

        return view('news.pages.single.match', [
            'homeWinCount' => $homeWinCount,
            'awayWinCount' => $awayWinCount,
            'drawCount' => $drawCount,
            'table' => $table,
            'games' => $games,
            'homeMatches' => $homeMatches,
            'awayMatches' => $awayMatches,
            'sportsNews' => $sportsNews,
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
                $result->possesion_home = $request->possesion_home;
                $result->possesion_away = $request->possesion_away;
                $result->corner_home = $request->corner_home;
                $result->corner_away = $request->corner_away;
                $result->shorts_home = $request->shorts_home;
                $result->shorts_away = $request->shorts_away;
                $result->shorts_off_home = $request->shorts_off_home;
                $result->shorts_off_away = $request->shorts_off_away;
                $result->passes_home = $request->passes_home;
                $result->passes_away = $request->passes_away;
                $result->date = date('Y-m-d', strtotime($request->date));
                if ($request->status != '') {
                    $singleResult = Result::where('id', $request->resultId)->first();
                    if ($singleResult->status != 'Finished') {
                        $result->status = $request->status;
                        if ($request->status == 'Finished') {
                            if ($request->home_score > $request->away_score) {
                                $teamTable = TeamTable::where('team_id', $request->home_team)->first();
                                $awayTeam = TeamTable::where('team_id', $request->away_team)->first();
    
                                $updateTable = Table::find($teamTable->table_id);
                                $updateAway = Table::find($awayTeam->table_id);
    
                                $updateTable->increment('p');
                                $updateTable->increment('w');
                                $updateTable->increment('pts', 3);
    
                                $updateAway->increment('p');
                                $updateAway->increment('l');
    
                                $updateTable->update();
                                $updateAway->update();
                                
                            }
                            if ($request->away_score > $request->home_score) {
    
                                $teamTable = TeamTable::where('team_id', $request->away_team)->first();
                                $homeTeam = TeamTable::where('team_id', $request->home_team)->first();
    
                                $updateTable = Table::find($teamTable->table_id);
                                $updateHome = Table::find($homeTeam->table_id);
    
                                $updateTable->increment('p');
                                $updateTable->increment('w');
                                $updateTable->increment('pts', 3);
    
                                $updateHome->increment('p');
                                $updateHome->increment('l');
    
                                $updateTable->update();
                                $updateHome->update();
                            }
                            if ($request->home_score == $request->away_score) {
    
                                $teamHomeTable = TeamTable::where('team_id', $request->home_team)->first();
                                $teamAwayTable = TeamTable::where('team_id', $request->away_team)->first();
    
                                $updateHomeTable = Table::find($teamHomeTable->table_id);
                                $updateAwayTable = Table::find($teamAwayTable->table_id);
    
                                $updateHomeTable->increment('p');
                                $updateAwayTable->increment('p');
    
                                $updateHomeTable->increment('d');
                                $updateAwayTable->increment('d');
    
                                $updateHomeTable->increment('pts');
                                $updateAwayTable->increment('pts');
    
                                $updateHomeTable->update();
                                $updateAwayTable->update();
                                
                            }
                        }
                    }
                   
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

                $result->possesion_home = $request->possesion_home;
                $result->possesion_away = $request->possesion_away;
                $result->corner_home = $request->corner_home;
                $result->corner_away = $request->corner_away;
                $result->shorts_home = $request->shorts_home;
                $result->shorts_away = $request->shorts_away;
                $result->shorts_off_home = $request->shorts_off_home;
                $result->shorts_off_away = $request->shorts_off_away;
                $result->passes_home = $request->passes_home;
                $result->passes_away = $request->passes_away;

                $result->time = $request->time;
                $randomSlug = Str::random(10);
                $result->link = $randomSlug;
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
