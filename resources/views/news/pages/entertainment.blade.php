@extends('news.layouts.app')

@if ($lang == 'en') @section('title')
    Entertainment
@endsection
@else
@section('title')
    मनोरञ्जन
    @endsection @endif

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            @if ($lang == 'en')
                <h1 class="section-title">Entertainment</h1>
            @else
                <h1 class="section-title">मनोरञ्जन</h1>
            @endif
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section">
                                <div class="row">
                                    @foreach ($intNews as $post)
                                        @if ($post->image)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="post medium-post">
                                                    <div class="entry-header">
                                                        <div class="entry-thumbnail">
                                                            <img class="img-fluid"
                                                                style="object-fit:cover;"
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
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($lang == 'en')
                        <div class="pagination-wrapper text-center">
                            @if ($intNews->lastPage() > 1)
                                <ul class="pagination">
                                    @if ($intNews->currentPage() != 1)
                                        <li><a href="{{ $intNews->previousPageUrl() }}" aria-label="Previous"><span
                                                    aria-hidden="true"><i class="fa fa-long-arrow-left"></i>
                                                    Previous</span></a></li>
                                    @endif

                                    @for ($i = 1; $i <= $intNews->lastPage(); $i++)
                                        <li class="{{ $intNews->currentPage() == $i ? 'active' : '' }}"><a
                                                href="{{ $intNews->url($i) }}">{{ $i }}</a></li>
                                    @endfor

                                    @if ($intNews->currentPage() != $intNews->lastPage())
                                        <li><a href="{{ $intNews->nextPageUrl() }}" aria-label="Next"><span
                                                    aria-hidden="true">Next <i
                                                        class="fa fa-long-arrow-right"></i></span></a></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    @else
                        <div class="pagination-wrapper text-center">
                            @if ($intNews->lastPage() > 1)
                                <ul class="pagination">
                                    @if ($intNews->currentPage() != 1)
                                        <li><a href="{{ $intNews->previousPageUrl() }}" aria-label="Previous"><span
                                                    aria-hidden="true"><i class="fa fa-long-arrow-left"></i>
                                                    अघिल्लो</span></a></li>
                                    @endif

                                    @for ($i = 1; $i <= $intNews->lastPage(); $i++)
                                        <li class="{{ $intNews->currentPage() == $i ? 'active' : '' }}"><a
                                                href="{{ $intNews->url($i) }}">{{ $i }}</a></li>
                                    @endfor

                                    @if ($intNews->currentPage() != $intNews->lastPage())
                                        <li><a href="{{ $intNews->nextPageUrl() }}" aria-label="Next"><span
                                                    aria-hidden="true">अर्को <i
                                                        class="fa fa-long-arrow-right"></i></span></a></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
