<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\Admin;
use Session;

class IndexController extends Controller
{   
    /**
     * 后台登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {
        $username = $request->input('username', '');
        $password = $request->input('password', '');
        $validate_code = strtolower($request->input('code','')); 

        $m3_result = new M3Result;

        if (Session::get('validate_code') != $validate_code) {
            $m3_result->status = 3;
            $m3_result->message = "验证码错误";
        } elseif($username == '' || $password == '') {
            $m3_result->status = 1;
            $m3_result->message = "帐号或密码不能为空!";
        }else{
            $admin = Admin::where('username', $username)->where('password', md5('bk'. $password))->first();
            if(!$admin) {
                $m3_result->status = 2;
                $m3_result->message = "帐号或密码错误!";
            } else {
                $m3_result->status = 0;
                $m3_result->message = "登录成功!";
                $request->session()->put('admin', $admin);
            }
        }
        return $m3_result->toJson();
    }

    /**
     * 后台登录页面
     * @return [type] [description]
     */
    public function toLogin()
    {
        return view('admin.login');
    }

    /**
     * 退出登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toExit(Request $request)
    {
        $request->session()->forget('admin');
        return view('admin.login');
    }

    /**
     * 后台首页
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toIndex(Request $request)
    {
        $admin = $request->session()->get('admin');
        return view('admin.index')->with('admin', $admin);
    }

    /**
     * 后台欢迎页面
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function welcome(Request $request){
        $data = [
            'HTTP_HOST' => $request->server()['HTTP_HOST'],
            'DOCUMENT_ROOT' => $request->server()['DOCUMENT_ROOT'],
            'SERVER_SOFTWARE' => $request->server()['SERVER_SOFTWARE'],
            'SERVER_PORT' => $request->server()['SERVER_PORT'],
            'PHP_VERSION' =>  PHP_VERSION,
        ];
        return view('admin.welcome',['data'=>$data]);
    }
}
