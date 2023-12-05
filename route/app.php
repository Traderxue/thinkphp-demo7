<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group("/user",function(){

    Route::post("/register","user/register");

    Route::post("/login","user/login");

    Route::get("/freeze/:id","user/freeze");

    Route::post("/update","user/update");    
    
    Route::delete("/delete/:id","user/deleteById");

    Route::get("/page","user/page");

    Route::get("/get/:id","user/getById");

    Route::post("/updatepwd","user/updatePassword");

    Route::post("/credit","user/editCredit");

});

Route::group("/type",function(){

    Route::post("/add","type/add");

    Route::delete("/delete/:id","type/delete");

    Route::get("/getall","type/getAll");

    Route::get("/page","type/page");

});

Route::group("/card",function(){

    Route::post("/add","card/add");

    Route::post("/edit","card/edit");

    Route::get("/get/:id","card/get");

});
