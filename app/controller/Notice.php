<?php
namespace app\controller;

use think\Request;
use app\model\Notice as NoticeModel;
use app\BaseController;
use app\util\Res;

class Notice extends BaseController{
    protected $result;
    public function __construct(\think\App $app){
        $this->result = new Res();
    }

    public function add(Request $request){
        $postData = $request->post();
        $notice = new NoticeModel([
            "title"=>$postData["title"],
            "content"=>$postData["content"],
            "add_time"=>date("Y-m-d H:i:s")
        ]);

        $res = $notice->save();
        if($res){
            return $this->result->success("添加公告成功",$notice);
        }
        return $this->result->error("添加公告失败");
    }

    public function deleteById($id){
        $res = NoticeModel::where("id",$id)->delete();
        if($res){
            return $this->result->success("删除数据成功",$res);
        }
        return $this->result->error("删除数据失败");
    }

    public function getAll(){
        $list = NoticeModel::select();
        return $this->result->success("获取数据成功",$list);
    }

    public function page(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("pageSize",10);
        $title = $request->param("title");

        $list = NoticeModel::where("title","like","%{$title}%")->paginate([
            "page"=>$page,
            "list_rows"=>$pageSize
        ]);
        return $this->result->success("获取数据成功",$list);
    }

}