<div>
    <div id="site-content">
        <div class="section technology-news">
            @if ($lang == 'en')
                <h1 class="section-title">International</h1>
                <div class="world-nav cat-menu">
                    <ul class="list-inline">
                        <li class="active"><a href="{{ route('news') }}">See All</a></li>
                    </ul>
                </div>
            @else
                <h1 class="section-title">अन्तर्राष्ट्रिय</h1>
                <div class="world-nav cat-menu">
                    <ul class="list-inline">
                        <li class="active"><a href="{{ route('news') }}">सबै हेर्नुहोस्</a></li>
                    </ul>
                </div>
            @endif
            <div class="row">
                @foreach ($sixIntNews as $key => $news)
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xm-12">
                        <div class="post small-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img style="width: 255px; height: 170px" class="img-fluid" src='{{ "$pF/storage/uploads/posts/" . $news->image }}'
                                        alt="Image" />
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="entry-meta">
                                    <ul class="list-inline">
                                        <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>
                                                {{ @$news->created_at->format('F d, Y') }}</a></li>
                                    </ul>
                                </div>
                                <h2 class="entry-title">
                                    <a href="{{ route('single-post', $news->slug) }}">
                                        @php
                                            $strippedContent = strip_tags($news->title);
                                            $truncatedContent = mb_substr($strippedContent, 0, 35, 'UTF-8');
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
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
<div class="section add inner-add">
    <a href="{{ $homeBtn->link }}" target="_blank">
        <img style="width: 825px; height:100px; object-fit:cover;" class="img-fluid"
            src="{{ "$pF/storage/uploads/ads/" . $homeBtn->image }}" alt="Image" />
    </a>
</div>

