@extends('tech.layouts.app')

@section('desc') Tech Viewed Videos @endsection
@section('url')videos @endsection
@section('title') Videos @endsection
@section('content')
<div class="page-title lb single-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h2><i class="fa fa-play bg-orange"></i> Videos 
                    {{-- <small class="hidden-xs-down hidden-sm-down">Nulla felis eros, varius sit amet volutpat non. </small> --}}
                </h2>
            </div><!-- end col -->
            <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Videos</li>
                </ol>
            </div><!-- end col -->                    
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end page-title -->

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="page-wrapper">
                    <div class="blog-custom-build">
                        @foreach ($videos as $video)
                        <div class="blog-box">
                            <div class="post-media">
                                <a href="{{ route('video', $video->slug) }}">
                                    <img style="height: 470px; object-fit: cover;" src='{{ ("$pF/storage/uploads/videos/".$video->image) }}' alt="Video Image" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class="videohover"></span>
                                    </div>
                                    <!-- end hover -->
                                </a>
                            </div>
                            <!-- end media -->
                            <div class="blog-meta big-meta text-center">
                                <div class="post-sharing">
                                    <ul class="list-inline">
                                        <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                        <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                        <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-instagram"></i><span class="down-mobile">Share on Instagram</span></a></li>
                                    </ul>
                                </div><!-- end post-sharing -->
                                <h4><a href="{{ route('video', $video->slug) }}">{{ $video->title }}</a></h4>
                                {{-- <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p> --}}
                                <small><a href="tech-category.html">Videos</a></small>
                                <small><a href="{{ route('video', $video->slug) }}">{{ $video->created_at->format('d F, Y') }}</a></small>
                                {{-- <small><a href="tech-author.html">by Amanda</a></small> --}}
                                <small><a><i class="fa fa-eye"></i> {{ $video->views }}</a></small>
                            </div><!-- end meta -->
                        </div><!-- end blog-box -->

                        <hr class="invis">
                        @endforeach
                       
                    </div><!-- end blog-custom-build -->
                </div><!-- end page-wrapper -->

                <hr class="invis">

                @if ($videos->lastPage() > 1)
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                @if ($videos->currentPage() > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $videos->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif
                        
                                @foreach ($videos->getUrlRange(max($videos->currentPage() - 1, 1), min($videos->currentPage() + 1, $videos->lastPage())) as $page => $url)
                                    <li class="page-item">
                                        <a class="page-link {{ $videos->currentPage() == $page ? ' currentli' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                @if ($videos->currentPage() < $videos->lastPage())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $videos->nextPageUrl() }}">Next</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div><!-- end col -->
                </div><!-- end row -->
                @endif
            </div><!-- end col -->

            @include('tech.inc.homeSidebar')
            <!-- end col -->
        </div>
    </div><!-- end container -->
</section>
@endsection