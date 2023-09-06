@extends('news.layouts.app')

@if ($lang == 'en') @section('title')
    {{ $category }}
@endsection
@else
@section('title')
    {{ $category }}
    @endsection @endif

@section('content')
    <div class="container-fluid">
        <div class="page-breadcrumbs">
            @if ($lang == 'en')
                <h1 class="section-title">{{ $category }}</h1>
            @else
                <h1 class="section-title">{{ $category }}</h1>
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
                                                        src="{{ ("$pF/storage/uploads/posts/".@$singleCatPost->image) }}"
                                                            alt="Image">
                                                    </div>
                                                    <div class="catagory world"><a >{{ @$singleCatPost->cat[0]->category }}</a></div>
                                                </div>
                                                <div class="post-content">
                                                    <div class="entry-meta">
                                                        <ul class="list-inline">
                                                            <li class="publish-date">
                                                                <i class="fa fa-clock-o"></i><a > {{ @$singleCatPost->created_at->format('F d, Y') }}
                                                                </a>
                                                            </li>
                                                            <li class="views">
                                                                <i class="fa fa-eye"></i><a >{{ @$singleCatPost->views }}</a>
                                                            </li>
                                                            <li class="loves">
                                                                <i class="fa fa-heart-o"></i><a >{{ @$singleCatPost->likes }}</a>
                                                            </li>
                                                            <li class="comments">
                                                                <i class="fa fa-comment-o"></i><a >{{ @$singleCatPost->com->count() }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h2 class="entry-title">
                                                        <a href="{{ route('single-post', @$singleCatPost->slug) }}">{{ @$singleCatPost->title }}</a>
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
                            @foreach ($categoryPosts as $post)
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section">
                        <div class="row">
                            @foreach ($morePosts as $post)
                                @if ($post->image)
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                                                            <a><i class="fa fa-eye"></i>{{ $post->views }}</a>
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
            @if ($lang == 'en')
            <div class="pagination-wrapper text-center">
                @if($morePosts->lastPage() > 1)
                <ul class="pagination">
                    @if($morePosts->currentPage() != 1)
                    <li><a href="{{ $morePosts->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous</span></a></li>
                    @endif
            
                    @for($i = 1; $i <= $morePosts->lastPage(); $i++)
                        <li class="{{ ($morePosts->currentPage() == $i) ? 'active' : '' }}"><a href="{{ $morePosts->url($i) }}">{{ $i }}</a></li>
                    @endfor
            
                    @if($morePosts->currentPage() != $morePosts->lastPage())
                    <li><a href="{{ $morePosts->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">Next <i class="fa fa-long-arrow-right"></i></span></a></li>
                    @endif
                </ul>
                @endif
            </div>
            @else
            <div class="pagination-wrapper text-center">
                @if($morePosts->lastPage() > 1)
                <ul class="pagination">
                    @if($morePosts->currentPage() != 1)
                    <li><a href="{{ $morePosts->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> अघिल्लो</span></a></li>
                    @endif
            
                    @for($i = 1; $i <= $morePosts->lastPage(); $i++)
                        <li class="{{ ($morePosts->currentPage() == $i) ? 'active' : '' }}"><a href="{{ $morePosts->url($i) }}">{{ $i }}</a></li>
                    @endfor
            
                    @if($morePosts->currentPage() != $morePosts->lastPage())
                    <li><a href="{{ $morePosts->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">अर्को <i class="fa fa-long-arrow-right"></i></span></a></li>
                    @endif
                </ul>
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection
