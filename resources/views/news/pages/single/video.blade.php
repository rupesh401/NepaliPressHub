@extends('tech.layouts.app')

@section('image')video/{{ $singleVideo->image }}@endsection
@section('desc'){{ $singleVideo->title }}@endsection
@section('url')video/{{ $singleVideo->slug }}@endsection
@section('title')
{{ $singleVideo->title }}
@endsection
@section('content')
<section class="section single-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="page-wrapper">
                    <div class="blog-title-area text-center">
                        <ol class="breadcrumb hidden-xs-down">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('videos') }}">Videos</a></li>
                            <li class="breadcrumb-item active">{{ $singleVideo->title }}</li>
                        </ol>

                        <span class="color-orange"><a href="{{ route('videos') }}" title="">Videos</a></span>
                        
                        <h1>{{ $singleVideo->title }}</h1>

                        <div class="blog-meta big-meta">
                            <small><a href="tech-single.html" title="">{{ $singleVideo->created_at->format('d F, Y') }}</a></small>
                            <small><a href="#" title=""><i class="fa fa-eye"></i> {{ $singleVideo->views }}</a></small>
                        </div><!-- end meta -->

                        <div class="post-sharing">
                            <ul class="list-inline">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=techviewed.com/video/{{ $singleVideo->slug }}" target="_blank" rel="noopener noreferrer" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i>
                                        <span class="down-mobile">Share on Facebook</span></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url=techviewed.com/video/{{ $singleVideo->slug }}&text={{ $singleVideo->title }}" target="_blank" rel="noopener noreferrer" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i>
                                        <span class="down-mobile">Tweet on Twitter</span></a></li>
                                        <li><a href="instagram://library?AssetPath=techviewed.com/public/storage/uploads/videos/{{ $singleVideo->image }}]&InstagramCaption={{ $singleVideo->title }}" target="_blank" rel="noopener noreferrer" class="gp-button btn btn-primary"><i class="fa fa-instagram"></i><span class="down-mobile"> Share on Instagram</span></a></li>
                            </ul>
                        </div><!-- end post-sharing -->
                    </div><!-- end title -->

                    <div class="single-post-media">
                        <img src='{{ ("$pF/storage/uploads/videos/".$singleVideo->image) }}' alt="Video Image" class="img-fluid">
                    </div><!-- end media -->

                    <div class="blog-content">  
                        <div class="pp">
                            <iframe width="750" height="400" src="{{ 'https://www.youtube.com/embed/'.$singleVideo->link }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div><!-- end pp -->
                    </div><!-- end content -->

                    <div class="blog-title-area">
                        {{-- <div class="tag-cloud-single">
                            <span>Tags</span>
                            <small><a href="#" title="">lifestyle</a></small>
                            <small><a href="#" title="">colorful</a></small>
                            <small><a href="#" title="">trending</a></small>
                            <small><a href="#" title="">another tag</a></small>
                        </div><!-- end meta --> --}}

                        <div class="post-sharing">
                            <ul class="list-inline">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=techviewed.com/video/{{ $singleVideo->slug }}" target="_blank" rel="noopener noreferrer" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i>
                                        <span class="down-mobile">Share on Facebook</span></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url=techviewed.com/video/{{ $singleVideo->slug }}&text={{ $singleVideo->title }}" target="_blank" rel="noopener noreferrer" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i>
                                        <span class="down-mobile">Tweet on Twitter</span></a></li>
                                        <li><a href="instagram://library?AssetPath=techviewed.com/public/storage/uploads/videos/{{ $singleVideo->image }}]&InstagramCaption={{ $singleVideo->title }}" target="_blank" rel="noopener noreferrer" class="gp-button btn btn-primary"><i class="fa fa-instagram"></i><span class="down-mobile"> Share on Instagram</span></a></li>
                            </ul>
                        </div><!-- end post-sharing -->
                    </div><!-- end title -->

                    <div class="custombox prevnextpost clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="blog-list-widget">
                                    <div class="list-group">
                                        <a href="{{ route('video', $previousPost->slug) }}"
                                            class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 justify-content-between text-right">
                                                <img style="height: 49px; object-fit: cover;" src='{{ ("$pF/storage/uploads/videos/".$previousPost->image) }}' alt="Post Image"
                                                    class="img-fluid float-right">
                                                <h5 class="mb-1">{{ substr($previousPost->title, 0, 40) . '...' }}</h5>
                                                <small>Prev Post</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-6">
                                <div class="blog-list-widget">
                                    <div class="list-group">
                                        <a href="{{ route('video', $nextPost->slug) }}"
                                            class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 justify-content-between">
                                                <img style="height: 49px; object-fit: cover;" src='{{ ("$pF/storage/uploads/videos/".$nextPost->image) }}' alt="Video Image"
                                                    class="img-fluid float-left">
                                                <h5 class="mb-1">{{ substr($nextPost->title, 0, 40) . '...' }}</h5>
                                                <small>Next Post</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end author-box -->

                    <hr class="invis1">

                    @if($recommendedVideos->count() > 0)
                        <div class="custombox clearfix">
                            <h4 class="small-title">You may also like</h4>
                            <div class="row">
                                @foreach ($recommendedVideos as $video)
                                    <div class="col-lg-6">
                                        <div class="blog-box">
                                            <div class="post-media">
                                                <a href="{{ route('video', $video->slug) }}">
                                                    <img style="height: 205px; object-fit: cover;" src='{{ ("$pF/storage/uploads/videos/".$video->image) }}' alt="Video Image"
                                                        class="img-fluid">
                                                    <div class="hovereffect">
                                                        <span class=""></span>
                                                    </div><!-- end hover -->
                                                </a>
                                            </div><!-- end media -->
                                            <div class="blog-meta">
                                                <h4><a href="{{ route('video', $video->slug) }}">{{ implode(' ', array_slice(explode(' ', $video->title), 0, 8)) . '...' }}</a></h4>
                                                <small><a href="{{ route('videos') }}">Videos</a></small>
                                                <small><a>{{ \Carbon\Carbon::parse($video->created_at)->format('d F, Y') }}</a></small>
                                            </div><!-- end meta -->
                                        </div><!-- end blog-box -->
                                    </div><!-- end col -->
                                @endforeach
                            </div><!-- end row -->
                        </div><!-- end custom-box -->
                    @endif

                    {{-- @include('tech.inc.comments') --}}
                </div><!-- end page-wrapper -->
            </div><!-- end col -->

            @include('tech.inc.homeSidebar')
            <!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
@endsection
