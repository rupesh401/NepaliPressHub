@extends('tech.layouts.app')

@section('title') Recent Posts @endsection
@section('content')
<div class="page-title lb single-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h2><i class="fa fa-microchip bg-orange"></i> Recent Posts
                     {{-- <small class="hidden-xs-down hidden-sm-down">Nulla felis eros, varius sit amet volutpat non. </small> --}}
                    </h2>
            </div><!-- end col -->
            <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Recent Posts</li>
                </ol>
            </div><!-- end col -->                    
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end page-title -->

<section class="section">
    <div class="container">
        <div class="row">
            @include('tech.inc.homeSidebar')
            <!-- end col -->
            
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="page-wrapper">
                    <div class="blog-grid-system">
                        <div class="row">
                            @if($posts->count() > 0)
                            @foreach ($posts as $post)
                            <div class="col-md-6">
                                <div class="blog-box">
                                    <div class="post-media">
                                        <a href="{{ route('single-post', $post->slug) }}">
                                            <img style="width: 398px; height: 248px; object-fit: cover;" src='{{ ("$pF/storage/uploads/posts/".$post->image) }}' alt="Post Image" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div><!-- end hover -->
                                        </a>
                                    </div><!-- end media -->
                                    <div class="blog-meta big-meta">
                                        <span class="color-orange"><a href="{{ route('category',$post->cat[0]->category) }}">{{ $post->cat[0]->category }}</a></span>
                                        <h4><a href="{{ route('single-post', $post->slug) }}">{{ $post->title }}</a></h4>
                                        <p>
                                            @php
                                                $strippedContent = strip_tags($post->content);
                                                $matches = [];

                                                // Check for first paragraph
                                                if (preg_match('/<p>(.*?)<\/p>/', $post->content, $matches)) {
                                                    // print_r($matches[1]);
                                                echo substr($matches[1], 0, 120) . '...';
                                                }
                                                // If no paragraph found, check for heading tags
                                                else if (preg_match('/<h[1-6]>(.*?)<\/h[1-6]>/', $post->content, $matches)) {
                                                    print_r($matches[1]);
                                                echo substr($matches[1], 0, 120) . '...';
                                                }
                                                // If no paragraph or heading tags found, display a default message
                                                else {
                                                echo '';
                                                }
                                            @endphp
                                        </p>
                                        <small><a href="{{ route('single-post', $post->slug) }}">{{ $post->created_at->format('d F, Y') }}</a></small>
                                        {{-- <small><a href="tech-author.html">by Jack</a></small> --}}
                                        <small><a href="{{ route('single-post', $post->slug) }}"><i class="fa fa-eye"></i> {{ $post->views }}</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->
                            </div><!-- end col -->
                            @endforeach
                            @else
                            <div class="col-md-12 text-center">
                                <img style="width: 400px; object-fit:cover;" src='{{ ("$pF/no-post.png") }}' alt="No post available">
                                <h1 class="text-center">No content available for now</h1>
                            </div>
                            @endif
                        </div><!-- end row -->
                    </div><!-- end blog-grid-system -->
                </div><!-- end page-wrapper -->

                <hr class="invis3">

                @if ($posts->lastPage() > 1)
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                @if ($posts->currentPage() > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $posts->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif
                        
                                @foreach ($posts->getUrlRange(max($posts->currentPage() - 1, 1), min($posts->currentPage() + 1, $posts->lastPage())) as $page => $url)
                                    <li class="page-item">
                                        <a class="page-link {{ $posts->currentPage() == $page ? ' currentli' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                @if ($posts->currentPage() < $posts->lastPage())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $posts->nextPageUrl() }}">Next</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div><!-- end col -->
                </div><!-- end row -->
                @endif
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
@endsection