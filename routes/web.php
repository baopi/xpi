<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Repositories\CategoryRepository;
use App\Repositories\VideoRepository;
use App\Repositories\TagRepository;
use App\Repositories\SubjectRepository;
use App\Tools\Fomatter\End;

$router->get('/', function () use ($router) {
        return $router->app->version();
});

/**
 * 获取分类信息
 */
$router->get('/categories/app[/{appId:[0-9]+}]', function ($appId = null) {
    if (is_null($appId))
        return End::toSuccessJson(CategoryRepository::get());
    else
        return End::toSuccessJson(CategoryRepository::getByApp($appId));
});

/**
 * 获取分类下视频
 */
$router->get('/categories/videos', function (\Illuminate\Http\Request $request) {
    return End::toSuccessJson(VideoRepository::getByCategory($request->get('category_ids') ?: [], $request->get('page') ?: [], $request->get('order')));
});

/**
 * 获取标签信息
 */
$router->get('/tags/app[/{appId:[0-9]+}]', function ($appId = null) {
    if (is_null($appId))
        return End::toSuccessJson(TagRepository::get());
    else {
        return End::toSuccessJson(TagRepository::getByApp($appId));
    }
});

/**
 * 获取标签下视频
 */
$router->get('/tags/videos', function (\Illuminate\Http\Request $request) {
    return End::toSuccessJson(VideoRepository::getByTag($request->get('tag_ids') ?: [], $request->get('page') ?: [], $request->get('order')));
});

/**
 * 获取主题信息
 */
$router->get('/subjects/app[/{appId:[0-9]+}]', function ($appId = null) {
    if (is_null($appId))
        return End::toSuccessJson(SubjectRepository::get());
    else {
        return End::toSuccessJson(SubjectRepository::getByApp($appId));
    }
});

/**
 * 获取主题下视频
 */
$router->get('/subjects/videos', function (\Illuminate\Http\Request $request) {
   return End::toSuccessJson(VideoRepository::getBySubject($request->get('subject_ids') ?: [], $request->get('page') ?: [], $request->get('order')));
});

/**
 * 根据分类获取主题
 */
$router->get('/subjects/categories', function (\Illuminate\Http\Request $request) {
   return End::toSuccessJson(SubjectRepository::getByCategory($request->get('category_ids') ?: []));
});

/**
 * 获取视频列表
 */
$router->get('/videos', function (\Illuminate\Http\Request $request) {
    return End::toSuccessJson(VideoRepository::get($request->get('ids') ?: [], $request->get('page') ?: [], $request->get('order')));
});

/**
 * 获取某条视频
 */
$router->get('/video/{id:[0-9]+}', function ($id) {
    return End::toSuccessJson(VideoRepository::find($id) ?: []);
});

/**
 * 会员注册
 */
$router->post('/register', 'Auth\RegisterController@register');

/**
 * 会员登录
 */
$router->post('/login', 'Auth\LoginController@login');

/**
 * 找回密码发送验证码
 */
$router->post('/forget-password/send-code', 'Auth\ForgetController@sendVerifyCode');

/**
 * 找回密码重置密码
 */
$router->post('/forget-password/reset', 'Auth\ForgetController@resetPassword');

/**
 * 需登录校验的模块
 */
$router->group(['middleware' => 'auth'], function () use ($router) {
    /**
     * 重置密码
     */
    $router->post('/reset/password', 'UserController@resetPassword');

    /**
     * 获取用户观看视频记录
     */
    $router->get('/user/video/records', 'UserController@getSeeVideoRecords');

    /**
     * 用户收藏视频
     */
    $router->get('/user/video/{videoId:[0-9]+}/collect', 'UserController@collectVideo');

    /**
     * 获取用户收藏视频记录
     */
    $router->get('/user/video/collect', 'UserController@getCollectVideos');
});

/**
 * 搜索视频
 */
$router->post('/search-videos', 'SearchController@searchVideos');

/**
 * 用户观看视频
 */
$router->get('/user/see/video/{videoId:[0-9]+}', 'UserController@seeVideo');



