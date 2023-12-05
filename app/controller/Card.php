<?php
namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\Card as CardModel;
use app\util\Res;

class Card extends BaseController{
    protected $result;

    public function __construct(\think\App $app){
        $this->result = new Res();
    }

    public function add(Request $request){
        $postData = $request->post();
        $card = new CardModel([
            "name"=>$postData["name"],
            "card"=>$postData["card"],
            "bank"=>$postData["bank"]
        ]);
        $res = $card->save();
        if($res){
            return $this->result->success("添加数据成功",$card);
        }
        return $this->result->error("添加数据失败");
    }

    public function edit(Request $request){
        $postData = $request->post();
        $card = CardModel::where("id",$postData["id"])->find();
        $res = $card ->save([
            "name"=>$postData["name"],
            "card"=>$postData["card"],
            "bank"=>$postData["bank"]
        ]);

        if($res){
            return $this->result->success("编辑数据成功",$card);
        }
        return $this->result->error("编辑数据失败");
    }

    public function get($id){
        $card = CardModel::where("id",$id)->find();
        return $this->result->success("获取数据成功",$card);
    }

}