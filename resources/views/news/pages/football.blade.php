@extends('news.layouts.app')

@section('title')
    {{ $football }}
@endsection

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            <h1 class="section-title">
                <img style="width: 30px" class="img-fluid"
                    src="{{ "$pF/storage/uploads/league/logo/" . @$results[0]->match->home->league[0]->logo }}"
                    alt="Image" />
                {{ $football }} Fixtures and Results
            </h1>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 tr-sticky">
                                <div class="middle-content theiaStickySidebar">
                                    <div class="section  mb-0 sports-section">
                                        <div class="football-result post">
                                            <div class="league-result">
                                                <ul>
                                                    <li class="list-tag p-1">
                                                        <div class="row">
                                                            <div class="col-4 filter-button text-center yesterday"
                                                                onclick="yesterdayMatch()">
                                                                <a class="a-tag">
                                                                    <span class="team-name filter-date">Yesterday <br>
                                                                        <span class="span-tag">{{ $yesterdayDate }}</span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="col-4 filter-button text-center today filter-active"
                                                                onclick="todayMatch()">
                                                                <a class="a-tag">
                                                                    <span class="team-name filter-date">Today<br>
                                                                        <span
                                                                            class="span-tag">{{ $currentDate->toFormattedDateString() }}</span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="col-4 filter-button text-center tomorrow"
                                                                onclick="tomorrowMatch()">
                                                                <a class="a-tag">
                                                                    <span class="team-name filter-date">Tomorrow <br>
                                                                        <span class="span-tag">{{ $tomorrowDate }}</span>
                                                                    </span>
                                                                </a>
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
                    </div> --}}
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="middle-content">
                                    <div class="section  mb-0 sports-section">
                                        <div class="football-result post">
                                            {{-- <div class="league-result">
                                                <div id="owl-demo" class="owl-carousel owl-theme">
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="filter-button text-center today filter-active" onclick="todayMatch()">
                                                            <a class="a-tag">
                                                                <span class="team-name filter-date">Today<br>
                                                                    <span class="span-tag">{{ $currentDate->toFormattedDateString() }}</span> 
                                                                </span>
                                                            </a>
                                                        </div>
                                                </div>
                                            </div> --}}
                                            <div class="league-result">
                                                <div id="carouselExampleControls" class="carousel slide">
                                                    <div class="carousel-inner">
                                                        @foreach ($groupedResults as $index => $item)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <div class="filter-button text-center today filter-active"
                                                                onclick="handleFilterDateMatch('{{ $item }}')">
                                                                    <a class="a-tag">
                                                                        <span class="team-name filter-date">
                                                                            @if (\Carbon\Carbon::parse($currentDate)->format('M j, Y') === \Carbon\Carbon::parse($item)->format('M j, Y'))
                                                                                Today
                                                                            @elseif ($yesterdayDate === \Carbon\Carbon::parse($item)->format('M j, Y'))
                                                                                Yesterday
                                                                            @elseif ($tomorrowDate === \Carbon\Carbon::parse($item)->format('M j, Y'))
                                                                                Tomorrow
                                                                            @else
                                                                                {{ \Carbon\Carbon::parse($item)->format('l') }}
                                                                            @endif
                                                                            <br>
                                                                            <span class="span-tag">{{ \Carbon\Carbon::parse($item)->format('M j, Y') }}</span>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleControls"
                                                        role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls"
                                                        role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 tr-sticky">
                                <div class="middle-content theiaStickySidebar">
                                    <div class="section sports-section">
                                        <div class="football-result post">
                                            <div class="league-result">
                                                <ul id="results-list"></ul>
                                                {{-- <ul>
                                                    @foreach ($results as $result)
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-5 text-right">
                                                                    <a
                                                                        href="{{ route('preview-match', ['league' => $football, 'home' => $result->match->home->team, 'away' => $result->match->away->team, 'link' => $result->link]) }}">
                                                                        <span
                                                                            class="team-name">{{ @$result->match->home->team }}</span>
                                                                        <img style="width: 30px" class="img-fluid"
                                                                            src="{{ "$pF/storage/uploads/team/logo/" . $result->match->home->logo }}"
                                                                            alt="Image" />
                                                                    </a>
                                                                </div>
                                                                <div class="col-2">
                                                                    @if ($result->status == 'Started')
                                                                        <span class="match-result p-1"
                                                                            style="background-color: red; color: white; font-size: 10px;">
                                                                            Live</span><br>
                                                                    @endif
                                                                    <span class="match-result">
                                                                        @if ($result->status == 'Not Started' || $result->status == 'Postponed')
                                                                            -- &nbsp; --
                                                                        @else
                                                                            {{ $result->home_score }}-{{ $result->away_score }}
                                                                        @endif
                                                                    </span>
                                                                    <br>
                                                                    <span class="match-result">
                                                                        @if ($result->status == 'Started')
                                                                            {{ $result->minutes }}'
                                                                        @elseif ($result->status == 'Not Started')
                                                                            {{ $result->time }}
                                                                        @elseif ($result->status == 'Finished')
                                                                            Finished
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="col-5 text-left">
                                                                    <a
                                                                        href="{{ route('preview-match', ['league' => $football, 'home' => $result->match->home->team, 'away' => $result->match->away->team, 'link' => $result->link]) }}">
                                                                        <img style="width: 30px" class="img-fluid"
                                                                            src="{{ "$pF/storage/uploads/team/logo/" . $result->match->away->logo }}"
                                                                            alt="Image" />
                                                                        <span
                                                                            class="team-name">{{ @$result->match->away->team }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul> --}}
                                            </div>
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
    @endsection
