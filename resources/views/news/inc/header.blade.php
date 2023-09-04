<body class="box-width">
    <div id="main-wrapper" class="homepage-two">
        @if ($lang == 'en')
            <div class="topbar">
                <div class="container">
                    <div id="date-time"></div>
                    <div id="topbar-right">
                        <div id="weather" style="border: none;">
                            <a href="{{ route('advertise') }}"> <span class="change-text"> Advertise </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="{{ route('contact-us') }}"> <span class="change-text"> Contacts </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="mailto:{{ @$contact[0]->email }}"> <span class="change-text"> Email:
                                    {{ @$contact[0]->email }} </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="tel:{{ @$contact[0]->phone_number }}"> <span class="change-text"> Phone:
                                    {{ @$contact[0]->phone_number }} </span></a>
                        </div>
                        <div class="dropdown language-dropdown" id="change-language-button">
                            <a data-toggle="dropdown" href="#"><span class="change-text">EN</span> <i
                                    class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu language-change">
                                <li><a href="{{ route('change-lang', 'ne') }}">NE</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="navigation">
                <div class="container">
                    <div class="top-add">
                        <div class="navbar-header float-left">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img class="main-logo img-fluid" src='{{ "$pF/storage/site/" . $logo->logo }}'
                                    alt="logo">
                            </a>
                        </div>
                        <div class="navbar-right float-right">
                            @if ($navAds)
                                <a href="{{ $navAds->link }}" target="_blank">
                                    <img style="width: 730px; height: 90px; object-fit:cover;" class="img-fluid"
                                        src='{{ "$pF/storage/uploads/ads/" . $navAds->image }}' alt="Image" /></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="navbar navbar-expand-lg" role="banner">
                    <div id="menubar">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu"
                                aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"><i class="fa fa-align-justify"></i></span>
                            </button>
                            <a class="navbar-brand d-lg-none" href="{{ route('home') }}">
                                <img class="main-logo img-fluid" src='{{ "$pF/storage/site/" . $logo->logo }}'
                                    alt="logo">
                            </a>
                            <nav id="mainmenu" class="navbar-left collapse navbar-collapse">
                                <ul class="nav navbar-nav nav-add">
                                    <li class="sports">
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('news') }}">International News</a>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('entertainment') }}">Entertainment</a>
                                    </li>

                                    <li class="sports dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle"
                                            data-toggle="dropdown">Province</a>
                                        <ul class="dropdown-menu">
                                            @foreach ($provinces as $province)
                                                <li><a
                                                        href="{{ route('single-provinces', $province->province) }}">{{ $province->province }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('gallery') }}">Gallery</a>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('videos') }}">Videos</a>
                                    </li>
                                    <li class="sports dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle"
                                            data-toggle="dropdown">Football</a>
                                        <ul class="dropdown-menu">
                                            @foreach ($leagues as $leg)
                                                <li><a
                                                        href="{{ route('football', $leg->league) }}">{{ $leg->league }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('our-story') }}">Our Story</a>
                                    </li>
                                    <li class="sports">
                                        <a href="{{ route('contact-us') }}">Contact Us</a>
                                    </li>

                                    <!-- Header Search Form -->
                                    <div class="header-search-form header-search-form--right">
                                        <form action="{{ route('search') }}" method="post" id="mobile-search-form"
                                            class="search-form">
                                            @csrf
                                            <input name="keyword" type="text"
                                                class="form-control header-mobile__search-control"
                                                placeholder="Enter your search here...">
                                            <button type="submit" class="header-mobile__search-submit">
                                                <i style="color: #525B6C;" class="fa fa-search"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- Header Search Form / End -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="topbar">
                <div class="container">
                    <div id="date-time"></div>
                    <div id="topbar-right">
                        <div id="weather" style="border: none;">
                            <a href="{{ route('contact-us') }}"> <span class="change-text"> विज्ञापन गर्नुहोस्
                                </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="{{ route('contact-us') }}"> <span class="change-text"> सम्पर्कहरू </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="mailto:{{ @$contact[0]->email }}"> <span class="change-text"> इमेल:
                                    {{ @$contact[0]->email }} </span></a>
                        </div>
                        <div id="weather" style="border: none;">
                            <a href="tel:{{ @$contact[0]->phone_number }}"> <span class="change-text"> फोन नम्बर:
                                    {{ @$contact[0]->phone_number }} </span></a>
                        </div>
                        <div class="dropdown language-dropdown">
                            <a data-toggle="dropdown" href="#"><span class="change-text">NE</span> <i
                                    class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu language-change">
                                <li><a href="{{ route('change-lang', 'en') }}">EN</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="navigation">
                <div class="container">
                    <div class="top-add">
                        <div class="navbar-header float-left">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img class="main-logo img-fluid" src='{{ "$pF/storage/site/" . $logo->logo }}'
                                    alt="logo">
                            </a>
                        </div>
                        <div class="navbar-right float-right">
                            @if ($navAds)
                                <a href="{{ $navAds->link }}" target="_blank">
                                    <img style="width: 730px; height: 90px; object-fit:cover;" class="img-fluid"
                                        src='{{ "$pF/storage/uploads/ads/" . $navAds->image }}' alt="Image" /></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="navbar navbar-expand-lg" role="banner">
                    <div id="menubar">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"><i class="fa fa-align-justify"></i></span>
                            </button>
                            <a class="navbar-brand d-lg-none" href="{{ route('home') }}">
                                <img class="main-logo img-fluid" src='{{ "$pF/storage/site/" . $logo->logo }}'
                                    alt="logo">
                            </a>
                            <nav id="mainmenu" class="navbar-left collapse navbar-collapse">
                                <ul class="nav navbar-nav nav-add">
                                    <li class="sports mr-2"><a href="{{ route('home') }}">घर</a></li>
                                    <li class="sports mr-2"><a href="{{ route('news') }}">अन्तर्राष्ट्रिय समाचार</a>
                                    </li>
                                    <li class="sports mr-1">
                                        <a href="{{ route('entertainment') }}">मनोरञ्जन</a>
                                    </li>

                                    <li class="home mr-2 dropdown"><a href="javascript:void(0);"
                                            class="dropdown-toggle" data-toggle="dropdown">प्रान्तहरू</a>
                                        <ul class="dropdown-menu">
                                            @foreach ($provinces as $province)
                                                <li><a
                                                        href="{{ route('single-provinces', $province->province) }}">{{ $province->province }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    <li class="sports mr-2"><a href="{{ route('gallery') }}">ग्यालेरी</a></li>
                                    <li class="sports mr-2">
                                        <a href="{{ route('videos') }}">भिडियोहरू</a>
                                    </li>
                                    <li class="sports mr-1 dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle"
                                            data-toggle="dropdown">फुटबल</a>
                                        <ul class="dropdown-menu">
                                            @foreach ($leagues as $leg)
                                                <li><a
                                                        href="{{ route('football', $leg->league) }}">{{ $leg->league }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    <li class="sports mr-2"><a href="{{ route('our-story') }}">हाम्रो कथा</a></li>
                                    <li class="sports mr-2"><a href="{{ route('contact-us') }}">सम्पर्क गर्नुहोस</a>
                                    </li>
                                    <!-- Header Search Form -->
                                    <div class="header-search-form header-search-form--right ml-4">
                                        <form action="{{ route('search') }}" method="post" id="mobile-search-form"
                                            class="search-form">
                                            @csrf
                                            <input name="keyword" type="text"
                                                class="form-control header-mobile__search-control"
                                                placeholder="यहाँ आफ्नो खोज प्रविष्ट गर्नुहोस्...">
                                            <button type="submit" class="header-mobile__search-submit">
                                                <i style="color: #525B6C;" class="fa fa-search"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- Header Search Form / End -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        @endif
