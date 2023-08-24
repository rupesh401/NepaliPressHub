@extends('news.layouts.app')

@section('title') @endsection

@section('content')

<div class="col-lg-12 col-md-12 tr-sticky">
    <div class="middle-content theiaStickySidebar">
        <div class="section sports-section">
            {{-- <h1 class="section-title title">Sports</h1>
            <div class="cat-menu">
                <a href="listing-sports.html">See all</a>
            </div> --}}
            <div class="football-result post">
                <div class="featured-result">
                    <h2 class="league-name">Premier League</h2>
                    <div class="row">
                        <div class="col-4">
                            <img
                                class="img-fluid"
                                src="images/gallery/league1.png"
                                alt="Image"
                            />
                            <span class="match-result">3</span>
                        </div>
                        <div class="col-4">
                            <span class="verses">VS</span>
                            <span class="match-time">90:00</span>
                        </div>
                        <div class="col-4">
                            <img
                                class="img-fluid"
                                src="images/gallery/league2.png"
                                alt="Image"
                            />
                            <span class="match-result">0</span>
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