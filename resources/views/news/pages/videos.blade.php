@extends('news.layouts.app')

@if ($lang == 'en') @section('title')
    International
@endsection
@else
@section('title')
    अन्तर्राष्ट्रिय
@endsection @endif

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            @if ($lang == 'en')
                <h1 class="section-title">Videos</h1>
            @else
                <h1 class="section-title">भिडियोहरू</h1>
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
                                        @foreach ($videos as $video)
                                            @if ($video->image)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="post medium-post">
                                                        <div class="entry-header">
                                                            <div class="entry-thumbnail">
                                                                <img class="img-fluid"
                                                                    style="width: 255px; height: 146px; object-fit:cover;"
                                                                    src="{{ "$pF/storage/uploads/videos/" . $video->image }}"
                                                                    alt="Image" />
                                                            </div>
                                                        </div>
                                                        <div class="post-content">
                                                            <div class="entry-meta">
                                                                <ul class="list-inline">
                                                                    <li class="publish-date">
                                                                        <a><i
                                                                                class="fa fa-clock-o"></i>{{ $video->created_at->format('F d, Y') }}</a>
                                                                    </li>
                                                                    <li class="views">
                                                                        <a><i class="fa fa-eye"></i>{{ $video->views }}</a>
                                                                    </li>
                                                                    {{-- <li class="loves">
                                                                        <a><i
                                                                                class="fa fa-heart-o"></i>{{ $video->likes }}</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                            <h2 class="entry-title">
                                                                <a href="{{ route('single-video', $video->slug) }}">
                                                                    @php
                                                                        $strippedContent = strip_tags($video->title);
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
                                @if ($videos->lastPage() > 1)
                                    <ul class="pagination">
                                        @if ($videos->currentPage() != 1)
                                            <li><a href="{{ $videos->previousPageUrl() }}" aria-label="Previous"><span
                                                        aria-hidden="true"><i class="fa fa-long-arrow-left"></i>
                                                        Previous</span></a></li>
                                        @endif

                                        @for ($i = 1; $i <= $videos->lastPage(); $i++)
                                            <li class="{{ $videos->currentPage() == $i ? 'active' : '' }}"><a
                                                    href="{{ $videos->url($i) }}">{{ $i }}</a></li>
                                        @endfor

                                        @if ($videos->currentPage() != $videos->lastPage())
                                            <li><a href="{{ $videos->nextPageUrl() }}" aria-label="Next"><span
                                                        aria-hidden="true">Next <i
                                                            class="fa fa-long-arrow-right"></i></span></a></li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        @else
                            <div class="pagination-wrapper text-center">
                                @if ($videos->lastPage() > 1)
                                    <ul class="pagination">
                                        @if ($videos->currentPage() != 1)
                                            <li><a href="{{ $videos->previousPageUrl() }}" aria-label="Previous"><span
                                                        aria-hidden="true"><i class="fa fa-long-arrow-left"></i>
                                                        अघिल्लो</span></a></li>
                                        @endif

                                        @for ($i = 1; $i <= $videos->lastPage(); $i++)
                                            <li class="{{ $videos->currentPage() == $i ? 'active' : '' }}"><a
                                                    href="{{ $videos->url($i) }}">{{ $i }}</a></li>
                                        @endfor

                                        @if ($videos->currentPage() != $videos->lastPage())
                                            <li><a href="{{ $videos->nextPageUrl() }}" aria-label="Next"><span
                                                        aria-hidden="true">अर्को <i
                                                            class="fa fa-long-arrow-right"></i></span></a></li>
                                        @endif
                                    </ul>
                                @endif
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
