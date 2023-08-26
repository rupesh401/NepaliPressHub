<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\About;
use App\Ads;
use App\Advertise;
use App\League;
use App\BreakingNews;
use App\Video;
use App\Comment;
use App\ComReply;
use App\Contact;
use App\Email;
use App\Gallery;
use App\Image;
use App\Mail\ContactMail;
use App\MySite;
use App\PostComment;
use App\Province;
use App\Reply;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MainController extends Controller
{

    public function search(Request $request)
    {

        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::where('title', 'like', '%' . $request->keyword . '%')->orWhere('content', 'like', '%' . $request->keyword . '%')->with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'DESC')->paginate(15);

        $postSlides = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->where('flash_news', 1)->orderBy('created_at', 'DESC')->take(4)->get();

        $postFeatured = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->where('flash_news', 1)->orderBy('created_at', 'DESC')->skip(4)->take(3)->get();

        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->latest('created_at')->take(1)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $breakingNews = BreakingNews::where('lang', $lang)->orderBy('created_at', 'desc')->take(6)->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.single.search', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'about' => $about,
            'onePost' => $onePost,
            'contact' => $contact,
            'provinces' => $provinces,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'postSlides' => $postSlides,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'breakingNews' => $breakingNews,
            'postFeatured' => $postFeatured,
            'keyword' => $request->keyword,
        ]);
    }

    public function updateLikes(Request $request, Post $post)
    {
        $likes = $request->input('likes');
        // Update the likes count in the database
        $post->update(['likes' => $likes]);

        // You can optionally return a response if needed
        return response()->json(['message' => 'Likes updated successfully']);
    }

    /**
     * This function post a message from contact form view
     * @package sportsNews
     * @return postMessage view
     */
    public function postMessage(Request $request)
    {
        $postEmail = new Email();
        $postEmail->name = $request->name;
        $postEmail->email = $request->email;
        $postEmail->subject = $request->subject;
        $postEmail->message = $request->message;
        $postEmail->status = 'unread';


        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to('ferdnandmwitumba@gmail.com')->send(new ContactMail($data));

        if ($postEmail->save()) {
            if ($request->cookie('language') == 'en') {
                return redirect()->back()->with("success", "Sent successfully. Thank you for contact us we'll get back to you as soon as possible!.");
            } else {
                return redirect()->back()->with("success", "सफलतापूर्वक पठाइयो। हामीलाई सम्पर्क गर्नुभएकोमा धन्यवाद हामी सकेसम्म चाँडो तपाईलाई फिर्ता गर्नेछौं!");
            }
        } else {
            if ($request->cookie('language') == 'en') {
                return redirect()->back()->with('failed', 'Something went wrong!, Please try again.');
            } else {
                return redirect()->back()->with('failed', 'केही गडबड भयो!, कृपया फेरि प्रयास गर्नुहोस्।');
            }
        }
    }

    /**
     * This function post a comment from post view
     * @package sportsNews
     * @return postComment view
     */
    public function postComment(Request $request)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required',
                // 'g-recaptcha-response' => 'required|recaptcha',
            ], [
                'name.required' => 'User name is required',
                'email.required' => 'Email is required',
                'comment.required' => 'Comment field cannot be empty',
                // 'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
                // 'g-recaptcha-response.required' => 'Please complete the captcha',
            ]);

            $postComment = new Comment([
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment,
                'status' => 'Disapproved',
            ]);

            if ($postComment->save()) {
                $postCom = [
                    'comment_id' => $postComment->id,
                    'post_id' => $request->post_id,
                ];
                PostComment::insert($postCom);
                DB::commit();
                if ($request->cookie('language') == 'en') {
                    return redirect()->back()->with('success', 'Comment was submitted successfully!');
                } else {
                    return redirect()->back()->with('success', 'टिप्पणी सफलतापूर्वक पेश गरियो!');
                }
            } else {
                if ($request->cookie('language') == 'en') {
                    return redirect()->back()->with('failed', 'Something went wrong! Please try again.');
                } else {
                    return redirect()->back()->with('failed', 'केहि गलत भयो! फेरि प्रयास गर्नुहोस।');
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * This function reply a comment from post view
     * @package sportsNews
     * @return replyComment view
     */
    public function replyComment(Request $request)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|max:255',
                'message' => 'required',
                // 'g-recaptcha-response' => 'required|recaptcha',
            ], [
                'name.required' => 'User name is required',
                'message.required' => 'Reply Message field cannot be empty',
                // 'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
                // 'g-recaptcha-response.required' => 'Please complete the captcha',
            ]);

            $replyComment = new Reply([
                'name' => $request->name,
                'message' => $request->message,
            ]);

            if ($replyComment->save()) {
                $comReply = [
                    'reply_id' => $replyComment->id,
                    'comment_id' => $request->comment_id,
                ];
                ComReply::insert($comReply);
                DB::commit();
                if ($request->cookie('language') == 'en') {
                    return redirect()->back()->with('success', 'Reply was submitted successfully!');
                } else {
                    return redirect()->back()->with('success', 'जवाफ सफलतापूर्वक पेस गरियो!');
                }
            } else {
                if ($request->cookie('language') == 'en') {
                    return redirect()->back()->with('failed', 'Something went wrong! Please try again.');
                } else {
                    return redirect()->back()->with('failed', 'केहि गलत भयो! फेरि प्रयास गर्नुहोस।');
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    /**
     * This function returns privacy policy page view
     * @package sportsNews
     * @return recentPosts view
     */
    // public function recentPosts()
    // {
    //     $about = About::where('id', 1)->get();

    //     $contact = Contact::where('id', 1)->get();

    //     $posts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(12);

    //     $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('views', 'DESC')->take(6)->get();

    //     $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();


    //     return view('tech.pages.blog', [
    //         
    //         'posts' => $posts,
    //         'about' => $about,
    //         'contact' => $contact,
    //         'latestPosts' => $latestPosts,
    //         'trendPosts' => $trendPosts,
    //         'trendVideos' => $trendVideos,
    //     ]);
    // }

    /**
     * This function returns privacy policy page view
     * @package sportsNews
     * @return privacyPolicy view
     */
    // public function privacyPolicy()
    // {

    //    return view('tech.pages.privacyPolicy', [
    //         'science' => $science,
    //         'tech' => $tech,
    //         'socialMedia' => $socialMedia,
    //         'entertainment' => $entertainment,
    //         'gaming' => $gaming,
    //         'aiCount' => $aiCount,
    //         'techCount' => $techCount,
    //         'reviewCount' => $reviewCount,
    //         'gamingCount' => $gamingCount,
    //         'enterCount' => $enterCount,
    //    ]);
    // }

    /**
     * This function returns terms and conditions page view
     * @package sportsNews
     * @return termsConditions view
     */
    // public function termsConditions()
    // {

    //    return view('tech.pages.termsConditions', [
    //         'science' => $science,
    //         'tech' => $tech,
    //         'socialMedia' => $socialMedia,
    //         'entertainment' => $entertainment,
    //         'gaming' => $gaming,
    //         'aiCount' => $aiCount,
    //         'techCount' => $techCount,
    //         'reviewCount' => $reviewCount,
    //         'gamingCount' => $gamingCount,
    //         'enterCount' => $enterCount,
    //    ]);
    // }

    // public function sendEmail(Request $request)
    // {
    //     // $fromName = env('MAIL_FROM_NAME');
    //     putenv("MAIL_FROM_ADDRESS=$request->email");
    //     $data = [
    //         'full_name' => $request->full_name,
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'subject' => $request->subject,
    //         'message' => $request->message
    //     ];

    //     // Mail::send('tech.pages.email.contact', $data, function($message) {
    //     //     $message->to('admin@sportsNews', 'tech Admin')
    //     //             ->subject('New Contact Form Submission');
    //     // });

    //     Mail::send([], $data, function ($message) use ($data) {
    //         $message->to('admin@sportsNews', 'tech Admin')
    //             ->subject('New Contact Form Submission')
    //             ->setBody(view('tech.pages.email.contact')->with('data', $data)->render(), 'text/html');
    //     });

    //     // Mail::send('emailTemplate.emailtemplate',$data , function($message) use ($request) {
    //     //     $message->from("no-reply@kingsglobaltabernacle.com");
    //     //     $message->to('thekingsglobal@gmail.com');
    //     //  });

    //     return redirect()->back()->with(['success' => 'Thank you for contact us!']);


    //     return view('tech.pages.contact', compact('data'))->with('success', 'Your message has been sent!');
    //     // return redirect()->back()->with('success', 'Your message has been sent!');
    // }

    /**
     * This function returns single video page view
     * @package sportsNews
     * @return singleVideo view
     */

    // public function singleVideo(Request $request, $slug)
    // {
    //     if ($request->cookie('language')) {
    //         $lang = $request->cookie('language');
    //     } else {
    //         $lang = 'en';
    //     }

    //     $about = About::where('id', 1)->get();
    //     $contact = Contact::where('id', 1)->get();

    //     $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('views', 'DESC')->take(6)->get();

    //     $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();

    //     $singleVideo = Video::where('slug', $slug)->get()->first();
    //     $singleVideo->increment('views');

    //      $recommendedVideos =Video::whereNotIn('id', [$singleVideo->id])->where('status', 'Published')->orderByRaw('RAND()')->take(2)->get();
    //      $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

    //     return view('tech.pages.single.video', [

    //         'about' => $about,
    //         'singleVideo' => $singleVideo,
    //         'contact' => $contact,
    //         'trendVideos' => $trendVideos,
    //         'latestPosts' => $latestPosts,
    //         'trendPosts' => $trendPosts,
    //         'recommendedVideos' => $recommendedVideos,
    //     ]);
    // }

    /**
     * This function returns single blog post page view
     * @package sportsNews
     * @return singlePost view
     */
    public function singlePost(Request $request, $slug)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();
        $tags = Tag::orderBy('id', 'ASC')->get();
        $contact = Contact::where('id', 1)->get();
        $singlePost = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved')->with('reply');
        }, 'tag', 'cat', 'prov', 'usr'])->where('slug', $slug)->get()->first();
        // $singlePost = Post::with(['com', 'tag', 'cat', 'prov', 'usr'])->where('slug', $slug)->get()->first();
        $singlePost->increment('views');
        $recommendedPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->whereNotIn('id', [$singlePost->id])->where('status', 'Published')->orderByRaw('RAND()')->take(2)->get();
        $latestPost = Post::with(['tag', 'cat', 'prov', 'usr'])->latest('created_at')->where('status', 'Published')->take(3)->get();

        // Get the next post or the first post if there is no next post
        $nextPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->where('id', '>', $singlePost->id)->orderBy('id', 'asc')->first();
        if (!$nextPost) {
            $nextPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('id', 'asc')->first();
        }

        // Get the previous post or the last post if there is no previous post
        $previousPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->where('id', '<', $singlePost->id)->orderBy('id', 'desc')->first();
        if (!$previousPost) {
            $previousPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('id', 'desc')->first();
        }

        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $recaptchaKey = config('services.recaptcha.key');
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.single.post', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'tags' => $tags,
            'provinces' => $provinces,
            'lang' => $lang,
            'leagues' => $leagues,
            'singlePost' => $singlePost,
            'about' => $about,
            'contact' => $contact,
            'nextPost' => $nextPost,
            'latestPost' => $latestPost,
            'trendVideos' => $trendVideos,
            'previousPost' => $previousPost,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'recommendedPosts' => $recommendedPosts,
            'recaptchaKey' => $recaptchaKey
        ]);
    }


    /**
     * This function returns about us page view
     * @package sportsNews
     * @return aboutUs view
     */
    // public function aboutUs()
    // {
    //     $about = About::where('id', 1)->get();
    //     $contact = Contact::where('id', 1)->get();

    //     return view('tech.pages.aboutUs', [
    //         
    //         'about' => $about,
    //         'contact' => $contact,
    //     ]);
    // }

    /**
     * This function returns contact page view
     * @package sportsNews
     * @return contact view
     */
    // public function contact()
    // {
    //     $about = About::where('id', 1)->get();
    //     $contact = Contact::where('id', 1)->get();


    //     return view('tech.pages.contact', [
    //         
    //         'about' => $about,
    //         'contact' => $contact,
    //     ]);
    // }

    /**
     * This function returns single blog post page view
     * @package sportsNews
     * @return singleVideo view
     */
    public function singleVideo(Request $request, $slug)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $contact = Contact::where('id', 1)->get();
        $singleVideo = Video::where('slug', $slug)->get()->first();
        $singleVideo->increment('views');
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('views', 'DESC')->take(6)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();

        return view('news.pages.single.video', [
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'navAds' => $navAds,
            'sideAds' => $sideAds,
            'contact' => $contact,
            'footerAds' => $footerAds,
            'provinces' => $provinces,
            'trendPosts' => $trendPosts,
            'latestPosts' => $latestPosts,
            'singleVideo' => $singleVideo,
        ]);
    }


    /**
     * This function returs videos page view
     * @package sportsNews
     * @return videos view
     */
    public function videos(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();
        $contact = Contact::where('id', 1)->get();
        $videos = Video::where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(15);

        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('views', 'DESC')->take(6)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

        return view('news.pages.videos', [

            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'about' => $about,
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'videos' => $videos,
            'provinces' => $provinces,
            'contact' => $contact,
            'trendVideos' => $trendVideos,
            'trendPosts' => $trendPosts,
            'latestPosts' => $latestPosts,
        ]);
    }

    /**
     * This function returs blog category page view
     * @package sportsNews
     * @return blogCategory view
     */
    public function category(Request $request, $category)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $posts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->whereHas('cat', function ($query) use ($category) {
            $query->where('category', $category);
        })->orderBy('created_at', 'DESC')->paginate(12);

        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.category', [

            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'posts' => $posts,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'category' => $category,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'trendVideos' => $trendVideos,
        ]);
    }


    /**
     * This function return province page view
     * @package sportsNews
     * @return province  view
     */
    public function province(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.province', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }
    /**
     * This function return gallery  page view
     * @package sportsNews
     * @return gallery  view
     */
    public function galleryAlbum(Request $request, $slug)
    {

        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();
        $tags = Tag::orderBy('id', 'ASC')->get();
        $contact = Contact::where('id', 1)->get();
        $singleAlbum = Gallery::with(['img'])->where('slug', $slug)->get()->first();

        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $recaptchaKey = config('services.recaptcha.key');
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.single.gallery', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'tags' => $tags,
            'provinces' => $provinces,
            'lang' => $lang,
            'leagues' => $leagues,
            'singleAlbum' => $singleAlbum,
            'about' => $about,
            'contact' => $contact,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'recaptchaKey' => $recaptchaKey
        ]);
    }


    /**
     * This function return gallery  page view
     * @package sportsNews
     * @return gallery  view
     */
    public function gallery(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $gallery = Gallery::with(['img'])->orderBy('created_at', 'desc')->paginate(15);
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $videos = Video::where('status', 'Published')->orderBy('created_at', 'DESC')->paginate('10');
        return view('news.pages.gallery', [
            'navAds' => $navAds,
            'videos' => $videos,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'about' => $about,
            'gallery' => $gallery,
            'contact' => $contact,
            'onePost' => $onePost,
            'provinces' => $provinces,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }


    /**
     * This function return contact us  page view
     * @package sportsNews
     * @return contact us  view
     */
    public function contactUs(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();
        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.contactUs', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }

    /**
     * This function return Advertise with us  page view
     * @package sportsNews
     * @return Advertise with us  view
     */
    public function advertise(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();
        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $content = Advertise::where('lang', $lang)->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.advertise', [
            'navAds' => $navAds,
            'content' => $content,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }

    /**
     * This function return about us  page view
     * @package sportsNews
     * @return about us  view
     */
    public function aboutUs(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();
        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.aboutUs', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }
    /**
     * This function return news page view
     * @package sportsNews
     * @return news view
     */
    public function news(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();
        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $intNews = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->whereDoesntHave('prov')->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(15);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('lang', $lang)->where('status', 'Published')->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        return view('news.pages.news', [
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'intNews' => $intNews,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }

    /**
     * This function return Football Results page view
     * @package sportsNews
     * @return Football results view
     */
    public function football(Request $request, $football)
    {

        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();


        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $latestPosts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'DESC')->take(10)->get();

        $trendPosts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::with(['prv'])->orderBy('created_at', 'DESC')->where('status', 'Active')->get()->first();
        $results = Result::with(['match.home.league', 'match.away'])
        ->whereHas('match.home.league', function ($query) use ($football) {
            $query->where('league', $football);})->orderBy('date', 'desc')->get();
        return view('news.pages.football', [
            'sideAds' => $sideAds,
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'provinces' => $provinces,
            'about' => $about,
            'contact' => $contact,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'results' => $results,
            'football' => $football,
        ]);
    }
    /**
     * This function return Single Province page view
     * @package sportsNews
     * @return SingleP rovince view
     */
    public function singleProvince(Request $request, $province)
    {

        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();


        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $firstPost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->first();

        $secondPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->orderBy('created_at', 'desc')->skip(1)->take(2)->get();

        $provincesPosts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->whereHas('prov', function ($query) use ($province) {
                $query->where('province', $province);
            })->orderBy('created_at', 'DESC')->paginate(10);
        $randPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->inRandomOrder()->take(3)->get();
        $onePost = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->latest('created_at')->take(1)->get();

        $latestPosts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->whereHas('prov', function ($query) use ($province) {
                $query->where('province', $province);
            })->orderBy('created_at', 'DESC')->take(10)->get();

        $trendPosts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])
            ->where('status', 'Published')->where('lang', $lang)->whereHas('prov', function ($query) use ($province) {
                $query->where('province', $province);
            })->orderBy('views', 'DESC')->take(10)->get();

        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::with('prv')->whereHas('prv', function ($query) use ($province) {
            $query->where('province', $province);
        })->orderBy('created_at', 'DESC')->where('status', 'Active')->get()->first();

        return view('news.pages.single.province', [
            'sideAds' => $sideAds,
            'navAds' => $navAds,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'provincesPosts' => $provincesPosts,
            'provinces' => $provinces,
            'province' => $province,
            'about' => $about,
            'contact' => $contact,
            'onePost' => $onePost,
            'firstPost' => $firstPost,
            'randPosts' => $randPosts,
            'secondPosts' => $secondPosts,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
        ]);
    }

    /**
     * This function return home page view
     * @package sportsNews
     * @return home view
     */
    public function home(Request $request)
    {
        if ($request->cookie('language')) {
            $lang = $request->cookie('language');
        } else {
            $lang = 'en';
        }
        $leagues = League::orderBy('created_at', 'asc')->get();

        $about = About::where('id', 1)->get();

        $contact = Contact::where('id', 1)->get();

        $posts = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'DESC')->paginate(10);

        $postSlides = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->where('flash_news', 1)->orderBy('created_at', 'DESC')->take(4)->get();

        $postFeatured = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->where('flash_news', 1)->orderBy('created_at', 'DESC')->skip(4)->take(3)->get();

        $provinces = Province::with(['post' => function ($query) use ($lang) {
            $query->with(['cat', 'tag', 'usr', 'com'])->where('lang', $lang)->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'asc')->get();
        $latestPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('created_at', 'DESC')->take(10)->get();
        $trendPosts = Post::with(['tag', 'cat', 'prov', 'usr'])->where('status', 'Published')->where('lang', $lang)->orderBy('views', 'DESC')->take(10)->get();
        $trendVideos = Video::where('status', 'Published')->orderBy('views', 'desc')->take(3)->get();
        $breakingNews = BreakingNews::where('lang', $lang)->orderBy('created_at', 'desc')->take(6)->get();
        $logo = MySite::orderBy('created_at', 'DESC')->get()->first();
        $navAds = Ads::where('position', 'navbar')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $footerAds = Ads::where('position', 'footer')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $homeBtn = Ads::where('position', 'home-between')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sideAds = Ads::where('position', 'sidebar-home')->where('status', 'Active')->orderBy('created_at', 'DESC')->get()->first();
        $sixIntNews = Post::with(['com' => function ($query) {
            $query->where('status', 'Approved');
        }, 'tag', 'cat', 'prov', 'usr'])->whereDoesntHave('prov')->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate(6);
        return view('news.pages.home', [
            'navAds' => $navAds,
            'sixIntNews' => $sixIntNews,
            'footerAds' => $footerAds,
            'sideAds' => $sideAds,
            'homeBtn' => $homeBtn,
            'logo' => $logo,
            'lang' => $lang,
            'leagues' => $leagues,
            'posts' => $posts,
            'about' => $about,
            'contact' => $contact,
            'provinces' => $provinces,
            'postSlides' => $postSlides,
            'trendVideos' => $trendVideos,
            'latestPosts' => $latestPosts,
            'trendPosts' => $trendPosts,
            'breakingNews' => $breakingNews,
            'postFeatured' => $postFeatured,
        ]);
    }
}
