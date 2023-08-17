@extends('news.layouts.app')

@if ($lang == 'en') @section('title') Our Story @endsection @else @section('title') हाम्रो कथा @endsection @endif

@section('content')
<div class="container">
    <div class="page-breadcrumbs">
        @if ($lang == 'en')
        <h1 class="section-title title">Our Story</h1>
        @else
        <h1 class="section-title title">हाम्रो कथा</h1>
        @endif
    </div>
    <div class="about-us welcome-section">
        <div class="row">
            <div class="col-lg-12 content-section">
                <div class="about-us-content">
                        {!! $about[0]->about_us !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
