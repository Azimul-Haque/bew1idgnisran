<?php

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

Route::get('/', 'IndexController@index')->name('index.index');
Route::get('/services', 'IndexController@getServices')->name('index.services');
Route::get('/certificate-verify', 'IndexController@getVerifyCertificate')->name('index.verify-certificate');
Route::get('/verify/{unique_serial}', 'IndexController@verifyCertificate')->name('index.verify');
Route::get('/certificate-status', 'IndexController@getApplicationStatus')->name('index.application-status');
Route::get('/notices', 'IndexController@getNotices')->name('index.notices');
Route::get('/contact', 'IndexController@getContact')->name('index.contact');
Route::post('/contact', 'IndexController@storeMessage')->name('store.message');
Route::get('/captcha', 'IndexController@generateCaptcha')->name('captcha.image');
Route::get('/contactcaptcha', 'IndexController@generateContactCaptcha')->name('contactcaptcha.image');
Route::get('/user-guidelines', 'IndexController@getUserGuidelines')->name('index.user-guidelines');
Route::get('/faq', 'IndexController@getFaq')->name('index.faq');


Route::get('/terms-and-conditions', 'IndexController@termsAndConditions')->name('index.terms-and-conditions');
Route::get('/privacy-policy', 'IndexController@privacyPolicy')->name('index.privacy-policy');
Route::get('/refund-policy', 'IndexController@refundPolicy')->name('index.refund-policy');

Route::get('/check/ip', 'IndexController@checkIP')->name('index.check.ip');
Route::post('/account/deletion/request', 'IndexController@requestACDelete')->name('index.account.deletion.request');
Route::get('/redirect/playstore', 'IndexController@redirectPlayStore')->name('index.redirect.playstore');
Route::get('/documentation', 'IndexController@getDocumentation')->name('index.documentation');
Route::get('/api-status', 'IndexController@getAPIStatus')->name('index.api.status');

// blog
Route::get('/blogs', 'BlogController@index')->name('blogs.index');
// Route::resource('blogs','BlogController');
Route::get('blog/{slug}',['as' => 'blog.single', 'uses' => 'BlogController@getBlogPost']);
Route::get('blog/author/{id}',['as' => 'blogger.profile', 'uses' => 'BlogController@getBloggerProfile']);
Route::get('/like/{blog_id}',['as' => 'blog.like', 'uses' => 'BlogController@likeBlogAPI']);
Route::get('/check/like/{blog_id}',['as' => 'blog.checklike', 'uses' => 'BlogController@checkLikeAPI']);
Route::get('/blogs/category/{name}',['as' => 'blog.categorywise', 'uses' => 'BlogController@getCategoryWise']);
Route::get('/blogs/archive/{date}',['as' => 'blog.monthwise', 'uses' => 'BlogController@getMonthWise']);

// Clear Route
Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);


Auth::routes([
    'register' => false,
]);

Route::get('register/authority', 'IndexController@getAuthorityRegister')->name('register.authority');
Route::post('register/authority', 'IndexController@storeAuthorityRegister')->name('register.store.authority');
Route::get('office/login', 'IndexController@getOfficeLogin')->name('office.login');
// Route::get('register/authority/message', 'IndexController@storeAuthorityRegister')->name('register.authority.message');
Route::get('register/citizen', 'IndexController@getCitizenRegister')->name('register.citizen');

// Dashboard starts here
// Dashboard starts here
// Dashboard starts here

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/dashboard/clear/query/cache', 'DashboardController@clearQueryCache')->name('dashboard.clearquerycache');

Route::get('/dashboard/users', 'DashboardController@getUsers')->name('dashboard.users');
Route::get('/dashboard/users/sort', 'DashboardController@getUsersSort')->name('dashboard.userssort');
Route::get('/dashboard/users/expired', 'DashboardController@getExpiredUsers')->name('dashboard.expiredusers');
Route::post('/dashboard/users/expired/send/sms', 'DashboardController@sendExpiredSMS')->name('dashboard.users.expired.sms');
Route::get('/dashboard/users/{search}', 'DashboardController@getUsersSearch')->name('dashboard.users.search');
Route::get('/dashboard/users/{id}/single', 'DashboardController@getUser')->name('dashboard.users.single');
Route::get('/dashboard/users/{id}/single/otherpage', 'DashboardController@getUserWithOtherPage')->name('dashboard.users.singleother');
Route::post('/dashboard/users/store', 'DashboardController@storeUser')->name('dashboard.users.store');
Route::post('/dashboard/users/{id}/update', 'DashboardController@updateUser')->name('dashboard.users.update');
Route::post('/dashboard/users/bulk/package/update', 'DashboardController@updateBulkPackageDate')->name('dashboard.users.bulk.package.update');
Route::get('/dashboard/users/{id}/delete', 'DashboardController@deleteUser')->name('dashboard.users.delete');
Route::post('/dashboard/users/{id}/single/notification', 'DashboardController@sendSingleNotification')->name('dashboard.users.singlenotification');
Route::post('/dashboard/users/{id}/single/sms', 'DashboardController@sendSingleSMS')->name('dashboard.users.singlesms');

Route::get('/dashboard/users/{id}/activate', 'DashboardController@activateUser')->name('dashboard.users.activate');

Route::get('/dashboard/messages', 'DashboardController@getMessages')->name('dashboard.messages');
Route::post('/dashboard/messages/{id}/update', 'DashboardController@updateMessage')->name('dashboard.messages.update');
Route::get('/dashboard/messages/delete/{id}', 'DashboardController@deleteMessage')->name('dashboard.messages.delete');


Route::get('/dashboard/notifications', 'DashboardController@getNotifications')->name('dashboard.notifications');
Route::post('/dashboard/notifications/send', 'DashboardController@sendNotification')->name('dashboard.notifications.send');
Route::get('/dashboard/notifications/delete/{id}', 'DashboardController@deleteNotification')->name('dashboard.notifications.delete');
Route::post('/dashboard/notifications/send/again', 'DashboardController@sendAgainNotification')->name('dashboard.notifications.sendagain');

Route::get('/dashboard/blogs', 'DashboardController@getBlogs')->name('dashboard.blogs');
Route::get('/dashboard/blogs/{search}', 'DashboardController@getBlogsSearch')->name('dashboard.blogs.search');
Route::post('/dashboard/blogs/store', 'DashboardController@storeBlog')->name('dashboard.blogs.store');
Route::post('/dashboard/blogs/{id}/update', 'DashboardController@updateBlog')->name('dashboard.blogs.update');
Route::get('/dashboard/blogs/{id}/delete', 'DashboardController@deleteBlog')->name('dashboard.blogs.delete');
Route::post('/dashboard/blogs/category/store', 'DashboardController@storeBlogCategory')->name('dashboard.blogs.blogcategory.store');
Route::post('/dashboard/blogs/category/{id}/update', 'DashboardController@updateBlogCategory')->name('dashboard.blogs.blogcategory.update');