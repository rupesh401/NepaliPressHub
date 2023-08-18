<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/get-decrypted-data', 'AuthController@getDecryptedData');
/**
 * It Redirect to controller and returns nepal language view page
 */
Route::get('/change-language/{language}', function ($language, Request $request) {
    // Your validation for $language here to ensure it's a supported language

    $minutes = 60 * 24 * 30; // 30 days expiration time for the cookie
    // dd($language);
    return redirect()->back()->cookie('language', $language, $minutes);
})->name('change-lang');

Route::put('/update-likes/{post}', 'MainController@updateLikes')->name('update-likes');

/**
 * Search for related keyword posts
 */

Route::post('/search', 'MainController@search')->name('search');

/**
 * It Redirect to controller and returns single project post page
 */

Route::post('/send/email', 'MainController@sendEmail')->name('send-email');

/**
 * Posting a email
 */

Route::post('/post-message', 'MainController@postMessage')->name('post-message');

/**
 * Posting a comment
 */

Route::post('/post-comment', 'MainController@postComment')->name('post-comment');

/**
 * Reply a comment
 */

Route::post('/reply-comment', 'MainController@replyComment')->name('reply-comment');

/**
 * It Redirect to controller and returns single blog post page
 */

Route::get('/posts/{link}', 'MainController@singlePost')->name('single-post');

/**
 * It Redirect to controller and returns about us page
 */

Route::get('/our-story', 'MainController@aboutUs')->name('our-story');

/**
 * It Redirect to controller and returns Recent Posts page
 */

Route::get('/recent-posts', 'MainController@recentPosts')->name('recent-posts');

/**
 * It Redirect to controller and returns Privacy policy page
 */

Route::get('/privacy-policy', 'MainController@privacyPolicy')->name('privacy-policy');

/**
 * It Redirect to controller and returns terms and conditions page
 */

Route::get('/terms-conditions', 'MainController@termsConditions')->name('terms-conditions');

/**
 * It Redirect to controller and returns contact page
 */

Route::get('/contact', 'MainController@contact')->name('contact');

/**
 * It Redirect to controller and return category page
 */

 Route::get('/category/{category}', 'MainController@category')->name('category');


/**
 * It Redirect to controller and return Province page
 */
Route::get('/provinces', 'MainController@province')->name('provinces');

/**
 * It Redirect to controller and return gallery page
 */
Route::get('/gallery', 'MainController@gallery')->name('gallery');

/**
 * It Redirect to controller and return gallery page
 */
Route::get('/gallery/album/{slug}', 'MainController@galleryAlbum')->name('gallery-album');

/**
 * It Redirect to controller and return About us page
 */
//  Route::get('/about-us', 'MainController@aboutUs')->name('our-story');

 /**
 * It Redirect to controller and return Contact us page
 */
 Route::get('/advertise-with-us', 'MainController@advertise')->name('advertise');
 
 /**
 * It Redirect to controller and return Contact us page
 */
 Route::get('/contact-us', 'MainController@contactUs')->name('contact-us');

/**
 * It Redirect to controller and return news page
 */
Route::get('/international-news', 'MainController@news')->name('news');

/**
 * It Redirect to controller and return Single-Provinces page
 */
Route::get('/videos', 'MainController@videos')->name('videos');

/**
 * It Redirect to controller and return Single-Video page
 */
Route::get('/videos/{slug}', 'MainController@singleVideo')->name('single-video');

/**
 * It Redirect to controller and return Single-Provinces page
 */
Route::get('/province/{province}', 'MainController@singleProvince')->name('single-provinces');

/**
 * It Redirect to controller and returns home page
 */
Route::get('/', 'MainController@home')->name('home');




/**
 * Apis Routes for Shadomby Admin Dashboard
 * @package Shadomby
 */

 //  Delete Comment
Route::post('/delete_comment', 'ApiController@deleteComment');

//  Delete video
Route::post('/delete_video', 'ApiController@deleteVideo');

//  Delete Ads
Route::post('/delete_ads', 'ApiController@deleteAds');

//  Update Comment Status
Route::post('/update_comment_status', 'ApiController@updateCommentStatus');

//  Get All Comments From Visitors
Route::get('/get_comments', 'ApiController@getComments');

 // Uploads Images
Route::post('/uploads_images', 'ApiController@uploadImages');

//  Delete Images
Route::post('/delete_images', 'ApiController@deleteImages');

//  Delete Album
Route::post('/delete_album', 'ApiController@deleteAlbum');

//  Delete Images
Route::post('/delete_image_in_album', 'ApiController@deleteImageInAlbum');

//  Uploading Profile Picture
Route::post('/upload_profile_picture', 'ApiController@uploadProfilePicture');

//  Update Logo 
Route::post('/update_logo', 'ApiController@updateLogo');

//  Get Logo 
Route::get('/get_logo', 'ApiController@getLogo');

//  Update Profile Picture
Route::post('/update_profile_picture', 'ApiController@updateProfilePicture');

//  Getting total of data
Route::get('/get_data_total', 'ApiController@getTotalData');

//  Getting latest four events
Route::get('/get_latest_four_videos', 'ApiController@getLatestVideos');

//  Getting latest four comments
Route::get('/get_latest_four_comments', 'ApiController@getLatestComments');

