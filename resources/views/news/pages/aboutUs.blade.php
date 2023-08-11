@extends('news.layouts.app')


@section('content')
<div class="container">
    <div class="page-breadcrumbs">
        @if ($lang == 'en')
        <h1 class="section-title title">About Us</h1>
        @else
        <h1 class="section-title title">हाम्रोबारे</h1>
        @endif
    </div>
    <div class="about-us welcome-section">
        <div class="row">
            <div class="col-lg-8 offset-2 content-section">
                <div class="about-us-content text-center">
                    {{-- <h2>Lorem ipsum dolor sit amet, consectetur adipisicing</h2> --}}
                    <p>
                        {!! $about[0]->about_us !!}
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
