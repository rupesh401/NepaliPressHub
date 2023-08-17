@extends('news.layouts.app')

@if ($lang == 'en') @section('title')
    Gallery
@endsection
@else
@section('title')
    ग्यालेरी
    @endsection @endif

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            @if ($lang == 'en')
                <h1 class="section-title">Gallery</h1>
            @else
                <h1 class="section-title">ग्यालेरी</h1>
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
                                        @foreach ($gallery as $gal)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="post medium-post">
                                                    <div class="entry-header">
                                                        <div class="entry-thumbnail">
                                                            <a href="{{ route('gallery-album', $gal->slug) }}">
                                                                <img class="img-fluid"
                                                                    style="width: 255px; height: 146px; object-fit:cover;"
                                                                    src="{{ "$pF/storage/uploads/gallery/images/" . $gal->img[0]->image }}"
                                                                    alt="Image" />
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="post-content">
                                                        <div class="entry-meta">
                                                            <ul class="list-inline">
                                                                <li class="publish-date">
                                                                    <a><i
                                                                            class="fa fa-clock-o"></i>{{ $gal->created_at->format('F d, Y') }}</a>
                                                                </li>
                                                                {{-- <li class="views">
                                                                    <a><i class="fa fa-eye"></i>{{ $gal->views }}</a>
                                                                </li>
                                                                <li class="loves">
                                                                    <a><i class="fa fa-heart-o"></i>{{ $gal->likes }}</a>
                                                                </li> --}}
                                                            </ul>
                                                        </div>
                                                        <h2 class="entry-title">
                                                            <a href="{{ route('gallery-album', $gal->slug) }}">
                                                                @php
                                                                    $strippedContent = strip_tags($gal->album_title);
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
                                        @foreach ($videos as $video)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="post medium-post">
                                                    <div class="entry-header">
                                                        <div class="entry-thumbnail">
                                                            @if ($video->image != '')
                                                                <img class="img-fluid"
                                                                    style="width: 255px; height: 146px; object-fit:cover;"
                                                                    src="{{ "$pF/storage/uploads/videos/" . $video->image }}"
                                                                    alt="Image" />
                                                            @else
                                                                <iframe
                                                                    style="width: 255px; height: 146px; object-fit:cover;"
                                                                    frameborder="0" allowfullscreen="true"
                                                                    src="{{ 'https://www.youtube.com/embed/' . $video->link . '?showinfo=0' }}">
                                                                </iframe>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="post-content">
                                                        <div class="entry-meta">
                                                            <ul class="list-inline">
                                                                <li class="publish-date">
                                                                    <a><i
                                                                            class="fa fa-clock-o"></i>{{ $video->created_at->format('F d, Y') }}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <h2 class="entry-title">
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
                                @if ($gallery->lastPage() > 1)
                                    <ul class="pagination">
                                        @if ($gallery->currentPage() != 1)
                                            <li><a href="{{ $gallery->previousPageUrl() }}"
                                                    aria-label="Previous"><span aria-hidden="true"><i
                                                            class="fa fa-long-arrow-left"></i> Previous</span></a></li>
                                        @endif

                                        @for ($i = 1; $i <= $gallery->lastPage(); $i++)
                                            <li class="{{ $gallery->currentPage() == $i ? 'active' : '' }}"><a
                                                    href="{{ $gallery->url($i) }}">{{ $i }}</a></li>
                                        @endfor

                                        @if ($gallery->currentPage() != $gallery->lastPage())
                                            <li><a href="{{ $gallery->nextPageUrl() }}" aria-label="Next"><span
                                                        aria-hidden="true">Next <i
                                                            class="fa fa-long-arrow-right"></i></span></a></li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        @else
                            <div class="pagination-wrapper text-center">
                                @if ($gallery->lastPage() > 1)
                                    <ul class="pagination">
                                        @if ($gallery->currentPage() != 1)
                                            <li><a href="{{ $gallery->previousPageUrl() }}"
                                                    aria-label="Previous"><span aria-hidden="true"><i
                                                            class="fa fa-long-arrow-left"></i> अघिल्लो</span></a></li>
                                        @endif

                                        @for ($i = 1; $i <= $gallery->lastPage(); $i++)
                                            <li class="{{ $gallery->currentPage() == $i ? 'active' : '' }}"><a
                                                    href="{{ $provincesPosts->url($i) }}">{{ $i }}</a></li>
                                        @endfor

                                        @if ($provincesPosts->currentPage() != $provincesPosts->lastPage())
                                            <li><a href="{{ $provincesPosts->nextPageUrl() }}" aria-label="Next"><span
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
