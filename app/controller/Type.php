<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\util\Res;
use app\model\Type as TypeModel;

class Type extends BaseController{
    private $result;
    public function __construct(\think\App $app){
        $this->result = new Res();
    }

    public function add(Request $request){
        $type = new TypeModel([
            "type"=>$request->post("type")
        ]);

        $res = $type->save();

        if(!$res){
            return $this->result->error("添加数据失败");
        }
        return $this->result->success("添加数据成功",$type);
    }

    public function delete($id){
        $res = TypeModel::where("id",$id)->delete();
        if($res){
            return $this->result->success("删除数据成功",$res);
        }
        return $this->result->error("删除数据失败");
    }

    public function getAll(){
        $list = TypeModel::where("close",0)->select();
        return $this->result->success("获取数据成功",$list);
    }

    public function page(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("pageSize",10);
        $type = $request->param("type");

        $list = TypeModel::where("type","list","%{$type}%")->paginate([
            "page"=>$page,
            "pageSize"=>$pageSize
        ]);

        return $this->result->success("获取数据成功",$list);
    }

}
