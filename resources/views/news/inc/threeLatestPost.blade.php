<section class="section first-section" style="top: 10px">
    <div class="container-fluid">
        <div class="masonry-blog clearfix">
            <div class="first-slot">
                <div class="masonry-box post-media">
                     <img style="height: 352px; object-fit: cover;" src='{{ ("$pF/storage/uploads/posts/".$firstPost->image) }}' alt="Post Image" class="img-fluid">
                     <div class="shadoweffect">
                        <div class="shadow-desc">
                            <div class="blog-meta">
                                <span class="bg-orange"><a href="{{ route('category', $firstPost->cat[0]->category) }}">{{ $firstPost->cat[0]->category }}</a></span>
                                <h1><a href="{{ route('single-post', $firstPost->slug) }}">{{ $firstPost->title }}</a></h1>
                                <small><a>{{ $firstPost->created_at->format('d F, Y') }}</a></small>
                                {{-- <small><a href="tech-author.html">by Amanda</a></small> --}}
                            </div><!-- end meta -->
                        </div><!-- end shadow-desc -->
                    </div><!-- end shadow -->
                </div><!-- end post-media -->
            </div><!-- end first-side -->

            @foreach ($secondPosts as $post)
                <div class="second-slot">
                    <div class="masonry-box post-media">
                        <img style="height: 352px; object-fit: cover;" src='{{ ("$pF/storage/uploads/posts/".$post->image) }}' alt="Post Image" class="img-fluid">
                        <div class="shadoweffect">
                            <div class="shadow-desc">
                                <div class="blog-meta">
                                    <span class="bg-orange"><a href="{{ route('category', $post->cat[0]->category) }}">{{ $post->cat[0]->category }}</a></span>
                                    <h4><a href="{{ route('single-post', $post->slug) }}">{{ $post->title }}</a></h4>
                                    <small><a>{{ $post->created_at->format('d F, Y') }}</a></small>
                                    {{-- <small><a href="tech-author.html">by Jessica</a></small> --}}
                                </div><!-- end meta -->
                            </div><!-- end shadow-desc -->
                        </div><!-- end shadow -->
                    </div><!-- end post-media -->
                </div><!-- end second-side -->
            @endforeach
        </div><!-- end masonry -->
    </div>
</section>