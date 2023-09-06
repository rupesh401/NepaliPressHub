@extends('news.layouts.app')

@section('title') {{ $province }} @endsection

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            <h1 class="section-title">{{ $province }}</h1>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="section">
                                    <div class="row">
                                        @foreach ($provincesPosts as $post)
                                        <div class="col-lg-6">
                                            <div class="post">
                                                <div class="entry-header">
                                                    <div class="entry-thumbnail">
                                                        <img class="img-fluid" src='{{ ("$pF/storage/uploads/posts/".$post->image) }}'
                                                            alt="Image" />
                                                    </div>
                                                </div>
                                                <div class="post-content">
                                                    <div class="entry-meta">
                                                        <ul class="list-inline">
                                                            <li class="publish-date"><a><i class="fa fa-clock-o"></i> {{ $post->created_at->format('F d, Y') }} </a></li>
                                                            <li class="views"><a><i class="fa fa-eye"></i>{{ $post->views }}</a></li>
                                                            <li class="loves"><a><i class="fa fa-heart-o"></i>{{ $post->likes }}</a></li>
                                                            <li class="comments"><i class="fa fa-comment-o"></i><a>{{ $post->com->count() }}</a></li>
                                                        </ul>
                                                    </div>
                                                    <h2 class="entry-title m-0">
                                                        <a href="{{ route('single-post', $post->slug) }}">
                                                            @php
                                                            $strippedContent = strip_tags($post->title);
                                                            $truncatedContent = mb_substr($strippedContent, 0, 38, 'UTF-8');
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
                                                    <div class="entry-content m-0 p-0">
                                                        <p>
                                                            @php
                                                            $strippedContent = strip_tags($post->content);
                                                            $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
                                                            $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                            
                                                            // Display the truncated content
                                                            echo $truncatedContent;
                                                            
                                                            // If there are remaining characters, show an ellipsis
                                                            if ($remainingCharacters > 0) {
                                                                echo '...';
                                                            }
                                                        @endphp
                                                        </p>
                                                    </div>
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
                            @if($provincesPosts->lastPage() > 1)
                            <ul class="pagination">
                                @if($provincesPosts->currentPage() != 1)
                                <li><a href="{{ $provincesPosts->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous</span></a></li>
                                @endif
                        
                                @for($i = 1; $i <= $provincesPosts->lastPage(); $i++)
                                    <li class="{{ ($provincesPosts->currentPage() == $i) ? 'active' : '' }}"><a href="{{ $provincesPosts->url($i) }}">{{ $i }}</a></li>
                                @endfor
                        
                                @if($provincesPosts->currentPage() != $provincesPosts->lastPage())
                                <li><a href="{{ $provincesPosts->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">Next <i class="fa fa-long-arrow-right"></i></span></a></li>
                                @endif
                            </ul>
                            @endif
                        </div>
                        @else
                        <div class="pagination-wrapper text-center">
                            @if($provincesPosts->lastPage() > 1)
                            <ul class="pagination">
                                @if($provincesPosts->currentPage() != 1)
                                <li><a href="{{ $provincesPosts->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> अघिल्लो</span></a></li>
                                @endif
                        
                                @for($i = 1; $i <= $provincesPosts->lastPage(); $i++)
                                    <li class="{{ ($provincesPosts->currentPage() == $i) ? 'active' : '' }}"><a href="{{ $provincesPosts->url($i) }}">{{ $i }}</a></li>
                                @endfor
                        
                                @if($provincesPosts->currentPage() != $provincesPosts->lastPage())
                                <li><a href="{{ $provincesPosts->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">अर्को <i class="fa fa-long-arrow-right"></i></span></a></li>
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
