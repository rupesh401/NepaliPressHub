<body class="box-width">
    <div id="main-wrapper" class="homepage-two">
        @if ($lang == 'en')
        <div class="topbar">
            <div class="container">
                <div id="date-time"></div>
                <div id="topbar-right">
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="{{ route('contact-us') }}"> <span class="change-text"> Advertise </span></a>  
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="{{ route('contact-us') }}"> <span class="change-text"> Contacts </span></a>  
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="mailto:{{ @$contact[0]->email }}"> <span class="change-text"> Email: {{ @$contact[0]->email }} </span></a>
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="tel:{{ @$contact[0]->phone_number }}"> <span class="change-text"> Phone:
                            {{ @$contact[0]->phone_number }} </span></a>
                    </div>
                    <div class="dropdown language-dropdown">
                        <a data-toggle="dropdown" href="#"><span class="change-text">EN</span> <i
                                class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu language-change">
                            <li><a href="{{ route('change-lang', 'np') }}">NP</a></li>
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
                            <img class="main-logo img-fluid" src='{{ ("$pF/storage/site/".$logo->logo) }}' alt="logo">
                        </a>
                    </div>
                    <div class="navbar-right float-right">
                        <a href="#">
                            <img style="width: 730px; height: 90px; object-fit:cover;" class="img-fluid" src='{{ ("$pF/storage/uploads/ads/".$navAds->image) }}'
                                alt="Image" /></a>
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
                            <img class="main-logo img-fluid" src='{{ ("$pF/storage/site/".$logo->logo) }}' alt="logo">
                        </a>
                        <nav id="mainmenu" class="navbar-left collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="sports"><a href="{{ route('home') }}">Home</a></li>
                                <li class="sports"><a href="{{ route('news') }}">International News</a></li>

                                <li class="home dropdown"><a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown">Province</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($provinces as $province )
                                            <li><a href="{{ route('single-provinces', $province->province) }}">{{ $province->province }}</a></li>
                                        @endforeach
                                       
                                    </ul>
                                </li>
                                <li class="sports"><a href="{{ route('gallery') }}">Gallery</a></li>
                                <li class="sports"><a href="{{ route('about-us') }}">About Us</a></li>
                                <li class="sports"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                {{-- <li class="sports mt-3">
                                    <input class="form-control" type="text" name="keyword" >
                                </li> --}}
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
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="{{ route('contact-us') }}"> <span class="change-text"> विज्ञापन गर्नुहोस् </span></a>  
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="{{ route('contact-us') }}"> <span class="change-text"> सम्पर्कहरू </span></a>  
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="mailto:{{ @$contact[0]->email }}"> <span class="change-text"> इमेल: {{ @$contact[0]->email }} </span></a>
                    </div>
                    <div id="weather" style="border: none;" class="m-0 p-1">
                        <a href="tel:{{ @$contact[0]->phone_number }}"> <span class="change-text"> फोन नम्बर:
                            {{ @$contact[0]->phone_number }} </span></a>
                    </div>
                    <div class="dropdown language-dropdown">
                        <a data-toggle="dropdown" href="#"><span class="change-text">NP</span> <i
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
                            <img class="main-logo img-fluid" src='{{ ("$pF/storage/site/".$logo->logo) }}' alt="logo">
                        </a>
                    </div>
                    <div class="navbar-right float-right">
                        <a href="#"><img class="img-fluid" src='{{ ("$pF/news/assets/images/post/google-add.jpg") }}'
                                alt="Image" /></a>
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
                            <img class="main-logo img-fluid" src='{{ ("$pF/storage/site/".$logo->logo) }}' alt="logo">
                        </a>
                        <nav id="mainmenu" class="navbar-left collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="sports"><a href="{{ route('home') }}">घर</a></li>
                                <li class="sports"><a href="{{ route('news') }}">अन्तर्राष्ट्रिय समाचार</a></li>

                                <li class="home dropdown"><a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown">प्रान्तहरू</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($provinces as $province )
                                            <li><a href="{{ route('single-provinces', $province->province) }}">{{ $province->province }}</a></li>
                                        @endforeach
                                       
                                    </ul>
                                </li>
                                <li class="sports"><a href="{{ route('gallery') }}">ग्यालेरी</a></li>
                                <li class="sports"><a href="{{ route('about-us') }}">हाम्रोबारे</a></li>
                                <li class="sports"><a href="{{ route('contact-us') }}">सम्पर्क गर्नुहोस</a></li>
                                {{-- <li class="sports mt-3">
                                    <input class="form-control" type="text" name="keyword" >
                                </li> --}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @endif