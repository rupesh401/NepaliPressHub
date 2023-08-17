@extends('news.layouts.app')

@section('title') {{ $singleVideo->title }} @endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                <div id="site-content" class="site-content">
                    <div class="row">
                        <div class="col">
                            <div class="left-content">
                                <div class="details-news">
                                    <div class="post">
                                        @if ($singleVideo->image)
                                            <div class="entry-header">
                                                <div class="entry-thumbnail">
                                                    <img
                                                        class="img-fluid"
                                                        style="width: 825px; height: 550px; object-fit: cover;"
                                                        src="{{ ("$pF/storage/uploads/videos/".$singleVideo->image) }}"
                                                        alt="Image"
                                                    />
                                                </div>
                                            </div> 
                                        @endif
                                        <div class="post-content">
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="posted-by">
                                                        {{-- <i class="fa fa-user"></i> by --}}
                                                        {{-- <a>{{ $singleVideo->usr[0]->full_name }}</a> --}}
                                                    </li>
                                                    <li class="publish-date">
                                                        <a
                                                            ><i class="fa fa-clock-o"></i> {{ $singleVideo->created_at->format('F d, Y') }}
                                                        </a>
                                                    </li>
                                                    <li class="views">
                                                        <a><i class="fa fa-eye"></i>{{ $singleVideo->views }}</a>
                                                    </li>
                                                    <li class="loves">
                                                        {{-- <i class="meta-like fa fa-heart-o"></i><a>{{ $singleVideo->likes }}</a
                                                        > --}}
                                                    </li>
                                                    <li class="comments">
                                                        {{-- <i class="fa fa-comment-o"></i
                                                        > --}}
                                                        {{-- <a>{{ $singleVideo->com->count() }}</a> --}}
                                                    </li>
                                                </ul>
                                            </div>
                                            <h2 class="entry-title">
                                               {{ $singleVideo->title }}
                                            </h2>
                                            <div class="entry-content">
                                                <iframe class="img-fluid"
                                                style="height: 450px;"
                                                frameborder="0" allowfullscreen="true"
                                                src="{{ 'https://www.youtube.com/embed/' . $singleVideo->link . '?showinfo=0' }}">
                                            </iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-12">
                       
                       @include('news.inc.comments')
                       
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
            @include('news.inc.sidebar')
        </div>
    </div>  
</div>

@endsection