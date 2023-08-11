<div id="breaking-news">
    <span>Breaking News</span>
    <div class="breaking-news-scroll">
        <ul>
            @foreach ($postSlides as $post)
            <li><i class="fa fa-angle-double-right"></i>
                <a href="{{ route('single-post', $post->slug) }}" title>{{ $post->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>