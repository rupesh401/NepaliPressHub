@extends('news.layouts.app')


@section('content')

<div class="container">
    {{-- <div class="page-breadcrumbs">
        <h1 class="section-title">Worlds</h1>
    </div> --}}
    <div class="row">
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                <div id="site-content" class="site-content">
                    <div class="row">
                        <div class="col">
                            <div class="left-content">
                                <div class="details-news">
                                    <div class="post">
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
                        {{-- <div class="post google-add">
                            <div class="add inner-add text-center">
                                <a href="#"
                                    ><img
                                        class="img-fluid"
                                        src="images/post/google-add.jpg"
                                        alt="Image"
                                /></a>
                            </div>
                        </div> --}}
                       @include('news.inc.comments')
                        {{-- <div class="section">
                            <h1 class="section-title">Related Post(s)</h1>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="post medium-post">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img
                                                    class="img-fluid"
                                                    src="images/post/1.jpg"
                                                    alt="Image"
                                                />
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="publish-date">
                                                        <a href="#"
                                                            ><i class="fa fa-clock-o"></i> Nov 15, 2018
                                                        </a>
                                                    </li>
                                                    <li class="views">
                                                        <a href="#"><i class="fa fa-eye"></i>15k</a>
                                                    </li>
                                                    <li class="loves">
                                                        <a href="#"
                                                            ><i class="fa fa-heart-o"></i>278</a
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <h2 class="entry-title">
                                                <a href="news-details.html"
                                                    >Our closest relatives aren't fans of daylight
                                                    saving time</a
                                                >
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
            @include('news.inc.sidebar')
        </div>
    </div>  
    {{-- <div class="section">
        <div class="row">
            
            @include('news.inc.sidebar')
        </div>
    </div> --}}
</div>

@endsection