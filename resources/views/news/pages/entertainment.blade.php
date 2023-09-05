@extends('news.layouts.app')

@if ($lang == 'en') @section('title')
    Entertainment
@endsection
@else
@section('title')
    मनोरञ्जन
    @endsection @endif

@section('content')
    <div class="container-fluid">
        <div class="page-breadcrumbs">
            @if ($lang == 'en')
                <h1 class="section-title">Entertainment</h1>
            @else
                <h1 class="section-title">मनोरञ्जन</h1>
            @endif
        </div>
        <div class="section">
            <div class="site-content col-12">
                <div class="row">
                    <div class="col-7">
                        <div class="row">
                            <div id="home-slider" class="owl-carousel owl-theme">
                                <div class="owl-wrapper-outer">
                                    <div class="owl-wrapper">
                                        <div class="owl-item" id="custom-post">
                                            <div class="post feature-post">
                                                <div class="entry-header">
                                                    <div class="entry-thumbnail">
                                                        <img class="img-fluid" style="width: 100%; height: 50% object-fit:cover;"
                                                            src="{{ "$pF/news/assets/images/post/slider/1.jpg" }}"
                                                            alt="Image">
                                                    </div>
                                                    <div class="catagory world"><a href="#">World</a></div>
                                                </div>
                                                <div class="post-content">
                                                    <div class="entry-meta">
                                                        <ul class="list-inline">
                                                            <li class="publish-date">
                                                                <i class="fa fa-clock-o"></i><a href="#"> Nov 1, 2018
                                                                </a>
                                                            </li>
                                                            <li class="views">
                                                                <i class="fa fa-eye"></i><a href="#">15k</a>
                                                            </li>
                                                            <li class="loves">
                                                                <i class="fa fa-heart-o"></i><a href="#">278</a>
                                                            </li>
                                                            <li class="comments">
                                                                <i class="fa fa-comment-o"></i><a href="#">189</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h2 class="entry-title">
                                                        <a href="news-details.html">We Are Seeing The Effects Of The Minimum
                                                            Wage Rise
                                                            In San Francisco</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" src="{{ "$pF/news/assets/images/post/t2.jpg" }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a href="#"><i class="fa fa-clock-o"></i> Nov 15,
                                                        2018
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="news-details.html">Samsung Pay will support online shop</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
