@extends('news.layouts.app')

@section('title')  @if ($lang == 'en')  Advertise with us  @else हामीसँग विज्ञापन गर्नुहोस्  @endif @endsection 

@section('content')
<div class="container">
    <div class="page-breadcrumbs">
        @if ($lang == 'en')
        <h1 class="section-title title">Advertise with us</h1>
        @else
        <h1 class="section-title title">हामीसँग विज्ञापन गर्नुहोस्</h1>
        @endif
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xm-12">
           
            <div class="contact-us theiaStickySidebar">
                <div class="message-box" id="comment-form">
                    {!! $content->content !!}
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xm-12 offset-1">
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
            <div class="contact-us theiaStickySidebar">
                <div class="message-box">
                    @if ($lang == 'en')
                    <form action="{{ route('post-message') }}" id="comment-form" name="comment-form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        required="required"
                                        placeholder="Your full name..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required="required"
                                        placeholder="Your email..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input
                                        type="text"
                                        name="subject"
                                        class="form-control"
                                        placeholder="Your subject..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Your Message</label>
                                    <textarea
                                        name="message"
                                        id="comment"
                                        required="required"
                                        class="form-control"
                                        rows="5"
                                        placeholder="Enter your message here..."
                                    ></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <form action="{{ route('post-message') }}" id="comment-form" name="comment-form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>नाम</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        required="required"
                                        placeholder="तिम्रो पुरा नाम..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>इमेल</label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required="required"
                                        placeholder="तिम्रो इमेल..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>विषय</label>
                                    <input
                                        type="text"
                                        name="subject"
                                        class="form-control"
                                        placeholder="आफ्नो विषय..."
                                    />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>तिम्रो सन्देश</label>
                                    <textarea
                                        name="message"
                                        id="comment"
                                        required="required"
                                        class="form-control"
                                        rows="5"
                                        placeholder="यहाँ आफ्नो सन्देश प्रविष्ट गर्नुहोस्..."
                                    ></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        पठाउनुहोस्
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection