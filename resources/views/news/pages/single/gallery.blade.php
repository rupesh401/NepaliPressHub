@extends('news.layouts.app')

@if ($lang == 'en') @section('title') {{ $singleAlbum->album_title }} @endsection @else @section('title') ग्यालेरी @endsection @endif

@section('content')
    <div class="container">
        <div class="page-breadcrumbs">
            <h1 class="section-title">{{ $singleAlbum->album_title }}</h1>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xm-12">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="section">
                                    <div class="row">
                                        @foreach ($singleAlbum->img as $img)
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                                <div class="post medium-post">
                                                    <div class="entry-header">
                                                        <div class="entry-thumbnail">
                                                                <img class="img-fluid"
                                                                style="width: 100%; height: 100%; object-fit:cover;"
                                                                src="{{ "$pF/storage/uploads/gallery/images/".$img->image }}"
                                                                alt="Image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xm-12">
                    @include('news.inc.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
