<div class="row">
    <div class="col-md-12">
        <div id="home-slider">
            @foreach ($postSlides as $post)
                @if ($post->image)
                    <div class="post feature-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img style="width: 1200px; height: 600px; object-fit:cover;" class="img-fluid"
                                    src='{{ "$pF/storage/uploads/posts/" . $post->image }}' alt="Image" />
                            </div>
                            <div class="catagory world"><a>{{ $post->cat[0]->category }}</a></div>
                        </div>
                        <div class="post-content">
                            <div class="entry-meta">
                                <ul class="list-inline">
                                    <li class="publish-date"><i class="fa fa-clock-o"></i><a>
                                            {{ $post->created_at->format('F d, Y') }} </a></li>
                                    <li class="views"><i class="fa fa-eye"></i><a>{{ $post->views }}</a></li>
                                    <li class="loves"><i class="fa fa-heart-o"></i><a>{{ $post->likes }}</a></li>
                                    <li class="comments"><i class="fa fa-comment-o"></i><a>{{ $post->com->count() }}</a>
                                    </li>
                                </ul>
                            </div>
                            <h2 class="entry-title">
                                <a href="{{ route('single-post', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</div>
