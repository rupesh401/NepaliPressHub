@extends('news.layouts.app')

@section('title')
    {{ @$games->home->team }} Vs {{ @$games->away->team }}
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
            <div class="section sports-section mt-4">
                @if ($lang == 'en')
                    <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> Home </a> > <a> Football
                        </a> > {{ $games->home->league[0]->league }}</h1>
                @else
                    <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> घर </a> > <a> फुटबल </a> >
                        {{ $games->home->league[0]->league }} </h1>
                @endif
                <div class="cat-menu">
                </div>
                <div class="football-result post">
                    <div class="featured-result p-3 content-center">
                        <h2 class="league-name">{{ $games->home->league[0]->league }}</h2>
                        <div class="row">
                            <div class="col-3" style="text-align: center">
                                <img class="img-fluid" src="{{ "$pF/storage/uploads/team/logo/" . $games->home->logo }}"
                                    alt="Image" />
                                <br>
                                <h3 class="mt-1">{{ @$games->home->team }}</h3>
                            </div>
                            <div class="col-2 text-right">
                                <span class="match-result">
                                    @if ($games->result->status == 'Not Started' || $games->result->status == 'Postponed')
                                        --
                                    @else
                                        {{ $games->result->home_score }}
                                    @endif
                                </span><br>
                                <span>
                                    @php
                                        $homeScores = explode('), ', $games->result->home_scorer);
                                        echo implode(')<br>', $homeScores);
                                    @endphp
                                </span>
                            </div>
                            <div class="col-2">
                                <span class="verses">VS</span>
                                @if ($games->result->status == 'Started')
                                    <span class="match-result p-1"
                                        style="background-color: red; color: white; font-size: 10px;">
                                        Live</span><br>
                                @endif
                                <span class="match-time">
                                    @if ($games->result->status == 'Started')
                                        {{ $games->result->minutes }}'
                                    @elseif ($games->result->status == 'Not Started')
                                        {{ $games->result->status }} <br>
                                        {{ $games->result->time }}
                                    @elseif ($games->result->status == 'Finished')
                                        Finished
                                    @endif
                                </span>
                            </div>
                            <div class="col-2 text-left">
                                <span class="match-result">
                                    @if ($games->result->status == 'Not Started' || $games->result->status == 'Postponed')
                                        --
                                    @else
                                        {{ $games->result->away_score }}
                                    @endif
                                </span><br>
                                <span>
                                    @php
                                        $awayScores = explode('), ', $games->result->away_scorer);
                                        echo implode(')<br>', $awayScores);
                                    @endphp
                                </span>
                            </div>
                            <div class="col-3" style="text-align: center">
                                <img class="img-fluid" src="{{ "$pF/storage/uploads/team/logo/" . $games->away->logo }}"
                                    alt="Image" /> <br>
                                <h3 class="mt-1">{{ @$games->away->team }}</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="page-breadcrumbs page-cs">
            <h1 class="section-title section-t" style="color: #f3f4f5;">&nbsp;</h1>
            <div class="world-nav cat-menu" style="left: 0;">
                <ul class="list-inline">
                    <li class="active" id="summary-link"><a href="javascript:void(0)"><strong>Summary</strong></a></li>
                    <li id="table-link"><a href="javascript:void(0)"><strong>Table</strong></a></li>
                    <li id="news-link"><a href="javascript:void(0)"><strong>News</strong></a></li>
                </ul>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    <div id="teams-summary">
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
                                                                    src="{{ "$pF/storage/uploads/team/logo/" . $games->home->logo }}"
                                                                    alt="Image" />
                                                                <h2 class="mt-1">{{ @$games->home->team }}</h2>
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
                                                                    src="{{ "$pF/storage/uploads/team/logo/" . $games->away->logo }}"
                                                                    alt="Image" />
                                                                <h2 class="mt-1">{{ @$games->away->team }}</h2>
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
                                                                <h2 class="mt-1">{{ $homeWinCount }}</h2>
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
                                                                <h2 class="mt-1">{{ $drawCount }}</h2>
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
                                                                <h2 class="mt-1">{{ $awayWinCount }}</h2>
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
                                                            src="{{ "$pF/storage/uploads/team/logo/" . $games->home->logo }}"
                                                            alt="Image" />
                                                        <span class="team-name">{{ @$games->home->team }}</span>
                                                    </div>
                                                    <div class="col-4">
                                                    </div>
                                                    <div class="col-4">
                                                        @foreach ($homeMatches as $result)
                                                            @if ($result->relation == 'home_team' && $result->result->home_score > $result->result->away_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                                    alt="Image" />
                                                            @elseif ($result->relation == 'home_team' && $result->result->away_score > $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                                    alt="Image" />
                                                            @elseif ($result->relation == 'away_team' && $result->result->away_score > $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                                    alt="Image" />
                                                                {{-- @endif --}}
                                                            @elseif ($result->relation == 'away_team' && $result->result->away_score < $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                                    alt="Image" />
                                                            @elseif (
                                                                ($result->result->status == 'Finished' || $result->result->status == 'Started') &&
                                                                    $result->result->away_score == $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                                    alt="Image" />
                                                                {{-- @else --}}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="p-3">
                                                <div class="row">
                                                    <div class="col-4 text-left">
                                                        <img style="width:30px;" class="img-fluid"
                                                            src="{{ "$pF/storage/uploads/team/logo/" . $games->away->logo }}"
                                                            alt="Image" />
                                                        <span class="team-name">{{ @$games->away->team }}</span>
                                                    </div>
                                                    <div class="col-4">
                                                    </div>
                                                    <div class="col-4">
                                                        @foreach ($awayMatches as $result)
                                                            @if ($result->relation == 'home_team' && $result->result->home_score > $result->result->away_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                                    alt="Image" />
                                                            @elseif ($result->relation == 'home_team' && $result->result->away_score > $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                                    alt="Image" />
                                                            @elseif ($result->relation == 'away_team' && $result->result->away_score > $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/win.png" }}"
                                                                    alt="Image" />
                                                                {{-- @endif --}}
                                                            @elseif ($result->relation == 'away_team' && $result->result->away_score < $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/lose.png" }}"
                                                                    alt="Image" />
                                                            @elseif (
                                                                ($result->result->status == 'Finished' || $result->result->status == 'Started') &&
                                                                    $result->result->away_score == $result->result->home_score)
                                                                <img style="width:18px;" class="img-fluid"
                                                                    src="{{ "$pF/news/assets/images/team/draw.png" }}"
                                                                    alt="Image" />
                                                                {{-- @else --}}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($games->result->corner_home != 0 && $games->result->corner_away != 0 && $games->result->shorts_home != 0 
                        && $games->result->shorts_away != 0 && $games->result->passes_home != 0 && $games->result->passes_away != 0
                        && $games->result->shorts_off_home != 0 && $games->result->shorts_off_away != 0)
                        <div class="col-lg-12 col-md-12 tr-sticky"><br>
                            <p class="text-center m-0 p-0">POSSESSION</p>
                            <div class="progress" style="height: 35px;">
                                <div class="progress-bar bg-color" role="progressbar" style="width: {{ @$games->result->possesion_home }}%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100">{{ @$games->result->possesion_home }}%</div>
                                <div class="progress-bar bg-color-two" role="progressbar" style="width: {{ @$games->result->possesion_away }}%"
                                    aria-valuenow="{{ @$games->result->possesion_away }}" aria-valuemin="0" aria-valuemax="100">{{ @$games->result->possesion_away }}%</div>
                            </div><br>
                            <p class="text-center m-0 p-0">CORNERS</p>
                            <div class="progress" style="height: 35px;">
                                <div class="progress-bar bg-color" role="progressbar" style="width: {{ (@$games->result->corner_home/(@$games->result->corner_home + @$games->result->corner_away)*100) }}%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100">{{ @$games->result->corner_home }}</div>
                                <div class="progress-bar bg-color-two" role="progressbar" style="width: {{ (@$games->result->corner_away/(@$games->result->corner_home + @$games->result->corner_away)*100) }}%"
                                    aria-valuenow="{{ @$games->result->corner_away }}" aria-valuemin="0" aria-valuemax="100">{{ @$games->result->corner_away }}</div>
                            </div><br>
                           
                            <p class="text-center m-0 p-0">SHOTS OFF TARGET</p>
                            <div class="progress" style="height: 35px;">
                                <div class="progress-bar bg-color" role="progressbar" style="width: 
                                {{ (@$games->result->shorts_off_home/(@$games->result->shorts_off_home + @$games->result->shorts_off_away)*100) }}%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100">{{ @$games->result->shorts_off_home }}
                                </div>
                                <div class="progress-bar bg-color-two" role="progressbar" style="width: 
                                {{ (@$games->result->shorts_off_away/(@$games->result->shorts_off_home + @$games->result->shorts_off_away)*100) }}%"
                                    aria-valuenow="{{ @$games->result->shorts_off_away }}" aria-valuemin="0" aria-valuemax="100">{{ @$games->result->shorts_off_away }}</div>
                            </div><br>
                            
                            <p class="text-center m-0 p-0">SHOTS ON TARGET</p>
                            <div class="progress" style="height: 35px;">
                                <div class="progress-bar bg-color" role="progressbar" style="width: 
                                {{ (@$games->result->shorts_home/(@$games->result->shorts_home + @$games->result->shorts_away)*100) }}%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100">{{ @$games->result->shorts_home }}
                                </div>
                                <div class="progress-bar bg-color-two" role="progressbar" style="width: 
                                {{ (@$games->result->shorts_away/(@$games->result->shorts_home + @$games->result->shorts_away)*100) }}%"
                                    aria-valuenow="{{ @$games->result->shorts_away }}" aria-valuemin="0" aria-valuemax="100">{{ @$games->result->shorts_away }}</div>
                            </div><br>
                            
                            <p class="text-center m-0 p-0">TOTAL PASSES</p>
                            <div class="progress" style="height: 35px;">
                                <div class="progress-bar bg-color" role="progressbar" style="width: {{ (@$games->result->passes_home/(@$games->result->passes_home + @$games->result->passes_away)*100) }}%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100">{{ @$games->result->passes_home }}</div>
                                <div class="progress-bar bg-color-two" role="progressbar" style="width: {{ (@$games->result->passes_away/(@$games->result->passes_home + @$games->result->passes_away)*100) }}%"
                                    aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{ @$games->result->passes_away }}</div>
                            </div><br>
                           
                        </div>
                        @endif
                    </div>
                    <div id="league-table" class="col-lg-12 col-md-12 tr-sticky">
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
                                                    <tr
                                                        class="m-0 p-0 @if ($team->team[0]->team == $games->home->team || $team->team[0]->team == $games->away->team) active-team @endif">
                                                        <td class="team-standings__ties">{{ ++$loop->index }}</td>
                                                        <td class="team-standings__ties">
                                                            <div class="team-meta">
                                                                <figure class="team-meta__logo">
                                                                    <img style="width:24px;" class="img-fluid"
                                                                        src="{{ "$pF/storage/uploads/team/logo/" . $team->team[0]->logo }}"
                                                                        alt="Image" />
                                                                </figure>
                                                                <div class="team-meta__info">
                                                                    <h6 class="team-meta__name">
                                                                        {{ @$team->team[0]->team }}</h6>
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
                        </div>
                    </div>
                    <div id="sports-news" class="col-lg-12 col-md-12 tr-sticky">
                        <div class="middle-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="section">
                                        <div class="row">
                                            @foreach ($sportsNews as $post)
                                                @if ($post->image)
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="post medium-post">
                                                            <div class="entry-header">
                                                                <div class="entry-thumbnail">
                                                                    <img class="img-fluid"
                                                                        style="width: 100%; object-fit:cover;"
                                                                        src="{{ "$pF/storage/uploads/posts/" . $post->image }}"
                                                                        alt="Image" />
                                                                </div>
                                                            </div>
                                                            <div class="post-content">
                                                                <div class="entry-meta">
                                                                    <ul class="list-inline">
                                                                        <li class="publish-date">
                                                                            <a><i
                                                                                    class="fa fa-clock-o"></i>{{ $post->created_at->format('F d, Y') }}</a>
                                                                        </li>
                                                                        <li class="views">
                                                                            <a><i
                                                                                    class="fa fa-eye"></i>{{ $post->views }}</a>
                                                                        </li>
                                                                        <li class="loves">
                                                                            <a><i
                                                                                    class="fa fa-heart-o"></i>{{ $post->likes }}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <h2 class="entry-title">
                                                                    <a href="{{ route('single-post', $post->slug) }}">
                                                                        @php
                                                                            $strippedContent = strip_tags($post->title);
                                                                            $truncatedContent = mb_substr($strippedContent, 0, 25, 'UTF-8');
                                                                            $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                                            
                                                                            // Display the truncated content
                                                                            echo $truncatedContent;
                                                                            
                                                                            // If there are remaining characters, show an ellipsis
                                                                            if ($remainingCharacters > 0) {
                                                                                echo '...';
                                                                            }
                                                                        @endphp
                                                                    </a>
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
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
