<footer id="footer">
    <div class="footer-top">

    </div>
    <div class="bottom-widgets pt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xm-12">
                    <div class="widget">
                        <div class="navbar-header float-left">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img class="main-logo img-fluid" src='{{ "$pF/storage/site/" . $logo->logo }}'
                                    alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
                    <div class="widget">
                        @if ($lang == 'en')
                            <h1 style="font-size: 20px;" class="title">Follow Us</h1>
                        @else
                            <h1 style="font-size: 20px;" class="title">हमीलाई पछ्याउनुहोस</h1>
                        @endif
                        <ul class="list-inline social-icons">
                            @if (@$contact[0]->facebook)
                                <li><a href="{{ @$contact[0]->facebook }}" target="_blank"><i
                                            class="fa fa-facebook"></i></a></li>
                            @endif
                            @if (@$contact[0]->twitter)
                                <li><a href="{{ @$contact[0]->twitter }}" target="_blank"><i
                                            class="fa fa-twitter"></i></a></li>
                            @endif
                            @if (@$contact[0]->youtube)
                                <li><a href="{{ @$contact[0]->youtube }}" target="_blank"><i
                                            class="fa fa-youtube"></i></a></li>
                            @endif
                            @if (@$contact[0]->instagram)
                                <li><a href="{{ @$contact[0]->instagram }}" target="_blank"><i
                                            class="fa fa-instagram"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xm-12">
                    <div class="widget">
                        @if ($footerAds != '')
                            <div>
                                <a href="{{ @$footerAds->link }}" target="_blank">
                                    <img style="width: 680px; height: 90px; object-fit:cover;"
                                        src="{{ "$pF/storage/uploads/ads/" . @$footerAds->image }}" alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container text-center">
            <p><a style="color: black;" href="{{ route('home') }}"> News </a>&copy; {{ date('Y') }} </p>
        </div>
    </div>
</footer>
</div>

<script src='{{ "$pF/news/assets/js/jquery.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.magnific-popup.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.sticky-kit.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.subscribe-better.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/jquery.easy-ticker.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/popper.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/bootstrap.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/owl.carousel.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/moment.min.js" }}'></script>
<script src='{{ "$pF/news/assets/js/moment-with-locale.min.js" }}'></script>
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
            // Hide the reply form initially
            $("#reply-form").hide();

            // Handle click event on the "Replay" links
            $(".replay").click(function() {
                // Get the comment ID from the data attribute
                var commentId = $(this).data("comment-id");

                // Set the comment ID in the hidden input field of the form
                $("#comment_id").val(commentId);

                // Show the reply form and hide the comment form
                $("#reply-form").show();
                $("#comment-form").hide();

                // Set focus on the name input field in the reply form
                $("#reply-form input[name='name']").focus();
            });

            // Handle click event on the "Leave a Comment" link
            $(".leave-comment").click(function() {
                // Hide the reply form and show the comment form
                $("#reply-form").hide();
                $("#comment-form").show();
            });

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
@if (Route::currentRouteName() == 'preview-match')
    <script>
        $(document).ready(function() {
            // Hide Table and News content by default
            $("#league-table, #sports-news").hide();

            // Click event for Summary link
            $("#summary-link").click(function() {
                $("#teams-summary").show();
                $("#league-table, #sports-news").hide();

                $(this).addClass("active");
                $("#table-link, #news-link").removeClass("active");

                return false; // Prevent default link behavior
            });

            // Click event for Table link
            $("#table-link").click(function() {
                $("#league-table").show();
                $("#teams-summary, #sports-news").hide();

                $(this).addClass("active");
                $("#summary-link, #news-link").removeClass("active");

                return false; // Prevent default link behavior
            });

            // Click event for News link
            $("#news-link").click(function() {
                $("#sports-news").show();
                $("#teams-summary, #league-table").hide();

                $(this).addClass("active");
                $("#summary-link, #table-link").removeClass("active");

                return false; // Prevent default link behavior
            });
        });
    </script>
@endif

</html>
