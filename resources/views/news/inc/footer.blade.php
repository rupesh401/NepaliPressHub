<footer id="footer">
    <div class="footer-top">

    </div>
    <div class="bottom-widgets">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xm-4">
                    <div class="widget">
                        @if ($lang == 'en')
                            <h2>Category</h2>
                        @else
                            <h2>श्रेणी</h2>
                        @endif
                        <ul>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Politics</a></li>
                            <li><a href="#">Sports</a></li>
                            <li><a href="#">World</a></li>
                            <li><a href="#">Technology</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Environment</a></li>
                            <li><a href="#">Health</a></li>
                            <li><a href="#">Entertainment</a></li>
                            <li><a href="#">Lifestyle</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xm-4">
                    <div class="widget">
                        <h2>Provinces</h2>
                        @php
                            $provincesChunks = $provinces->chunk(4);
                        @endphp

                        @foreach ($provincesChunks as $chunk)
                            <ul>
                                @foreach ($chunk as $province)
                                    <li><a
                                            href="{{ route('single-provinces', $province->province) }}">{{ $province->province }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xm-4">
                    <div class="widget">
                        @if ($sideAds != '')
                            <div>
                                <img style="width: 300px; height: 250px; object-fit:cover;"
                                    src="{{ "$pF/storage/uploads/ads/" . $sideAds->image }}" alt="">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container text-center">
            <p><a href="{{ route('home') }}"> News </a>&copy; {{ date('Y') }} </p>
        </div>
    </div>
</footer>
</div>
{{-- <div class="subscribe-me text-center">
<h1>Don’t Miss The Hottest News</h1>
<h2>Subscribe our Newsletter</h2>
<a href="#close" class="sb-close-btn"><img class="img-fluid" src='{{ ("$pF/news/assets/images/others/close-button.png") }}'
        alt="Image" /></a>
<form action="#" method="post" id="popup-subscribe-form" name="subscribe-form">
    <div class="input-group">
        <span class="input-group-addon"><img src='{{ ("$pF/news/assets/images/others/icon-message.png") }}' alt="Image" /></span>
        <input type="text" placeholder="Enter your email" name="email">
        <button type="submit" name="subscribe">Go</button>
    </div>
</form>
</div> --}}

<script src='{{ "$pF/news/assets/js/jquery.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.magnific-popup.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.sticky-kit.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.subscribe-better.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.easy-ticker.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/popper.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/bootstrap.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/owl.carousel.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/moment.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/theia-sticky-sidebar.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/main.js" }}'></script>
<script src='{{ "$pF/news/assets/js/switcher.js" }}'></script>

@if (Route::currentRouteName() == 'single-post')
    <script>
        // Set the CSRF token for every AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(".meta-like").on("click", function() {
                var likesCount = parseInt($(this).siblings("a").text()); // Get the current likes count
                var updatedLikesCount = likesCount + 1; // Increment the likes count

                // Update the display
                $(this).siblings("a").text(updatedLikesCount);

                // Send the updated likes count to the server via AJAX
                $.ajax({
                    url: "{{ route('update-likes', ['post' => $singlePost->id]) }}",
                    type: "PUT",
                    data: {
                        likes: updatedLikesCount
                    },
                    success: function(response) {
                        // Success handling (optional)
                    },
                    error: function(error) {
                        // Error handling (optional)
                    }
                });
            });
        });
    </script>
@endif

</html>
