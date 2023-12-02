<?php
namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\User as UserModel;
use app\util\Res;

class User extends BaseController{
    private $result;

    public function __construct(\think\App $app){
        $this->result = new Res();
    }

    public function register(Request $request){
        $username = $request->post("username");
        $password =password_hash($request->post("password"),PASSWORD_DEFAULT);

        $u = UserModel::where("username",$username)->find();

        if($u){
            return $this->result->error("注册失败,用户已存在");
        }

        $user = new UserModel([
            "username"=>$username,
            "password"=>$password
        ]);

        $res = $user->save();

        if($res){
            return $this->result->success("注册成功",$user);
        }
        return $this->result->error("注册失败");
    }

    public function login(Request $request){
        $username = $request->post("username");
        $password = $request->post("password");

        $user = UserModel::where("username",$username)->where("disable",0)->find();

        if(!$user){
            return $this->result->error("用户不存在或被冻结");
        }

        if(password_verify($password,$user->password)){
            return $this->result->success("登录成功",$user);
        }

        return $this->result->error("登录失败");

    }

    public function freeze($id){
        $user = UserModel::where("id",$id)->find();
        $res = $user->save([
            "disable"=>1
        ]);
        if($res){
            return $this->result->success("冻结用户成功",$user);
        }
        return $this->result->error("冻结用户失败");
    }
}