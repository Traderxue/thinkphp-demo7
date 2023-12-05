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
}