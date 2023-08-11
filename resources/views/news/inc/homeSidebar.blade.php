<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
    <div class="sidebar">
        <div class="widget">
            @if($trendVideos->count() > 0)
                <h2 class="widget-title">Trend Videos</h2>
                <div class="trend-videos">
                    @foreach ($trendVideos as $video)
                        <div class="blog-box">
                            <div class="post-media">
                                <a href="{{ route('video', $video->slug) }}">
                                    <img style="height: 145px; object-fit: cover;" src='{{ ("$pF/storage/uploads/videos/".$video->image) }}' alt="{{ $video->title }}" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class="videohover"></span>
                                    </div><!-- end hover -->
                                </a>
                            </div><!-- end media -->
                            <div class="blog-meta">
                                <h4><a href="{{ route('video', $video->slug) }}">{{ substr($video->title, 0, 42) . '...' }}</a></h4>
                            </div><!-- end meta -->
                        </div><!-- end blog-box -->

                        <hr class="invis">
                    @endforeach
                    
                </div><!-- end videos -->
            @endif
        </div><!-- end widget -->

        <div class="widget">
            @if($popularPosts->count() > 0)
                <h2 class="widget-title">Popular Posts</h2>
                <div class="blog-list-widget">
                    <div class="list-group">
                        @foreach ($popularPosts as $post)    
                            <a href="{{ route('single-post', $post->slug) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="w-100 justify-content-between">
                                    <img src='{{ ("$pF/storage/uploads/posts/".$post->image) }}' alt="{{ $post->title }}" class="img-fluid float-left">
                                    <h5 class="mb-1">{{ substr($post->title, 0, 42) . '...' }}</h5>
                                    <small>{{ $post->created_at->format('d F, Y') }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div><!-- end blog-list -->
            @endif
        </div><!-- end widget -->

        <div class="widget">
            @if($recentReviews->count() > 0)
                <h2 class="widget-title">Recent Reviews</h2>
                <div class="blog-list-widget">
                    <div class="list-group">
                        @foreach ($recentReviews as $review)
                        <a href="{{ route('single-post', $review->slug) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="w-100 justify-content-between">
                                <img src='{{ ("$pF/storage/uploads/posts/".$review->image) }}' alt="Post Image" class="img-fluid float-left">
                                <h5 class="mb-1">{{ substr($review->title, 0, 42) . '...' }}</h5>
                                <span class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div><!-- end blog-list -->
            @endif
        </div><!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Follow Us</h2>

            <div class="row text-center">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="{{ @$contact[0]->facebook }}" class="social-button facebook-button" style="border-radius: 5px;">
                        <i class="fa fa-facebook"></i>
                        {{-- <p>27k</p> --}}
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="{{ @$contact[0]->twitter }}" class="social-button twitter-button" style="border-radius: 5px;">
                        <i class="fa fa-twitter"></i>
                        {{-- <p>98k</p> --}}
                    </a>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="{{ @$contact[0]->instagram }}" class="social-button google-button" style="border-radius: 5px;">
                        <i class="fa fa-instagram"></i>
                        {{-- <p>17k</p> --}}
                    </a>
                </div>

            </div>
        </div><!-- end widget -->
    </div><!-- end sidebar -->
</div>