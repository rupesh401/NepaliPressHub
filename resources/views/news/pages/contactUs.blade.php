@extends('news.layouts.app')

@section('title')  @if ($lang == 'en')  Contact us  @else हामीलाई सम्पर्क गर्नुहोस  @endif @endsection 

@section('content')
<div class="container">
    <div class="page-breadcrumbs">
        @if ($lang == 'en')
        <h1 class="section-title title">Contact Us</h1>
        @else
        <h1 class="section-title title">हामीलाई सम्पर्क गर्नुहोस</h1>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-9 offset-2 tr-sticky">
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