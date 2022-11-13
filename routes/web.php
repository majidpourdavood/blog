<?php

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


use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'View'], function () {


    Route::get('sitemap.xml', 'SitemapController@index')->name('sitemap.index');
    Route::get('sitemap.xml/all', 'SitemapController@all')->name('sitemap.all');
    Route::get('sitemap.xml/blogs', 'SitemapController@blogs')->name('sitemap.blogs');

    Route::post('uploadFile', 'ViewController@uploadFile')->name('uploadFile');
    Route::post('uploadFileModel', 'HelperController@uploadFileModel')->name('uploadFileModel');

    Route::post('uploadFiles', 'HelperController@uploadFiles')->name('uploadFiles');
    Route::post('uploadFileAll', 'HelperController@uploadFileAll')->name('uploadFileAll');
    Route::delete('delete-files/{id}', 'HelperController@deleteFiles')->name('deleteFiles');


    Route::get('/getCategoryTree', 'HelperController@getCategoryTree')->name('getCategoryTree');
    Route::get('/getLocationAjax/{id}', 'HelperController@getLocationAjax')->name('getLocationAjax');
    Route::get('/getCategoryAjax/{id}', 'HelperController@getCategoryAjax')->name('getCategoryAjax');

    Route::get('/storage/{filename}', 'ViewController@getFile')->name('getFile');

    Route::post('/upload-image-user', 'ViewController@uploadImageUser')->name('uploadImageUser'); //user


});


Route::group(['namespace' => 'View', 'middleware' => []], function () {

    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/contact-us', 'IndexController@contactUs')->name('contactUs');
    Route::get('/about-us', 'IndexController@aboutUs')->name('aboutUs');
    Route::get('/setLanguage', 'IndexController@setLanguage')->name('setLanguage');

    Route::get('blogs', 'IndexController@blogs')->name('blogs');
    Route::get('/blog/{slug}', 'IndexController@blog')->name('blog');
    Route::get('/{blogId}/blog-link', 'IndexController@blogLink')->name('blogLink');

    Route::post('comments', 'ViewController@comments')->name('comments');

    Route::get('/loginIntended', 'ViewController@loginIntended')->name('loginIntended');
    Route::get('/registerIntended', 'ViewController@registerIntended')->name('registerIntended');


});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth:web', 'role'], 'prefix' => 'admin'], function () {

    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');

    Route::get('/getManageSite', 'SettingController@getManageSite')->name('getManageSite');
    Route::post('/manageSite', 'SettingController@manageSite')->name('manageSite');

    Route::get('/cache-clear', 'AdminController@cacheClear')->name('cacheClear');


    Route::get('/notifications', 'AdminController@notifications')->name('admin.notifications');
    Route::post('/upload-image', 'AdminController@uploadImageSubject')->name('uploadImageSubject');


    Route::resource('roles', 'RoleController')->except([
        'show'
    ]);;
    Route::resource('permissions', 'PermissionController')->except([
        'show'
    ]);;
    Route::resource('category', 'CategoryController')->except([
        'show'
    ]);

    Route::resource('menu', 'MenuController')->except([
        'show'
    ]);


    Route::get('comments/unsuccessful', 'CommentController@commentUnSuccessFull')->name('commentUnSuccessFull');
    Route::get('comments/successful', 'CommentController@commentSuccessFull')->name('commentSuccessFull');
    Route::get('comments/all', 'CommentController@commentAll')->name('commentAll');

    Route::delete('comment/destroy/{id}', 'CommentController@destroy')->name('comment.destroy');
    Route::patch('/{id}/comment', 'CommentController@approved')->name('approve.comment');

    Route::get('/{id}/reply-comment', 'CommentController@getReplyCommentAdmin')->name('getReplyCommentAdmin');
    Route::post('/{id}/post-reply-comment', 'CommentController@postReplyCommentAdmin')->name('postReplyCommentAdmin');

    Route::get('comments/index', 'CommentController@index')->name('comment.index');

    Route::resource('blog', 'BlogController')->except([
        'show'
    ]);;

    Route::get('/create-item', 'ItemController@create')->name('createItem');
    Route::post('/store-item', 'ItemController@store')->name('storeItem');
    Route::get('/edit-item/{id}', 'ItemController@edit')->name('editItem');
    Route::patch('/update-item/{id}', 'ItemController@update')->name('updateItem');
    Route::delete('/delete-item/{id}', 'ItemController@destroy')->name('deleteItem');

    Route::get('/add-file', 'FileController@create')->name('createFile');
    Route::post('/store-file', 'FileController@store')->name('storeFile');
    Route::get('/edit-file/{id}', 'FileController@edit')->name('editFile');
    Route::patch('/update-file/{id}', 'FileController@update')->name('updateFile');
    Route::delete('/delete-file/{id}', 'FileController@destroy')->name('deleteFile');

    Route::resource('setting', 'SettingController')->except([
        'show'
    ]);

    Route::resource('translation', 'TranslationController')->except([
        'show'
    ]);

    Route::post('sortableItem', 'ItemController@sortableItem')->name('sortableItem');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users.index');

        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/store', 'UserController@store')->name('users.store');
        Route::patch('/{user}/activeUser', 'UserController@activeUser')->name('activeUser');
        Route::delete('/{user}/destroy', 'UserController@destroy')->name('users.destroy');
        Route::get('/{user}/edit', 'UserController@edit')->name('users.edit');
        Route::patch('/{user}/update', 'UserController@update')->name('user.update');
        Route::get('/{user}/resetPassword', 'UserController@showResetForm')->name('users.resetPassword');
        Route::patch('/{user}/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');

        Route::get('/{user}/userPermissions', 'UserController@userPermissions')->name('userPermissions');
        Route::patch('/{user}/updateUserPermissions', 'UserController@updateUserPermissions')->name('updateUserPermissions');

    });

});


Route::get('/getLocation/{id}', 'View\ViewController@getLocation')->name('getLocation');
Route::get('/getCategory/{id}', 'View\ViewController@getCategory')->name('getCategory');
Route::post('/upload-image', 'View\ViewController@imageUploadView')->name('imageUploadView');

Route::get('/getCity/{id}', 'View\ViewController@getCity')->name('getCity');
Route::get('/getSubCategory/{id}', 'View\ViewController@getSubCategory')->name('getSubCategory');


Route::group(['namespace' => 'View'], function () {
    Route::post('likeComment', 'ViewController@likeComment')->name('likeComment');
    Route::post('disLikeComment', 'ViewController@disLikeComment')->name('disLikeComment');
    Route::post('ratings', 'ViewController@ratings')->name('ratings');

});


Route::group(['namespace' => 'Auth'], function () {

    Route::get('login', 'LoginController@showLoginForm')->name('login');

    Route::post('login', 'LoginController@login')->name('loginPost');
    Route::post('logout', 'LoginController@logout')->name('logout');

});


