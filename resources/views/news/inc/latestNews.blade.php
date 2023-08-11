<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
    <div class="page-wrapper">
        <div class="blog-top clearfix">
            <h4 class="pull-left">Recent News <a><i class="fa fa-rss"></i></a></h4>
        </div><!-- end blog-top -->

        <div class="blog-list clearfix">
            @foreach ($posts as $post)
                <div class="blog-box row">
                    <div class="col-md-4">
                        <div class="post-media">
                            <a href="{{ route('single-post', $post->slug) }}">
                                <img style="height: 160px; object-fit: cover;" src='{{ ("$pF/storage/uploads/posts/".$post->image) }}' alt="Post Image" class="img-fluid">
                                <div class="hovereffect"></div>
                            </a>
                        </div><!-- end media -->
                    </div><!-- end col -->

                    <div class="blog-meta big-meta col-md-8">
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
                        <small class="firstsmall"><a class="bg-orange" href="{{ route('category', $post->cat[0]->category) }}"
                                title="">{{ $post->cat[0]->category }}</a></small>
                        <small><a>{{ $post->created_at->format('d F, Y') }}</a></small>
                        <small><a><i class="fa fa-comment"> </i> {{ $post->com->count() }}</a></small>
                        <small><a><i class="fa fa-eye"></i> {{ $post->views }}</a></small>
                    </div><!-- end meta -->
                </div><!-- end blog-box -->

                <hr class="invis">
            @endforeach
        </div><!-- end blog-list -->
    </div><!-- end page-wrapper -->

    <hr class="invis">

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
</div>
