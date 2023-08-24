@extends('news.layouts.app')

@section('title')
    {{ @$match->home->team }} Vs {{ @$match->away->team }}
@endsection

@section('content')
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
    {{-- <div class="container">
    <div class="page-breadcrumbs">
       @if ($lang == 'en')
       @if ($singlePost->prov->count() > 0)
       <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> Home </a> > <a href="{{ route('single-provinces', $singlePost->prov[0]->province) }}">{{ $singlePost->prov[0]->province }}</a> > {{ $singlePost->title }}</h1>
       @else
       <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> Home </a> > <a href="{{ route('news') }}"> International News</a> > {{ $singlePost->title }}</h1>
       @endif
       @else
       @if ($singlePost->prov->count() > 0)
       <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> घर </a> > <a href="{{ route('single-provinces', $singlePost->prov[0]->province) }}">{{ $singlePost->prov[0]->province }}</a> > {{ $singlePost->title }}</h1>
       @else
       <h1 class="section-title" style="font-size: 15px"><a href="{{ route('home') }}"> घर </a> > <a href="{{ route('news') }}"> अन्तर्राष्ट्रिय समाचार </a> > {{ $singlePost->title }}</h1>
       @endif
       @endif
    </div>
    <div class="row">
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                <div id="site-content" class="site-content">
                    <div class="row">
                        <div class="col">
                            <div class="left-content">
                                <div class="details-news">
                                    <div class="post">
                                        @if ($singlePost->image)
                                            <div class="entry-header">
                                                <div class="entry-thumbnail">
                                                    <img
                                                        class="img-fluid"
                                                        style="width: 825px; height: 550px; object-fit: cover;"
                                                        src="{{ ("$pF/storage/uploads/posts/".$singlePost->image) }}"
                                                        alt="Image"
                                                    />
                                                </div>
                                            </div> 
                                        @endif
                                        <div class="post-content">
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="posted-by">
                                                        <i class="fa fa-user"></i> by
                                                        <a>{{ $singlePost->usr[0]->full_name }}</a>
                                                    </li>
                                                    <li class="publish-date">
                                                        <a
                                                            ><i class="fa fa-clock-o"></i> {{ $singlePost->created_at->format('F d, Y') }}
                                                        </a>
                                                    </li>
                                                    <li class="views">
                                                        <a><i class="fa fa-eye"></i>{{ $singlePost->views }}</a>
                                                    </li>
                                                    <li class="loves">
                                                        <i class="meta-like fa fa-heart-o"></i><a>{{ $singlePost->likes }}</a
                                                        >
                                                    </li>
                                                    <li class="comments">
                                                        <i class="fa fa-comment-o"></i
                                                        ><a>{{ $singlePost->com->count() }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h2 class="entry-title">
                                               {{ $singlePost->title }}
                                            </h2>
                                            <div class="entry-content">
                                                {!! $singlePost->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                       @include('news.inc.comments')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
            @include('news.inc.sidebar')
        </div>
    </div>  
</div> --}}
@endsection
