<?php 
namespace app\controller;

use think\Request;
use app\BaseController;
use app\util\Res;
use app\model\Mining as MiningModel;

class Mining extends BaseController{
    protected $result;

    public function __construct(\think\App $app){
        $this->result = new Res();
    }

    public function add(Request $request){
        $post = $request->post();
        $mining = new MiningModel([
            "cycle" => $post["cycle"] ,
            "income" => $post["income"],
            "amount"=>$post["amount"],
            "rate"=>$post["rate"]
        ]);
        $res = $mining->save();
        if($res){
            return $this->result->success("添加数据成功",$mining);
        }
        return $this->result->error("添加数据失败");
    }

    function edit(Request $request){
        $postData = $request->post();

        $mining = MiningModel::where("id",$$postData["id"])->find();

        $res = $mining->save([
            "cycle"=>$postData["id"],
            "income"=>$postData["income"],
            "amount"=>$postData["amount"],
            "rate"=>$postData["rate"]
        ]);

        if($res){
            return $this->result->success("编辑数据成功",$mining);
        }
        return $this->result->error("编辑数据失败");
    }

    function getAll(){
        $list = MiningModel::select();
        return $this->result->success("获取数据成功",$list);
    }

    function getById($id){
        $mining = MiningModel::where("id",$id)->find();
        return $this->result->success("获取数据成功",$mining);
    }

    function page(Request $request){
        $page = $request->param("page");
        $pageSize = $request->param("pageSize");
        $list = MiningModel::paginate([
            "page"=>$page,
            "list_rows"=>$pageSize
        ]);
        return $this->result->success("获取数据成功",$list);
    }

    function deleteById($id){
        $res = MiningModel::destroy($id);
        if($res){
            return $this->result->success("删除数据成功",$res);
        }
        return $this->result->error("删除数据失败");

    }
}