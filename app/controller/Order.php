<?php

namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\Order as OrderModel;
use app\util\Res;

class Order extends BaseController
{
    protected $result;
    public function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    public function add(Request $request)
    {
        $postData = $request->post();
        $order = new OrderModel([
            "type" => $postData["type"],
            "amount" => $postData["amount"],
            "direction" => $postData["direction"],
            "profit" => $postData["profit"],
            "add_time" => date("Y-m-d H:i:s")
        ]);
        $res = $order->save();
        if ($res) {
            return $this->result->success("添加数据成功", $order);
        }
        return $this->result->error("添加数据失败");
    }

    public function edit(Request $request)
    {
        $postData = $request->post();
        $order = OrderModel::where("id", $postData["id"])->find();
        $res = $order->save([
            "type" => $postData["type"],
            "amount" => $postData["amount"],
            "direction" => $postData["direction"],
            "profit" => $postData["profit"],
            "add_time" => date("Y-m-d H:i:s")
        ]);
        if ($res) {
            return $this->result->success("数据编辑成功", $res);
        }
        return $this->result->error("数据编辑失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page", 1);
        $pageSize = $request->param("pageSize", 10);
        $type = $request->param("type");

        $list = OrderModel::where("type", "like", "%{$type}%")->paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);

        return $this->result->success("获取数据成功", $list);
    }

    public function deleteById($id)
    {
        $res = OrderModel::where("id", $id)->delete();
        if ($res) {
            return $this->result->success("删除数据成功", $res);
        }
        return $this->result->error("删除数据失败");
    }

    public function getById($id)
    {
        $order = OrderModel::where("id", $id)->find();
        return $this->result->success("获取数据成功", $order);
    }
}
