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
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xm-12">
                        <div class="row">
                            <div id="home-slider" class="owl-carousel owl-theme">
                                <div class="owl-wrapper-outer">
                                    <div class="owl-wrapper">
                                        <div class="owl-item" id="custom-post">
                                            <div class="post feature-post">
                                                <div class="entry-header">
                                                    <div class="entry-thumbnail">
                                                        <img class="img-fluid" style="width: 100%; height: 395px; object-fit:cover;"
                                                        src="{{ ("$pF/storage/uploads/posts/".$singleEntertainment->image) }}"
                                                            alt="Image">
                                                    </div>
                                                    <div class="catagory world"><a >{{ $singleEntertainment->cat[0]->category }}</a></div>
                                                </div>
                                                <div class="post-content">
                                                    <div class="entry-meta">
                                                        <ul class="list-inline">
                                                            <li class="publish-date">
                                                                <i class="fa fa-clock-o"></i><a > {{ $singleEntertainment->created_at->format('F d, Y') }}
                                                                </a>
                                                            </li>
                                                            <li class="views">
                                                                <i class="fa fa-eye"></i><a >{{ $singleEntertainment->views }}</a>
                                                            </li>
                                                            <li class="loves">
                                                                <i class="fa fa-heart-o"></i><a >{{ $singleEntertainment->likes }}</a>
                                                            </li>
                                                            <li class="comments">
                                                                <i class="fa fa-comment-o"></i><a >{{ $singleEntertainment->com->count() }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h2 class="entry-title">
                                                        <a href="{{ route('single-post', $singleEntertainment->slug) }}">{{ $singleEntertainment->title }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xm-12">
                        <div class="row">
                            @foreach ($entertainments as $post)
                            <div class="col-lg-4">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid" 
                                            src="{{ "$pF/storage/uploads/posts/" . $post->image }}"
                                                alt="Image">
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date">
                                                    <a>
                                                        <i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="{{ route('single-post', $post->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($post->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 22, 'UTF-8');
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
