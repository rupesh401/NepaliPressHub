<div class="col-md-12 col-lg-12 col-sm-12 col-xm-12 col-xl-12 sidebar-p">
    <div id="sitebar" class="theiaStickySidebar">
        <div class="widget follow-us">
            @if ($lang == 'en')
            <h1 class="section-title title">Follow Us</h1>
            @else
            <h1 class="section-title title">हामीलाई पछ्याउनुहोस्</h1>
            @endif
            <ul class="list-inline social-icons">
                @if (@$contact[0]->facebook)
                    <li><a href="{{ @$contact[0]->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                @endif
                @if (@$contact[0]->twitter)
                    <li><a href="{{ @$contact[0]->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                @endif
                @if (@$contact[0]->youtube)
                    <li><a href="{{ @$contact[0]->youtube }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                @endif
            </ul>
        </div>
        <div class="widget">
            @if ($sideAds != '')
                <div>
                    <a href="{{ $sideAds->link }}" target="_blank">
                    <img class="mb-2" style="width: 255px; height: 283px; object-fit:cover;" class="img-fluid"
                        src="{{ "$pF/storage/uploads/ads/" . $sideAds->image }}" alt="">
                    </a>
                </div>
            @endif
        </div>
        <div class="widget">
            @if ($lang == 'en')
                <h1 class="section-title title">Top Trending News</h1>
            @else
                <h1 class="section-title title">शीर्ष ट्रेन्डिङ समाचार</h1>
            @endif
            <ul class="post-list">
                @foreach ($trendPosts as $post)
                    <li>
                        <div class="post small-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-fluid" style="width: 70px; height: 70px; object-fit:cover;" src='{{ "$pF/storage/uploads/posts/".$post->image }}'
                                        alt="Image" />
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="video-catagory"><a>{{ $post->cat[0]->category }}</a></div>
                                <h2 class="entry-title">
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
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="widget">
            @if ($lang == 'en')
                <h1 class="section-title title">Latest News</h1>
            @else
                <h1 class="section-title title">शीर्ष ट्रेन्डिङ समाचार</h1>
            @endif
            <ul class="post-list">
                @foreach ($latestPosts as $post)
                    <li>
                        <div class="post small-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-fluid" style="width: 70px; height: 70px; object-fit:cover;" src='{{ "$pF/storage/uploads/posts/".$post->image }}'
                                        alt="Image" />
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="video-catagory"><a>{{ $post->cat[0]->category }}</a></div>
                                <h2 class="entry-title">
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
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