@foreach ($provinces as $key => $province)
    @if ($province->post->count() != 0)
        @if ($province->post->count() >= 3)
            <div>
                <div id="site-content">
                    <div class="section technology-news">
                        <h1 class="section-title">{{ @$province->province }}</h1>
                        @if ($lang == 'en')
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">See All</a></li>
                                </ul>
                            </div>
                        @else
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">सबै
                                            हेर्नुहोस्</a></li>
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xm-12">
                                <div class="post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img style="height: 360px; width:540px; object-fit: cover;"
                                                class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[0]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[0]->created_at->format('F d, Y') }} </a>
                                                </li>
                                                <li class="views"><a><i
                                                            class="fa fa-eye"></i>{{ $province->post[0]->views }}</a>
                                                </li>
                                                <li class="loves"><a><i
                                                            class="fa fa-heart-o"></i>{{ $province->post[0]->likes }}</a>
                                                </li>
                                                <li class="comments"><i
                                                        class="fa fa-comment-o"></i><a>{{ $province->post[0]->com->count() }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title m-1">
                                            <a href="{{ route('single-post', $province->post[0]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                                        <div class="entry-content m-0 p-0">
                                            <p>
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->content);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 120, 'UTF-8');
                                                    $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                    
                                                    // Display the truncated content
                                                    echo $truncatedContent;
                                                    
                                                    // If there are remaining characters, show an ellipsis
                                                    if ($remainingCharacters > 0) {
                                                        echo '...';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xm-12">
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[1]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[1]->created_at->format('F d, Y') }}</a></li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="{{ route('single-post', $province->post[1]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[1]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                                <div class="post small-post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[2]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[2]->created_at->format('F d, Y') }} </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="{{ route('single-post', $province->post[2]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[2]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                            </div>
                        </div>
                    </div>
                </div>
                @if ($homeBtn && $key < count($provinces) - 1)
                    <div class="section add inner-add">
                        <a href="{{ $homeBtn->link }}" target="_blank">
                            <img style="width: 825px; height:100px; object-fit:cover;" class="img-fluid"
                                src="{{ "$pF/storage/uploads/ads/" . $homeBtn->image }}" alt="Image" />
                        </a>
                    </div>
                @endif
            </div>
        @elseif ($province->post->count() == 2)
            <div>
                <div id="site-content">
                    <div class="section technology-news">
                        <h1 class="section-title">{{ $province->province }}</h1>
                        @if ($lang == 'en')
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">See All</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">सबै
                                            हेर्नुहोस्</a></li>
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img style="height: 360px; width:540px; object-fit: cover;"
                                                class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[0]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[0]->created_at->format('F d, Y') }} </a>
                                                </li>
                                                <li class="views"><a><i
                                                            class="fa fa-eye"></i>{{ $province->post[0]->views }}</a>
                                                </li>
                                                <li class="loves"><a><i
                                                            class="fa fa-heart-o"></i>{{ $province->post[0]->likes }}</a>
                                                </li>
                                                <li class="comments"><i
                                                        class="fa fa-comment-o"></i><a>{{ $province->post[0]->com->count() }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title m-0">
                                            <a href="{{ route('single-post', $province->post[0]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                                        <div class="entry-content m-0 p-0">
                                            <p>
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->content);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 120, 'UTF-8');
                                                    $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                    
                                                    // Display the truncated content
                                                    echo $truncatedContent;
                                                    
                                                    // If there are remaining characters, show an ellipsis
                                                    if ($remainingCharacters > 0) {
                                                        echo '...';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img style="height: 360px; width:540px; object-fit: cover;"
                                                class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[1]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[1]->created_at->format('F d, Y') }} </a>
                                                </li>
                                                <li class="views"><a><i
                                                            class="fa fa-eye"></i>{{ $province->post[1]->views }}</a>
                                                </li>
                                                <li class="loves"><a><i
                                                            class="fa fa-heart-o"></i>{{ $province->post[1]->likes }}</a>
                                                </li>
                                                <li class="comments"><i
                                                        class="fa fa-comment-o"></i><a>{{ $province->post[1]->com->count() }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title m-0">
                                            <a href="{{ route('single-post', $province->post[1]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[1]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                                        <div class="entry-content m-0 p-0">
                                            <p>
                                                @php
                                                    $strippedContent = strip_tags($province->post[1]->content);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 150, 'UTF-8');
                                                    $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                    
                                                    // Display the truncated content
                                                    echo $truncatedContent;
                                                    
                                                    // If there are remaining characters, show an ellipsis
                                                    if ($remainingCharacters > 0) {
                                                        echo '...';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($homeBtn && $key < count($provinces) - 1)
                    <div class="section add inner-add">
                        <a href="{{ $homeBtn->link }}" target="_blank">
                            <img style="width: 825px; height:100px; object-fit:cover;" class="img-fluid"
                                src="{{ "$pF/storage/uploads/ads/" . $homeBtn->image }}" alt="Image" />
                        </a>
                    </div>
                @endif
            </div>
        @elseif ($province->post->count() == 1)
            <div>
                <div id="site-content m-0 p-0">
                    <div class="section technology-news">
                        <h1 class="section-title">{{ $province->province }}</h1>
                        @if ($lang == 'en')
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">See All</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="world-nav cat-menu">
                                <ul class="list-inline">
                                    <li class="active"><a
                                            href="{{ route('single-provinces', $province->province) }}">सबै
                                            हेर्नुहोस्</a></li>
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                <div class="post">
                                    <div class="entry-header">
                                        <div class="entry-thumbnail">
                                            <img style="width:100%; object-fit: cover;" class="img-fluid"
                                                src='{{ "$pF/storage/uploads/posts/" . $province->post[0]->image }}'
                                                alt="Image" />
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-meta">
                                            <ul class="list-inline">
                                                <li class="publish-date"><a><i class="fa fa-clock-o"></i>
                                                        {{ $province->post[0]->created_at->format('F d, Y') }} </a>
                                                </li>
                                                <li class="views"><a><i
                                                            class="fa fa-eye"></i>{{ $province->post[0]->views }}</a>
                                                </li>
                                                <li class="loves"><a><i
                                                            class="fa fa-heart-o"></i>{{ $province->post[0]->likes }}</a>
                                                </li>
                                                <li class="comments"><i
                                                        class="fa fa-comment-o"></i><a>{{ $province->post[0]->com->count() }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h2 class="entry-title m-0">
                                            <a href="{{ route('single-post', $province->post[0]->slug) }}">
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->title);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 55, 'UTF-8');
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
                                        <div class="entry-content m-0 p-0">
                                            <p>
                                                @php
                                                    $strippedContent = strip_tags($province->post[0]->content);
                                                    $truncatedContent = mb_substr($strippedContent, 0, 120, 'UTF-8');
                                                    $remainingCharacters = mb_strlen($strippedContent, 'UTF-8') - mb_strlen($truncatedContent, 'UTF-8');
                                                    
                                                    // Display the truncated content
                                                    echo $truncatedContent;
                                                    
                                                    // If there are remaining characters, show an ellipsis
                                                    if ($remainingCharacters > 0) {
                                                        echo '...';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($homeBtn && $key < count($provinces) - 1)
                    <div class="section add inner-add">
                        <a href="{{ $homeBtn->link }}" target="_blank">
                            <img style="width: 825px; height:100px; object-fit:cover;" class="img-fluid"
                                src="{{ "$pF/storage/uploads/ads/" . $homeBtn->image }}" alt="Image" />
                        </a>
                    </div>
                @endif
            </div>
        @endif
    @endif
@endforeach
