<?php

namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\User as UserModel;
use app\util\Res;

class User extends BaseController
{
    private $result;

    public function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    public function register(Request $request)
    {
        $username = $request->post("username");
        $password = password_hash($request->post("password"), PASSWORD_DEFAULT);

        $u = UserModel::where("username", $username)->find();

        if ($u) {
            return $this->result->error("注册失败,用户已存在");
        }

        $user = new UserModel([
            "username" => $username,
            "password" => $password
        ]);

        $res = $user->save();

        if ($res) {
            return $this->result->success("注册成功", $user);
        }
        return $this->result->error("注册失败");
    }

    public function login(Request $request)
    {
        $username = $request->post("username");
        $password = $request->post("password");

        $user = UserModel::where("username", $username)->where("disable", 0)->find();

        if (!$user) {
            return $this->result->error("用户不存在或被冻结");
        }

        if (password_verify($password, $user->password)) {
            return $this->result->success("登录成功", $user);
        }

        return $this->result->error("用户名或秘密错误，登录失败");
    }

    public function freeze($id)
    {
        $user = UserModel::where("id", $id)->find();
        $res = $user->save([
            "disable" => 1
        ]);
        if ($res) {
            return $this->result->success("冻结用户成功", $user);
        }
        return $this->result->error("冻结用户失败");
    }

    public function update(Request $request)
    {
        $id = $request->post("id");
        $user = UserModel::where("id", $id)->find();
        $res = $user->save([
            "email" => $request->post("email"),
            "id_card" => $request->post("id_card"),
            "credit" => $request->post("credit"),
            "name" => $request->post("name")
        ]);

        if ($res) {
            return $this->result->success("更新数据成功", $user);
        }
        return $this->result->error("更新数据失败");
    }

    public function deleteById($id)
    {
        $res = UserModel::where("id", $id)->delete();
        if ($res) {
            return $this->result->success("删除成功", $res);
        }
        return $this->result->error("删除失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page", 1);
        $pageSize = $request->param("pageSize", 10);
        $name = $request->param("name");

        $list = UserModel::where("name", "like", "%{$name}%")->paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);

        return $this->result->success("获取数据成功", $list);
    }

    public function getById($id)
    {
        $user = UserModel::where("id", $id)->find();
        if (!$user) {
            return $this->result->error("用户不存在");
        }
        return $this->result->success("获取数据成功", $user);
    }

    public function updatePassword(Request $request)
    {
        $username = $request->post("username");
        $password = $request->post("password");
        $new_password = $request->post("new_password");

        $user = UserModel::where("username", $username)->find();

        if (!password_verify($password, $user->password)) {
            return $this->result->error("旧密码错误");
        }
        $res = $user->save([
            "password" => password_hash($new_password, PASSWORD_DEFAULT)
        ]);
        if ($res) {
            return $this->result->success("修改密码成功", $user);
        }
        return $this->result->error("修改密码失败");
    }

    public function editCredit(Request $request){
        $id = $request->post("id");
        $credit = $request->post("credit");

        $user = UserModel::where("id",$id)->find();

        $res = $user->save([
            "credit"=>$credit
        ]);

        if(!$res){
            return $this->result->error("编辑失败");
        }
        return $this->result->success("编辑成功",$user);

    }
}
