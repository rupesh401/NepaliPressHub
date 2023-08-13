@extends('news.layouts.app')

@section('title') {{ $keyword }} @endsection

@section('content')
<div class="container">
    <div class="page-breadcrumbs">
        @if ($lang == 'en')
        <h1 class="section-title">Searching for <i>{{ $keyword }}</i></h1>
        @else
        <h1 class="section-title">खोज्दै <i>{{ $keyword }}</i></h1>
        @endif
    </div>
    <div class="section">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section">
                                <div class="row">
                                    @foreach ($posts as $post)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="post medium-post">
                                                <div class="entry-header">
                                                    <div class="entry-thumbnail">
                                                        <img class="img-fluid"
                                                            style="width: 255px; height: 146px; object-fit:cover;"
                                                            src="{{ "$pF/storage/uploads/posts/".$post->image }}"
                                                            alt="Image" />
                                                    </div>
                                                </div>
                                                <div class="post-content">
                                                    <div class="entry-meta">
                                                        <ul class="list-inline">
                                                            <li class="publish-date">
                                                                <a><i class="fa fa-clock-o"></i>{{ $post->created_at->format('F d, Y') }}</a>
                                                            </li>
                                                            <li class="views">
                                                                <a><i class="fa fa-eye"></i>{{ $post->views }}</a>
                                                            </li>
                                                            <li class="loves">
                                                                <a><i class="fa fa-heart-o"></i>{{ $post->likes }}</a>
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
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($lang == 'en')
                    <div class="pagination-wrapper text-center">
                        <ul class="pagination">
                            @if ($posts->onFirstPage())
                                <li class="disabled">
                                    <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous Page</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous
                                            Page</span>
                                    </a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                <li class="{{ $posts->currentPage() == $i ? 'active' : '' }}">
                                    <a class="text-center" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($posts->hasMorePages())
                                <li>
                                    <a href="{{ $posts->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">Next Page <i class="fa fa-long-arrow-right"></i></span>
                                    </a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span aria-hidden="true">Next Page <i class="fa fa-long-arrow-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @else
                    <div class="pagination-wrapper text-center">
                        <ul class="pagination">
                            @if ($posts->onFirstPage())
                                <li class="disabled">
                                    <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> अघिल्लो पृष्ठ</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> अघिल्लो पृष्ठ</span>
                                    </a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                <li class="{{ $posts->currentPage() == $i ? 'active' : '' }}">
                                    <a class="text-center" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($posts->hasMorePages())
                                <li>
                                    <a href="{{ $posts->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">अर्को पाना <i class="fa fa-long-arrow-right"></i></span>
                                    </a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span aria-hidden="true">अर्को पाना <i class="fa fa-long-arrow-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
                @include('news.inc.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
