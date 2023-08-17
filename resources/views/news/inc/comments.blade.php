<div class="comments-wrapper">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('failed'))
        <div class="alert alert-error">
            {{ session('failed') }}
        </div>
    @endif
    <h1 class="section-title title">
        @if ($singlePost->com->count() != 0)
             Comments ({{ $singlePost->com->count() }})
         @elseif ($singlePost->com->count() == 1)
             Comment ({{ $singlePost->com->count() }})
         @else
             Be the first to comment
         @endif
    </h1>
    <ul class="media-list">
        @foreach ($singlePost->com as $comment)
            <li class="media">
                <div class="media-left">
                    <a href="#"
                        ><img
                            class="media-object"
                            src="{{ ("$pF/profile.png") }}"
                            alt="Image"
                    /></a>
                </div>
                <div class="media-body">
                    <h2><a>{{ $comment->name }}</a></h2>
                    <h3 class="date"><a>{{ $comment->created_at->diffForHumans() }}</a></h3>
                    <p>
                        {{ $comment->comment }}
                    </p>
                    <a onclick="replayComment({{ $comment->id }})" class="replay">Replay</a>
                </div>
            </li>
            @foreach($comment->reply as $reply)
            <li class="media media-child">
                <div class="media-left">
                    <a href="#"
                        ><img class="media-object" src="images/others/author3.png" alt="Image"
                    /></a>
                </div>
                <div class="media-body">
                    <h2><a href="#">Axel Bouaziz</a></h2>
                    <h3 class="date"><a href="#">15 December 2018</a></h3>
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                        doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                        inventore.
                    </p>
                    <a class="replay" href="#">Replay</a>
                </div>
            </li>
            @endforeach
        @endforeach
        
    </ul>
    <div class="comments-box" id="comment-form">
        <h1 class="section-title title">Leave a Comment</h1>
        <form action="{{ route('post-comment') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required="required"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required="required"
                        />
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Your Text</label>
                        <textarea
                            name="comment"
                            id="comment"
                            required="required"
                            class="form-control"
                            rows="5"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        @if (config('services.recaptcha.key'))
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}">
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="post_id" value="{{ $singlePost->id }}" class="form-control" />
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="comments-box" id="reply-form">
        <h1 class="section-title title">Replay a Comment</h1>
        <form action="{{ route('post-comment') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-10 offset-1">
                    <div class="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required="required"
                        />
                    </div>
                </div>
                <div class="col-sm-10 offset-1">
                    <div class="form-group">
                        <label>Your Text</label>
                        <textarea
                            name="comment"
                            id="comment"
                            required="required"
                            class="form-control"
                            rows="5"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        @if (config('services.recaptcha.key'))
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}">
                            </div>
                        @endif
                    </div>
                    <input type="text" name="comment_id" id="comment_id" class="form-control" />
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            Reply
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>