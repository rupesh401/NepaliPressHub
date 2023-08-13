@extends('news.layouts.app')

@if ($lang == 'en') @section('title') Home @endsection @else @section('title') घर @endsection @endif
@section('content')
<div class="container">
    
    <div class="section">
        <div class="row">
            <div class="site-content col-lg-12">
                @include('news.inc.slides')
                @include('news.inc.breakingNews')
            </div>
        </div>
    </div>
    {{-- <div class="section add inner-add">
        <a href="#"><img class="img-fluid" src='{{ ("$pF/news/assets/images/post/add/add2.jpg") }}' alt="Image" /></a>
    </div> --}}
    <div class="section">
        
    </div>
    <div class="section">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                @include('news.inc.province')
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
                @include('news.inc.sidebar')
            </div>
        </div>    
    </div>
</div>

@endsection