@extends('news.layouts.app')

@section('title')
    {{ @$match->home->team }} Vs {{ @$match->away->team }}
@endsection


@section('content')
    <style>
        .section-t:before {
            background-color: #e6e6e8;
            opacity: 0.1;
        }
    </style>
    <div class="col-lg-12 col-md-12 tr-sticky">
        <div class="middle-content theiaStickySidebar">
            <div class="section sports-section">
                <h1 class="section-title title">{{ $match->home->league[0]->league }}</h1>
                <div class="cat-menu">
                    {{-- <a href="listing-sports.html">See all</a> --}}
                </div>
                <div class="football-result post">
                    <div class="featured-result p-3 content-center">
                        <h2 class="league-name">{{ $match->home->league[0]->league }}</h2>
                        <div class="row">
                            <div class="col-3" style="text-align: center">
                                <img class="img-fluid" src="{{ "$pF/storage/uploads/team/logo/" . $match->home->logo }}"
                                    alt="Image" />
                                <br>
                                <h3 class="mt-1">{{ @$match->home->team }}</h3>
                            </div>
                            <div class="col-2 text-right">
                                <span class="match-result">
                                    @if ($match->result->status == 'Not Started' || $match->result->status == 'Postponed')
                                        --
                                    @else
                                        {{ $match->result->home_score }}
                                    @endif
                                </span><br>
                                <span>
                                    @php
                                        $homeScores = explode('), ', $match->result->home_scorer);
                                        echo implode(')<br>', $homeScores);
                                    @endphp
                                </span>
                            </div>
                            <div class="col-2">
                                <span class="verses">VS</span>
                                @if ($match->result->status == 'Started')
                                    <span class="match-result p-1"
                                        style="background-color: red; color: white; font-size: 10px;">
                                        Live</span><br>
                                @endif
                                <span class="match-time">
                                    @if ($match->result->status == 'Started')
                                        {{ $match->result->minutes }}'
                                    @elseif ($match->result->status == 'Not Started')
                                        {{ $match->result->status }} <br>
                                        {{ $match->result->time }}
                                    @elseif ($match->result->status == 'Finished')
                                        Finished
                                    @endif
                                </span>
                            </div>
                            <div class="col-2 text-left">
                                <span class="match-result">
                                    @if ($match->result->status == 'Not Started' || $match->result->status == 'Postponed')
                                        --
                                    @else
                                        {{ $match->result->away_score }}
                                    @endif
                                </span><br>
                                <span>
                                    @php
                                        $awayScores = explode('), ', $match->result->away_scorer);
                                        echo implode(')<br>', $awayScores);
                                    @endphp
                                </span>
                            </div>
                            <div class="col-3" style="text-align: center">
                                <img class="img-fluid" src="{{ "$pF/storage/uploads/team/logo/" . $match->away->logo }}"
                                    alt="Image" /> <br>
                                <h3 class="mt-1">{{ @$match->away->team }}</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="page-breadcrumbs">
            <h1 class="section-title section-t" style="color: #f3f4f5;">Sports</h1>
            <div class="world-nav cat-menu" style="left: 0;">
                <ul class="list-inline">
                    <li class="active"><a href="#">Summary</a></li>
                    <li><a href="#">Table</a></li>
                    <li><a href="#">News</a></li>
                </ul>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    <div id="site-content" class="site-content">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 tr-sticky">
                                <h3 class="mt-4"><strong>STATISTICS</strong></h3>
                                <h6 class="mt-4 ml-0">HEAD TO HEAD / LAST 5 MATCHES</h6>
                                <div class="col-lg-12 col-md-12">
                                    <div class="row">
                                        <div class="league-result col-6 mt-1 p-0">
                                            <ul>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <img style="width:56px;" class="img-fluid"
                                                                src="{{ "$pF/storage/uploads/team/logo/" . $match->home->logo }}"
                                                                alt="Image" />
                                                            <h2 class="mt-1">{{ @$match->home->team }}</h2>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="league-result col-6 mt-1 p-0 away">
                                            <ul>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <img style="width:56px;" class="img-fluid"
                                                                src="{{ "$pF/storage/uploads/team/logo/" . $match->away->logo }}"
                                                                alt="Image" />
                                                            <h2 class="mt-1">{{ @$match->away->team }}</h2>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 tr-sticky">
                                    <div class="row">
                                        <div class="league-result col-4 mt-3 p-0">
                                            <ul class="m-0 p-0">
                                                <li class="m-0 p-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h2 class="mt-1">4</h2>
                                                            <p class="status-goal">WINS</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="league-result col-4 mt-3 p-0 draw">
                                            <ul>
                                                <li class="m-0 p-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h2 class="mt-1">0</h2>
                                                            <p class="status-goal">DRAW</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="league-result col-4 mt-3 p-0">
                                            <ul>
                                                <li class="m-0 p-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h2 class="mt-1">3</h2>
                                                            <p class="status-goal">WINS</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 tr-sticky">
                        <div class="middle-content">
                            <h6 class="mt-4">RECENT MATCHES</h6>
                            <div class="post football-result mt-1">
                                <div class="league-result">
                                    <ul>
                                        <li class="p-3">
                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <img style="width:30px;" class="img-fluid"
                                                        src="{{ "$pF/storage/uploads/team/logo/" . $match->home->logo }}"
                                                        alt="Image" />
                                                    <span class="team-name">{{ @$match->home->team }}</span>
                                                </div>
                                                <div class="col-4">
                                                </div>
                                                <div class="col-4">
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                        alt="Image" />
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-3">
                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <img style="width:30px;" class="img-fluid"
                                                        src="{{ "$pF/storage/uploads/team/logo/" . $match->away->logo }}"
                                                        alt="Image" />
                                                    <span class="team-name">{{ @$match->away->team }}</span>
                                                </div>
                                                <div class="col-4">
                                                </div>
                                                <div class="col-4">
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                        alt="Image" />
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-3">
                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <img style="width:30px;" class="img-fluid"
                                                        src="{{ "$pF/storage/uploads/team/logo/" . $match->away->logo }}"
                                                        alt="Image" />
                                                    <span class="team-name">{{ @$match->away->team }}</span>
                                                </div>
                                                <div class="col-4">
                                                </div>
                                                <div class="col-4">
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                        alt="Image" />
                                                    <img style="width:18px;" class="img-fluid"
                                                        src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                        alt="Image" />
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 tr-sticky">
                        <div class="middle-content">
                            <!-- Team Standings -->
                            <div class="card card--has-table mt-4">
                                <div class="card__content">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-standings table-standings--full table-standings--full-football">
                                            <thead style="background-color: #3d3a3a;">
                                                <tr>
                                                    <th style="width: 10%" class="team-standings__ties">Pos</th>
                                                    <th style="width: 40%" class="team-standings__ties">Teams</th>
                                                    <th style="width: 10%" class="team-standings__ties">P</th>
                                                    <th style="width: 10%" class="team-standings__ties">W</th>
                                                    <th style="width: 10%" class="team-standings__ties">D</th>
                                                    <th style="width: 10%" class="team-standings__ties">L</th>
                                                    <th style="width: 10%" class="team-standings__pct">PTS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($table as $team)
                                                <tr class="m-0 p-0 @if ($team->team[0]->team == $match->home->team || $team->team[0]->team == $match->away->team) active-team @endif">
                                                    <td class="team-standings__ties">{{ ++$loop->index }}</td>
                                                    <td class="team-standings__ties">
                                                        <div class="team-meta">
                                                            <figure class="team-meta__logo">
                                                                <img style="width:24px;" class="img-fluid"
                                                                    src="{{ "$pF/storage/uploads/team/logo/" . $team->team[0]->logo }}"
                                                                    alt="Image" />
                                                            </figure>
                                                            <div class="team-meta__info">
                                                                <h6 class="team-meta__name">{{ @$team->team[0]->team }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="team-standings__ties">{{ $team->p }}</td>
                                                    <td class="team-standings__ties">{{ $team->w }}</td>
                                                    <td class="team-standings__ties">{{ $team->d }}</td>
                                                    <td class="team-standings__ties">{{ $team->l }}</td>
                                                    <td class="team-standings__pct">{{ $team->pts }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Standings / End -->
                            {{-- @foreach ($sportsNews as $item)
                            <p>
                               {{ $loop->index }}-{{ $item->cat[0]->category }}
                            </p>  
                            @endforeach --}}
                           
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
                    @include('news.inc.sidebar')
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