//  Getting latest four posts
Route::get('/get_latest_four_posts', 'ApiController@getLatestPosts');

//  Getting My latest four posts
Route::get('/get_my_latest_four_posts', 'ApiController@getMyLatestPosts');

//  Login logs for user
Route::get('/login_logs', 'ApiController@loginLogs');

//  Upload About us image
Route::post('/upload_about_us_image', 'ApiController@uploadAboutImage');

//  Upload Video image
Route::post('/upload_video_image', 'ApiController@uploadVideoImage');

//  Upload Gallery image
Route::post('/upload_gallery_image', 'ApiController@uploadGalleryImage');

//  Update Gallery images
Route::post('/edit_images', 'ApiController@editImages');

//  Upload Logo image
Route::post('/upload_logo', 'ApiController@uploadLogo');

//  Getting About us
Route::get('/get_abouts', 'ApiController@getAbout');

//  Editing or Update About us
Route::post('/edit_about', 'ApiController@editAbout');

//  Add About us
Route::post('/add_new_about', 'ApiController@addNewAbout');

//  Getting contact
Route::get('/get_contact', 'ApiController@getContact');

//  Editing or Update Contact
Route::post('/edit_contact', 'ApiController@editContact');

//  Add Contact
Route::post('/add_new_contact', 'ApiController@addContact');

// Delete Post
Route::post('/delete_post', 'ApiController@deletePost');

//  Upload Ads image
Route::post('/upload_ads_image', 'ApiController@uploadAdsImage');

//  Getting Ads
Route::get('/get_ads', 'ApiController@getAds');

//  Editing or Update Ads
Route::post('/edit_ads', 'ApiController@editAds');
//  Editing or Update Ads
Route::post('/edit_ads', 'ApiController@editAds');

//  Add Ads
Route::post('/add_new_ads', 'ApiController@addNewAds');

// Delete Post
Route::post('/delete_post', 'ApiController@deletePost');

//  Editing or Update Post
Route::post('/edit_post', 'ApiController@editPost');

//  Getting all posts
Route::get('/get_posts', 'ApiController@getPosts');

 //  Adding New Post
Route::post('/add_new_post', 'ApiController@addNewPost');

//  Getting all tags
Route::get('/get_tags', 'ApiController@getTags');

//  Adding New Tag
Route::post('/add_new_tag', 'ApiController@addNewTag');

//  Editing or Update Tag
Route::post('/edit_tag', 'ApiController@editTag');

//  Delete Tag
Route::post('/delete_tag', 'ApiController@deleteTag');

//  Getting all breaking news
Route::get('/get_breaking_news', 'ApiController@getBreakingNews');

//  Adding New Breaking News
Route::post('/add_new_breaking_news', 'ApiController@addNewBreakingNews');

//  Editing or Update Breaking News
Route::post('/edit_breaking_news', 'ApiController@editBreakingNews');

//  Delete Tag
Route::post('/delete_breaking_news', 'ApiController@deleteBreakingNews');

//  Getting all videos
Route::get('/get_videos', 'ApiController@getVideos');

//  Getting all images
Route::get('/get_images', 'ApiController@getAllImages');

//  Getting Advertise Info
Route::get('/get_advertise_info', 'ApiController@getAdvertiseInfo');

//  Delete Advertise Info
Route::post('/delete_advertise_info', 'ApiController@deleteAdvertiseInfo');

//  Editing or Update Advertise Info
Route::post('/edit_advertise_info', 'ApiController@editAdvertiseInfo');

//  Adding New Advertise Info
Route::post('/add_new_advertise_info', 'ApiController@addNewAdvertiseInfo');

//  Adding New Video
Route::post('/add_new_video', 'ApiController@addNewVideo');

//  Adding New Image
Route::post('/add_new_images', 'ApiController@addNewImages');

//  Editing or Update Video
Route::post('/edit_video', 'ApiController@editVideo');

//  Getting all categories
Route::get('/get_categories', 'ApiController@getCategories');

//  Adding New Category
Route::post('/add_new_category', 'ApiController@addNewCategory');

//  Editing or Update Category
Route::post('/edit_category', 'ApiController@editCategory');

//  Delete Category
Route::post('/delete_category', 'ApiController@deleteCategory');

//  Getting all provinces
Route::get('/get_provinces', 'ApiController@getProvinces');

//  Adding New Province
Route::post('/add_new_province', 'ApiController@addNewProvince');

//  Editing or Update Province
Route::post('/edit_province', 'ApiController@editProvince');

//  Delete Province
Route::post('/delete_province', 'ApiController@deleteProvince');

Route::post('/upload_post_image', 'ApiController@uploadPostImage');

//  Getting all admins
Route::get('/get_admins', 'ApiController@getAdmins');

//  Editing or Update the admin information
Route::post('/edit_admin', 'ApiController@editAdmin');

//  Editing or Update the admin password
Route::post('/change_password', 'ApiController@changePassword');

//  Delete the admin information
Route::post('/delete_admin_user', 'ApiController@deleteAdminUser');

// Adding New Admin User
 Route::post('/add_new_admin', 'ApiController@addNewAdmin');


Route::get('/logout', 'AuthController@logout')->name('logout');

Route::post('/login_data', 'AuthController@login');

Route::any('/{slug}', 'AuthController@index');

// Route::any('/{slug}', function () {
//     return view('welcome');
// });
