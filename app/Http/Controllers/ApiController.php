<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\User;
use App\About;
use App\Ads;
use App\BreakingNews;
use App\Video;
use App\Comment;
use App\Contact;
use App\PostTag;
use App\Category;
use App\Gallery;
use App\GalMage;
use App\Image;
use App\LoginLog;
use App\MySite;
use App\PostCats;
use App\PostComment;
use App\PostProv;
use App\ProvAds;
use App\Province;
use App\UserPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function getAds()
    {
        $ads = Ads::with(['prv'])->orderBy('created_at', 'DESC')->get();

        if (!empty($ads)) {
            return response()->json(['data' => $ads, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function editAds(Request $request)
    {
        DB::beginTransaction();

        try {

            $updateAds =  Ads::find($request->id);
            $updateAds->position = $request->position;
            $updateAds->image = $request->image;
            $updateAds->link = $request->link;

            if ($updateAds->update()) {
                ProvAds::where('ads_id', $request->id)->delete();
                if ($request->province) {
                    $adsProv = ['province_id' => $request->province, 'ads_id' => $updateAds->id];
                    ProvAds::insert($adsProv);
                }
                DB::commit();
                return response()->json(['data' => $updateAds, 'status' => 'success', 'status_code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            } catch (\Exception $th) {
                DB::rollback();
                throw $th;
            }
    }

    public function addNewAds(Request $request)
    {
        DB::beginTransaction();

        try {
            $newAds = new Ads();
            $newAds->user_id = Auth::user()->id;
            $newAds->position = $request->position;
            $newAds->image = $request->image;
            $newAds->link = $request->link;

            if ($newAds->save()) {
                if ($request->province) {
                    $adsProv = ['province_id' => $request->province, 'ads_id' => $newAds->id];
                    ProvAds::insert($adsProv);
                }
                DB::commit();
                return response()->json(['data' => $newAds, 'status' => 'success', 'status_code' => 201]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            } catch (\Exception $th) {
                DB::rollback();
                throw $th;
            }
    }

    public function changePassword(Request $request)
    {

        $user = User::find($request->id);
        $user->password = bcrypt($request->password);

        if ($user->update()) {
            return response()->json(['status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
    public function getBreakingNews()
    {
        $breakingNews = BreakingNews::orderBy('created_at', 'DESC')->get();

        if (!empty($breakingNews)) {
            return response()->json(['data' => $breakingNews, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
    public function editBreakingNews(Request $request)
    {
        $updateBreakingNews =  BreakingNews::find($request->id);
        $updateBreakingNews->title = $request->title;
        $updateBreakingNews->lang = $request->lang;
        if ($updateBreakingNews->update()) {
            return response()->json(['data' => $updateBreakingNews, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteBreakingNews(Request $request)
    {
        $breakingnews = BreakingNews::find($request->id);
        if (!$breakingnews) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $breakingnews->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function addNewBreakingNews(Request $request)
    {
        $newBreakingNews = new BreakingNews();
        $newBreakingNews->user_id = Auth::user()->id;
        $newBreakingNews->title = $request->title;
        $newBreakingNews->lang = $request->lang;

        if ($newBreakingNews->save()) {
            return response()->json(['data' => $newBreakingNews, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }


    public function deleteComment(Request $request)
    {
        $comment = Comment::find($request->id);
        if (!$comment) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $comment->delete();
            $postCom = PostComment::where('comment_id', $request->id);
            if (!$postCom) {
                $postCom->delete();
            }
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function updateCommentStatus(Request $request)
    {
        $updateStatus = Comment::find($request->id);;
        $updateStatus->status = $request->status;
        if ($updateStatus->update()) {
            return response()->json(['status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getComments()
    {

        $comments = Comment::orderBy('created_at', 'DESC')->get();

        if (!empty($comments)) {
            return response()->json(['data' => $comments, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteImages(Request $request)
    {
        $currentBaseUrl = request()->root();
        if (Str::startsWith($currentBaseUrl, 'https://techviewed.com')) {
            $path = str_replace('public/storage/', '', $request->path);
        } else {
            $path = str_replace('storage/', '', $request->path);
        }
        if (Storage::disk('storage')->exists($path)) {
            Storage::disk('storage')->delete($path);
            return response()->json(['success' => 1]);
        } else {
            return response()->json(['success' => 0]);
        }
    }

    public function uploadImages(Request $request)
    {
        $picture = time() . '.' . $request->image->extension();
        $filePath = $request->image->storeAs($request->path, $picture, 'storage');
        $picUrl = Storage::disk('storage')->url($filePath);
        $currentBaseUrl = request()->root();
        if (Str::startsWith($currentBaseUrl, 'http://127.0.0.1:')) {
            $transformedUrl =  $picUrl;
        } else {
            $transformedUrl = str_replace(':8000/storage', '/public/storage', $picUrl);
        }
        return response()->json(['success' => 1, 'file' => ['url' => $transformedUrl]]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/admins';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }

    public function updateLogo(Request $request)
    {

        $updateLogo = MySite::find(1);
        if ($updateLogo) {
            $updateLogo->logo = $request->logo;
            if ($updateLogo->update()) {
                return response()->json(['data' => $updateLogo, 'status' => 'success', 'status_code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } else {
            $newLogo = new MySite();
            $newLogo->logo = $request->logo;
            if ($newLogo->save()) {
                return response()->json(['data' => $newLogo, 'status' => 'success', 'status_code' => 201]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        }
    }

    public function updateProfilePicture(Request $request)
    {
        $updateProfilePicture = User::find($request->id);;
        $updateProfilePicture->profile_image = $request->profile_image;

        if ($updateProfilePicture->update()) {
            return response()->json(['data' => $updateProfilePicture, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function uploadLogo(Request $request)
    {
        $picture =  time() . '.' . $request->file->extension();
        $path = 'site';
        $request->file->storeAs($path, $picture, 'storage');
        return $picture;
    }

    public function uploadAdsImage(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/ads';
        $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }
    
    public function uploadVideoImage(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/videos';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }

    public function uploadGalleryImage(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/gallery/images';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }

    public function getAllImages()
    {
        $images = Gallery::with(['img'])->orderBy('created_at', 'DESC')->get();

        if (!empty($images)) {
            return response()->json(['data' => $images, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getLogo()
    {
        $logo = MySite::orderBy('created_at', 'ASC')->get();

        if (!empty($logo)) {
            return response()->json(['data' => $logo, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getVideos()
    {
        $Video = Video::orderBy('created_at', 'DESC')->get();

        if (!empty($Video)) {
            return response()->json(['data' => $Video, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function editVideo(Request $request)
    {
        $updateVideo = Video::find($request->id);;
        if (empty($request->status)) {
            $updateVideo->title = $request->title;
            $updateVideo->link = $request->link;
            $updateVideo->image = $request->image;
            $slug = Str::slug($request->title);
            $count = Video::whereNotIn('id', [$request->id])->where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $updateVideo->slug = $slug;
        } else {
            $updateVideo->status = $request->status;
        }

        if ($updateVideo->update()) {
            return response()->json(['data' => $updateVideo, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewVideo(Request $request)
    {
        $video = new Video();
        $video->user_id = Auth::user()->id;
        $video->title = $request->title;
        $video->link = $request->link;
        $video->image = $request->image;
        $video->status = 'Published';

        $slug = Str::slug($request->title);
        $count = Video::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        $video->slug = $slug;

        if ($video->save()) {
            return response()->json(['data' => $video, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewImages(Request $request)
    {
        $postImage = [];

        DB::beginTransaction();
        try {
            $newGalleryImage = new Gallery();
            $newGalleryImage->user_id = Auth::user()->id;
            $newGalleryImage->album_title = $request->album_title;
            if ($newGalleryImage->save()) {
                foreach ($request->image as $image) {
                    $newImage = new Image();
                    $newImage->image = $image;
                    if ($newImage->save()) {
                        array_push($postImage, ['gallery_id' => $newGalleryImage->id, 'image_id' => $newImage->id]);
                    }
                }
                $postCats = ['category_id' => $request->category, 'post_id' => $newGalleryImage->id];
                $userPost = ['user_id' => Auth::user()->id, 'post_id' => $newGalleryImage->id];
                GalMage::insert($postImage);
                DB::commit();

                return response()->json(['data' => $newGalleryImage, 'status' => 'success', 'status_code' => 201]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function getTotalData()
    {
        $totalPost = Post::all()->count();
        $totalVideos = Video::all()->count();
        $totalComments = Comment::all()->count();

        if (!empty($totalPost)) {
            return response()->json([
                'totalPost' => $totalPost,
                'totalVideos' => $totalVideos,
                'totalComments' => $totalComments,
                'status' => 'success', 'status_code' => 200
            ]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getLatestVideos()
    {
        $videos = Video::latest('created_at')->take(4)->orderBy('id', 'DESC')->get();

        if (!empty($videos)) {
            return response()->json(['data' => $videos, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getMyLatestPosts()
    {
        $posts = Post::with(['usr'])->where('user_id', Auth::user()->id)->latest('created_at')->take(4)->orderBy('id', 'DESC')->get();
        $total = Post::where('user_id', Auth::user()->id)->count();

        if (!empty($posts)) {
            return response()->json(['data' => $posts, 'total' => $total, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getLatestComments()
    {
        $comments = Comment::latest('created_at')->take(5)->get();

        if (!empty($comments)) {
            return response()->json(['data' => $comments, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getLatestPosts()
    {
        $posts = Post::with(['usr'])->latest('created_at')->take(4)->orderBy('id', 'DESC')->get();

        if (!empty($posts)) {
            return response()->json(['data' => $posts, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function loginLogs()
    {
        $loginLogs = LoginLog::where('user_id', Auth::user()->id)->latest('created_at')->orderBy('id', 'DESC')->take(6)->get();

        if (!empty($loginLogs)) {
            return response()->json(['data' => $loginLogs, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function uploadAboutImage(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/abouts';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }

    public function getAbout()
    {
        $about = About::where('id', 1)->orderBy('created_at', 'DESC')->get();

        if (!empty($about)) {
            return response()->json(['data' => $about, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function editAbout(Request $request)
    {
        $updateAbout = About::find($request->id);;
        $updateAbout->about_us = $request->about_us;

        if ($updateAbout->update()) {
            return response()->json(['data' => $updateAbout, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewAbout(Request $request)
    {
        $about = new About();
        $about->user_id = Auth::user()->id;
        $about->about_us = $request->about_us;

        if ($about->save()) {
            return response()->json(['data' => $about, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getContact()
    {
        $contact = Contact::where('id', 1)->orderBy('created_at', 'DESC')->get();

        if (!empty($contact)) {
            return response()->json(['data' => $contact, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function editContact(Request $request)
    {
        $updateContact =  Contact::find($request->id);
        $updateContact->phone_number = $request->phone_number;
        $updateContact->email = $request->email;
        $updateContact->twitter = $request->twitter;
        $updateContact->facebook = $request->facebook;
        $updateContact->instagram = $request->instagram;
        $updateContact->youtube = $request->youtube;

        if ($updateContact->update()) {
            return response()->json(['data' => $updateContact, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addContact(Request $request)
    {
        $contact = new Contact();
        $contact->user_id = Auth::user()->id;
        $contact->phone_number = $request->phone_number;
        $contact->email = $request->email;
        $contact->twitter = $request->twitter;
        $contact->facebook = $request->facebook;
        $contact->instagram = $request->instagram;
        $contact->youtube = $request->youtube;

        if ($contact->save()) {
            return response()->json(['data' => $contact, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deletePost(Request $request)
    {
        $tag = Post::find($request->id);
        if (!$tag) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {

            $deleteCat = PostCats::where('post_id', $request->id);
            if ($deleteCat->count() != 0) {
                $deleteCat->delete();
            }
            $deleteTag = PostTag::where('post_id', $request->id);
            if ($deleteTag->count() != 0) {
                $deleteTag->delete();
            }
            $tag->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editPost(Request $request)
    {
        $postTags = [];
        DB::beginTransaction();
        try {
            $updatePost =  Post::find($request->id);
            if (empty($request->status)) {
                $updatePost->title = $request->title;
                $updatePost->content = $request->content;
                $updatePost->lang = $request->lang;
                $updatePost->image = $request->image;
                $updatePost->flash_news = $request->flash_news;
                $slug = Str::slug($request->title);
                $count = Post::whereNotIn('id', [$request->id])->where('slug', $slug)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                $updatePost->slug = $slug;
                foreach ($request->tags as $tag) {
                    array_push($postTags, ['tag_id' => $tag, 'post_id' => $request->id]);
                }
                $postCats = ['category_id' => $request->category, 'post_id' => $request->id];
                $postProvs = ['province_id' => $request->province, 'post_id' => $request->id];

                PostProv::where('post_id', $request->id)->delete();
                PostCats::where('post_id', $request->id)->delete();
                PostTag::where('post_id', $request->id)->delete();

                if ($request->province) {
                    PostProv::insert($postProvs);
                }
                PostTag::insert($postTags);
                PostCats::insert($postCats);
            } else {
                $updatePost->status = $request->status;
            }
            if ($updatePost->update()) {

                DB::commit();

                return response()->json(['data' => $updatePost, 'status' => 'success', 'status_code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function getPosts()
    {
        $posts = Post::with(['tag', 'cat', 'prov', 'usr'])->orderBy('created_at', 'DESC')->get();

        if (!empty($posts)) {
            return response()->json(['data' => $posts, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewPost(Request $request)
    {
        $postTags = [];

        DB::beginTransaction();
        try {
            $newPost = new Post();
            $newPost->user_id = Auth::user()->id;
            $newPost->title = $request->title;
            $newPost->content = $request->content;
            $newPost->image = $request->image;
            $newPost->lang = $request->lang;
            $newPost->status = 'Published';
            $newPost->flash_news = $request->flash_news;
            $slug = Str::slug($request->title);
            $count = Post::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $newPost->slug = $slug;

            if ($newPost->save()) {

                foreach ($request->tags as $tag) {
                    array_push($postTags, ['tag_id' => $tag, 'post_id' => $newPost->id]);
                }
                $postCats = ['category_id' => $request->category, 'post_id' => $newPost->id];
                $userPost = ['user_id' => Auth::user()->id, 'post_id' => $newPost->id];
                PostTag::insert($postTags);
                PostCats::insert($postCats);

                if ($request->province) {
                    $postProvs = ['province_id' => $request->province, 'post_id' => $newPost->id];
                    PostProv::insert($postProvs);
                }
                UserPost::insert($userPost);
                DB::commit();
                return response()->json(['data' => $newPost, 'status' => 'success', 'status_code' => 201]);
            } else {
                return response()->json(['status' => 'failed', 'status_code' => 200]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        } catch (\Exception $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function getTags()
    {
        $tags = Tag::orderBy('created_at', 'DESC')->get();

        if (!empty($tags)) {
            return response()->json(['data' => $tags, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function editTag(Request $request)
    {
        $updateTag =  Tag::find($request->id);
        $updateTag->tag = $request->name;
        if ($updateTag->update()) {
            return response()->json(['data' => $updateTag, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteVideo(Request $request)
    {
        $video = Video::find($request->id);
        if (!$video) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $video->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function deleteTag(Request $request)
    {
        $tag = Tag::find($request->id);
        if (!$tag) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $tag->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function addNewTag(Request $request)
    {
        $newTag = new Tag();
        $newTag->user_id = Auth::user()->id;
        $newTag->tag = $request->name;

        if ($newTag->save()) {
            return response()->json(['data' => $newTag, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function getCategories()
    {
        $cats = Category::orderBy('created_at', 'DESC')->get();

        if (!empty($cats)) {
            return response()->json(['data' => $cats, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $category->delete();
            $catPost = PostCats::where('category_id', $request->id);
            if (!$catPost) {
                $catPost->delete();
            }
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editCategory(Request $request)
    {
        $updateCat =  Category::find($request->id);
        $updateCat->category = $request->name;
        if ($updateCat->update()) {
            return response()->json(['data' => $updateCat, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewCategory(Request $request)
    {
        $newCat = new Category();
        $newCat->user_id = Auth::user()->id;
        $newCat->category = $request->name;

        if ($newCat->save()) {
            return response()->json(['data' => $newCat, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }


    public function getProvinces()
    {
        $province = Province::orderBy('created_at', 'DESC')->get();

        if (!empty($province)) {
            return response()->json(['data' => $province, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteProvince(Request $request)
    {
        $province = Province::find($request->id);
        if (!$province) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $province->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editProvince(Request $request)
    {
        $updateProvince =  Province::find($request->id);
        $updateProvince->province = $request->name;
        if ($updateProvince->update()) {
            return response()->json(['data' => $updateProvince, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function addNewProvince(Request $request)
    {
        $newProvince = new Province();
        $newProvince->user_id = Auth::user()->id;
        $newProvince->province = $request->name;

        if ($newProvince->save()) {
            return response()->json(['data' => $newProvince, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function uploadPostImage(Request $request)
    {
        $picture = time() . '.' . $request->file->extension();
        $path = 'uploads/posts';
        $filePath = $request->file->storeAs($path, $picture, 'storage');

        return $picture;
    }

    public function getAdmins()
    {
        $admins = User::where('level', 2)->orderBy('created_at', 'DESC')->get();

        if (!empty($admins)) {
            return response()->json(['data' => $admins, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }

    public function deleteAdminUser(Request $request)
    {
        $admin = User::find($request->id);
        if (!$admin) {
            return response()->json(['status' => 'failed', 'status_code' => 404]);
        } else {
            $admin->delete();
            return response()->json(['status' => 'success', 'status_code' => 200]);
        }
    }

    public function editAdmin(Request $request)
    {
        $updateAdmin =  User::find($request->id);
        if (empty($request->status)) {
            $updateAdmin->full_name = $request->full_name;
            $updateAdmin->email = $request->email_address;
            $updateAdmin->phone_number = $request->phone_number;
            if (!empty($request->password)) {
                $updateAdmin->password = bcrypt($request->password);
            }
        } else {
            $updateAdmin->status = $request->status;
        }

        if ($updateAdmin->update()) {
            return response()->json(['data' => $updateAdmin, 'status' => 'success', 'status_code' => 200]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
    public function addNewAdmin(Request $request)
    {
        $newAdmin = new User();
        $newAdmin->full_name = $request->full_name;
        $newAdmin->email = $request->email_address;
        $newAdmin->phone_number = $request->phone_number;
        $newAdmin->level = 2;
        $newAdmin->status = 'Active';
        $newAdmin->creator_id = Auth::user()->id;
        $newAdmin->password = bcrypt($request->password);

        if ($newAdmin->save()) {
            return response()->json(['data' => $newAdmin, 'status' => 'success', 'status_code' => 201]);
        } else {
            return response()->json(['status' => 'failed', 'status_code' => 200]);
        }
    }
}
