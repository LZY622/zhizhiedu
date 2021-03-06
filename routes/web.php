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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/ceshi',function(){
//     $data = ['status'=>1,'data'=>'liziyue'];
//     return response()->json($data);
// });
Route::get('/','Student\IndexController@index');
// 后台路由
Route::get('/admin/login','Admin\IndexController@login');
Route::get('/admin/signup','Admin\IndexController@signup');
Route::post('/admin/signup','Admin\IndexController@do_signup');
Route::get('/admin/code','Admin\IndexController@pic_code');
Route::post('/admin/do_login','Admin\IndexController@do_login');
Route::get('/admin/loginout','Admin\IndexController@loginout');
// 无权限页面路由(权限中间件名字‘admin_hasrole’)
Route::get('/admin/nopermission','Admin\IndexController@nopermission');
Route::group(['middleware'=>['admin_login'],'namespace'=>'Admin','prefix'=>'admin'],function(){
    Route::get('/','IndexController@index');
    Route::get('/message','IndexController@message');
    Route::get('/message/{id}','IndexController@messageid');
    Route::get('/zhexian','IndexController@zhexian');
    Route::get('/setuser','IndexController@setuser');
    Route::post('/setuser','IndexController@do_setuser');
    Route::resource('/adminuser', 'AdminUserController');
    Route::resource('/teauser', 'TeaUserController');
    Route::get('/stuuser/select_num/{id}','StuUserController@select_num');
    // 课时数模块包含在用户模块里面
    Route::get('/stuuser/select_all','StuUserController@select_all');
    Route::resource('/stuuser', 'StuUserController');
    Route::resource('/classcate', 'ClassCateController');
    Route::resource('/tea_sclass', 'TeaSclassController');
    Route::get('/stu_sclass/book_info', 'StuSclassController@book_info');
    Route::post('/stu_sclass/upload_update', 'StuSclassController@upload_update');
    Route::resource('/stu_sclass', 'StuSclassController');
    Route::post('/stu_wcorrect/upload_update', 'StuWcorrectController@upload_update');
    Route::get('/stu_wcorrect/download_file/{type}/{id}', 'StuWcorrectController@download_file');
    Route::get('/stu_wcorrect/shenhe/{id}', 'StuWcorrectController@shenhe');
    Route::resource('/stu_wcorrect', 'StuWcorrectController');
    Route::resource('/tea_wcorrect', 'TeaWcorrectController');
    // 前台控制
    Route::get('/guanwang/seo','HeadController@seo');
    Route::get('/guanwang/banner','HeadController@banner');
    Route::post('/guanwang/up_banner','HeadController@up_banner');
    Route::get('/guanwang/lunbo','HeadController@lunbo');
    Route::get('/guanwang/lunbo_shan/{id}','HeadController@lunbo_shan');
    Route::post('/guanwang/up_lunbo','HeadController@up_lunbo');
    Route::get('/guanwang/add_lunbo','HeadController@add_lunbo');
    Route::get('/guanwang/notice','HeadController@notice');
    Route::post('/guanwang/notice_upd','HeadController@notice_upd');
});
//角色权限操作
Route::group(['middleware'=>['admin_login'],'prefix'=>'rp'],function(){
    Route::post('/role/addp','Auth\RPController@addp');
    Route::post('/role/deletep/{id}','Auth\RPController@deletep');
    Route::post('/role/{id}/showp','Auth\RPController@showp');
    Route::resource('/role','Auth\RPController');
});
// 老师端路由
Route::get('/teacher/login','Teacher\IndexController@login');
Route::get('/teacher/signup','Teacher\IndexController@signup');
Route::post('/teacher/signup','Teacher\IndexController@do_signup');
Route::get('/teacher/code','Teacher\IndexController@pic_code');
Route::post('/teacher/do_login','Teacher\IndexController@do_login');
Route::get('/teacher/loginout','Teacher\IndexController@loginout');
// 无权限页面路由(权限中间件名字‘teacher_hasrole’)
Route::get('/teacher/nopermission','Teacher\IndexController@nopermission');
Route::group(['middleware'=>['teacher_login'],'namespace'=>'Teacher','prefix'=>'teacher'],function(){
    Route::get('/','IndexController@index');
    Route::get('/setuser','IndexController@setuser');
    Route::post('/setuser','IndexController@do_setuser');
    Route::resource('/tea_sclass', 'TeaSclassController');
    Route::get('/stu_sclass/book_info', 'StuSclassController@book_info');
    Route::post('/stu_sclass/upload_update', 'StuSclassController@upload_update');
    Route::resource('/stu_sclass', 'StuSclassController');
    Route::post('/stu_wcorrect/upload_update', 'StuWcorrectController@upload_update');
    Route::get('/stu_wcorrect/download_file/{type}/{id}', 'StuWcorrectController@download_file');
    Route::get('/stu_wcorrect/shenhe/{id}', 'StuWcorrectController@shenhe');
    Route::resource('/stu_wcorrect', 'StuWcorrectController');
    Route::resource('/tea_wcorrect', 'TeaWcorrectController');

});



// 前台学生
Route::get('/login','Student\IndexController@login');
Route::get('/signup','Student\IndexController@signup');
Route::post('/zhuce','Student\IndexController@do_signup');
Route::post('/do_login','Student\IndexController@do_login');
Route::get('/youke','Student\IndexController@youke');
Route::get('/lunbo','Student\IndexController@lunbo');
Route::get('/forget','Student\IndexController@forget');
// 无权限页面路由(权限中间件名字‘student_hasrole’)
Route::get('/nopermission','Student\IndexController@nopermission');
Route::get('/loginout','Student\IndexController@loginout');
Route::get('/sendcode','Student\IndexController@sendCode');
Route::group(['middleware'=>['student_login'],'namespace'=>'Student'],function(){
    Route::get('/students/setuser','IndexController@setuser');
    Route::post('/students/do_setuser','IndexController@do_setuser');
    Route::get('/students','IndexController@student');
});
Route::group(['middleware'=>['student_login'],'namespace'=>'Student','prefix'=>'students'],function(){
     Route::resource('/stu_sclass', 'StuSclassController');
     Route::resource('/stu_wcorrect', 'StuWcorrectController');
});
