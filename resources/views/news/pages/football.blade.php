@extends('news.layouts.app')

@section('title')
    {{ $football }}
@endsection

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            <h1 class="section-title"> 
                <img style="width: 30px" class="img-fluid"
                src="{{ "$pF/storage/uploads/league/logo/".$results[0]->match->home->league[0]->logo }}"
                alt="Image" />
                {{ $football }} Fixtures and Results</h1>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 tr-sticky">
                                <div class="middle-content theiaStickySidebar">
                                    <div class="section sports-section">
                                        <div class="football-result post">
                                            <div class="league-result">
                                                <ul>
                                                    @foreach ($results as $result)
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-5 text-right">
                                                                    <a href="{{ route('preview-match', ['home' => $result->match->home->team , 'away' => $result->match->away->team , 'link' => $result->link]) }}">
                                                                        <span
                                                                            class="team-name">{{ @$result->match->home->team }}</span>
                                                                        <img style="width: 30px" class="img-fluid"
                                                                            src="{{ "$pF/storage/uploads/team/logo/".$result->match->home->logo }}"
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
                                                                    <a href="{{ route('preview-match', ['home' => $result->match->home->team , 'away' => $result->match->away->team , 'link' => $result->link]) }}">
                                                                        <img style="width: 30px" class="img-fluid"
                                                                            src="{{ "$pF/storage/uploads/team/logo/".$result->match->away->logo }}"
                                                                            alt="Image" />
                                                                        <span
                                                                            class="team-name">{{ @$result->match->away->team }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
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
